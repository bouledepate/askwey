<?php

/**
 * @var \yii\data\ActiveDataProvider $questionsDataProvider
 * @var \Askwey\App\Models\Answer $answerForm
 */

$this->title = 'Перечень ваших вопросов/ответов';

use kartik\alert\Alert;
use yii\bootstrap5\Html;

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
                    <a href="<?= \yii\helpers\Url::to(['profile/index']) ?>" class="btn btn-light shadow-sm" type="button">Ваш профиль</a>
                    <a href="<?= \yii\helpers\Url::to(['profile/questions']) ?>" class="btn btn-light shadow-sm"
                       type="button">Вопросы для вас <?php
                        $count = Yii::$app->user->identity->getCountOfAllNewQuestions();
                        if ($count > 0)
                            echo "<span class='badge bg-secondary rounded-pill'>$count</span>"
                        ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-9">
        <div class="d-flex border-bottom mb-2 pb-2">
            <div class="flex-grow-1">
                <span class="fs-4 fw-bold">Перечень всех ваших вопросов и ответов</span>
            </div>
        </div>
        <?= \yii\widgets\ListView::widget([
            'dataProvider' => $questionsDataProvider,
            'itemView' => 'partial/_own_question'
        ]) ?>
    </div>
</div>