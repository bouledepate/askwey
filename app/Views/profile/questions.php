<?php

/**
 * @var \yii\data\ActiveDataProvider $questionsDataProvider
 * @var \Askwey\App\Models\Answer $answerForm
 */

$this->title = 'Вопросы для вас';

use kartik\alert\Alert;
use yii\bootstrap5\Html;
use yii\data\ActiveDataProvider;

?>

<?php if (Yii::$app->session->hasFlash('success')) {
    echo Alert::widget([
        'type' => Alert::TYPE_SUCCESS,
        'icon' => 'fas fa-check-circle',
        'body' => Yii::$app->session->getFlash('success'),
        'showSeparator' => true,
        'delay' => 6000
    ]);
} elseif (Yii::$app->session->hasFlash('error')) {
    echo Alert::widget([
        'type' => Alert::TYPE_DANGER,
        'title' => 'Произошла ошибка.',
        'icon' => 'fas fa-times-circle',
        'body' => Yii::$app->session->getFlash('error'),
        'showSeparator' => true,
        'delay' => 6000
    ]);
} ?>

<div class="row">
    <div class="col-3">
        <div class="row">
            <div class="col">
                <?= Html::img(!empty(Yii::$app->user->identity->profile->avatar)
                    ? Yii::$app->request->baseUrl . '/static/' . Yii::$app->user->identity->profile->avatar
                    : 'http://placekitten.com/g/400/400', [
                    'class' => 'img-thumbnail']) ?>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <div class="d-grid gap-2">
                    <a href="<?= \yii\helpers\Url::to(['profile/index']) ?>" class="btn btn-light shadow-sm"
                       type="button">Ваш профиль</a>
                    <a href="<?= \yii\helpers\Url::to(['profile/own-questions']) ?>" class="btn btn-light shadow-sm"
                       type="button">Ваши вопросы / ответы</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-9">
        <div class="d-flex border-bottom mb-2 pb-2">
            <div class="flex-grow-1">
                <span class="fs-4 fw-bold">Новые вопросы для вас.</span>
            </div>
        </div>
        <?= \yii\widgets\ListView::widget([
            'dataProvider' => new ActiveDataProvider([
                'query' => \Yii::$app->user->identity->getQuestions()->where([
                    'state' => \Askwey\App\Enums\QuestionState::NEW->value,
                ])->orderBy(['state' => SORT_ASC, 'date_create' => SORT_DESC]),
                'pagination' => [
                    'pageSize' => 20
                ]
            ]),
            'itemView' => 'partial/_question',
            'viewParams' => [
                'form' => $answerForm
            ]
        ]) ?>
        <div class="d-flex border-bottom mb-2 pb-2">
            <div class="flex-grow-1">
                <span class="fs-4 fw-bold">Отвеченные вопросы</span>
            </div>
        </div>
        <?= \yii\widgets\ListView::widget([
            'dataProvider' => new ActiveDataProvider([
                'query' => \Yii::$app->user->identity->getQuestions()->where([
                    'state' => \Askwey\App\Enums\QuestionState::HAS_ANSWER->value,
                ])->orderBy(['state' => SORT_ASC, 'date_create' => SORT_DESC]),
                'pagination' => [
                    'pageSize' => 20
                ]
            ]),
            'itemView' => 'partial/_question',
            'viewParams' => [
                'form' => $answerForm
            ]
        ]) ?>
    </div>
</div>