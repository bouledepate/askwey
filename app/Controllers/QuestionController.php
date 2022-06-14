<?php

namespace Askwey\App\Controllers;

use Askwey\App\Enums\QuestionState;
use Askwey\App\Models\Question;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class QuestionController extends Controller
{
    private Question $question;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['hide', 'delete'],
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    public function actionHide(int $questionId)
    {
        $this->getQuestion($questionId);

        if ($this->question->author_id !== \Yii::$app->user->id)
            throw new ForbiddenHttpException('У вас нет доступа к редактированию данного вопроса.');

        if ($this->question->state !== QuestionState::HIDDEN->value) {
            $state = QuestionState::HIDDEN;
        } elseif (!empty($this->question->getAnswers()->all())) {
            $state = QuestionState::HAS_ANSWER;
        } else {
            $state = QuestionState::NEW;
        }

        if ($this->question->updateState($state)) {
            if ($state == QuestionState::HIDDEN)
                \Yii::$app->session->setFlash('success', 'Этот вопрос более не показывается у других пользователей или на вашей странице.');
            else
                \Yii::$app->session->setFlash('success', 'Этот вопрос снова показывается у других пользователей или на вашей странице.');
        } else {
            \Yii::$app->session->setFlash('error', 'При скрытии вопроса произошла ошибка. Попробуйте позднее или обратитесь в поддержку.');
        }

        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDelete(int $questionId)
    {
        $this->getQuestion($questionId);
        $this->question->updateState(QuestionState::DELETED)
            ? \Yii::$app->session->setFlash('success', 'Вопрос был удалён.')
            : \Yii::$app->session->setFlash('error', 'При удалении вопроса произошла ошибка. Попробуйте позднее или обратитесь в поддержку.');

        return $this->redirect(\Yii::$app->request->referrer);
    }

    private function getQuestion(int $questionId): void
    {
        $question = Question::findOne(['id' => $questionId]);

        if (!$question)
            throw new NotFoundHttpException('Вопрос в системе не найден.');

        $this->question = $question;
    }
}