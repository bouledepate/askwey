<?php

declare(strict_types=1);

namespace Askwey\App\Controllers;

use Askwey\App\Components\ReservedNamesChecker;
use Askwey\App\Enums\QuestionState;
use Askwey\App\Models\Answer;
use Askwey\App\Models\Question;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use Askwey\App\Models\User\User;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class ProfileController extends Controller
{
    public ?User $user = null;

    public function behaviors()
    {
        return [
            // todo: Реализовать проверку на использование служебных имён.
//            'nameChecker' => [
//                'class' => ReservedNamesChecker::class,
//                'actions' => [
//                    'index' => ['username']
//                ]
//            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@', '?']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['settings', 'questions', 'own-questions', 'hide-question'],
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    public function actionIndex(string $username = null)
    {
        if (is_null($username) && \Yii::$app->user->isGuest)
            return $this->redirect(['auth/sign-in']);

        $this->getUser($username ?? \Yii::$app->user->identity->username);

        $questionForm = new Question();
        if (\Yii::$app->request->isPost)
            return $this->questionFormValidation($questionForm);

        $questions = new ActiveDataProvider([
            'query' => $this->user->getAllOwnPublicQuestions()
        ]);

        return $this->render('index', [
            'model' => $this->user,
            'questionForm' => $questionForm,
            'questions' => $questions
        ]);
    }

    public function actionSettings()
    {
        $this->getUser(\Yii::$app->user->identity->username);

        if (\Yii::$app->request->post('hasEditable'))
            return $this->handleAjaxProcessing();

        return $this->render('settings', ['model' => $this->user]);
    }

    public function actionQuestions()
    {
        $answerForm = new Answer();

        $questionsDataProvider = new ActiveDataProvider([
            'query' => \Yii::$app->user->identity->getAllQuestions(),
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        return $this->render('questions', [
            'questionsDataProvider' => $questionsDataProvider,
            'answerForm' => $answerForm
        ]);
    }

    public function actionOwnQuestions()
    {
        $questionsDataProvider = new ActiveDataProvider([
            'query' => \Yii::$app->user->identity->getAllOwnQuestions(),
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        return $this->render('own_questions', [
            'questionsDataProvider' => $questionsDataProvider
        ]);
    }

    public function actionHideQuestion(int $questionId)
    {
        $question = Question::findOne(['id' => $questionId]);

        if (!$question)
            throw new NotFoundHttpException('Вопрос в системе не найден.');

        if ($question->author_id !== \Yii::$app->user->id)
            throw new ForbiddenHttpException('У вас нет доступа к редактированию данного вопроса.');

        $question->state == QuestionState::HIDDEN->value
            ? $state = QuestionState::NEW
            : $state = QuestionState::HIDDEN;

        if ($question->updateState($state)) {
            if ($state == QuestionState::HIDDEN)
                \Yii::$app->session->setFlash('success', 'Этот вопрос более не показывается у других пользователей или на вашей странице.');
            else
                \Yii::$app->session->setFlash('success', 'Этот вопрос снова показывается у других пользователей или на вашей странице.');
        } else {
            \Yii::$app->session->setFlash('error', 'При скрытии вопроса произошла ошибка. Попробуйте позднее или обратитесь в поддержку.');
        }

        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDeleteQuestion(int $questionId)
    {

    }

    private function getUser(string $username): void
    {
        $user = User::findByUsername($username);

        if (!$user)
            throw new NotFoundHttpException("Пользователь $username не найден.");

        $this->user = $user;
    }

    private function handleAjaxProcessing()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (\Yii::$app->request->post('ProfileSettings')) {
            if ($this->user->profile->settings->load($_POST))
                $this->user->profile->settings->update();
        } else {
            if ($this->user->profile->load($_POST))
                $this->user->profile->update();
        }

        return [
            'output' => null,
            'error' => null
        ];
    }

    private function questionFormValidation(Question &$model)
    {
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            $message = !empty($model->member_id)
                ? 'Ваш вопрос отправлен пользователю ' . $model->member->profile->getProfileName()
                : 'Ваш вопрос опубликован на вашей странице.';

            \Yii::$app->session->setFlash('success', $message);
        } else
            \Yii::$app->session->setFlash('error', 'Вопрос не удалось отправить. Попробуйте позднее.');

        return $this->redirect(\Yii::$app->request->referrer);
    }
}