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
        if ($questionForm->load(\Yii::$app->request->post()))
            return $this->questionFormValidation($questionForm);

        $answerForm = new Answer();
        if ($answerForm->load(\Yii::$app->request->post()))
            return $this->answerFormValidation($answerForm);

        $questions = new ActiveDataProvider([
            'query' => $this->user->getAllOwnPublicQuestions()
        ]);

        return $this->render('index', [
            'model' => $this->user,
            'questionForm' => $questionForm,
            'answerForm' => $answerForm,
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

        if (\Yii::$app->request->isPost)
            return $this->answerFormValidation($answerForm);

        return $this->render('questions', ['answerForm' => $answerForm]);
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
        if ($model->save()) {
            $message = !empty($model->member_id)
                ? 'Ваш вопрос отправлен пользователю ' . $model->member->profile->getProfileName()
                : 'Ваш вопрос опубликован на вашей странице.';

            \Yii::$app->session->setFlash('success', $message);
        } else
            \Yii::$app->session->setFlash('error', 'Вопрос не удалось отправить. Попробуйте позднее.');

        return $this->redirect(\Yii::$app->request->referrer);
    }

    private function answerFormValidation(Answer &$model)
    {
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            $model->question->updateState(QuestionState::HAS_ANSWER);
            $author = $model->question->author?->profile->getProfileName();
            \Yii::$app->session->setFlash('success', 'Ваш ответ отправлен пользователю ' . $author);
        } else
            \Yii::$app->session->setFlash('error', 'Ответ не удалось отправить. Попробуйте позднее.');

        return $this->redirect(\Yii::$app->request->referrer);
    }
}