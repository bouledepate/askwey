<?php

/** @var \yii\web\View $this */

use kartik\alert\Alert;

$this->title = 'Главная | Askwey' ?>

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
        'title' => 'Произошла ошибка',
        'icon' => 'fas fa-times-circle',
        'body' => Yii::$app->session->getFlash('error'),
        'showSeparator' => true,
        'delay' => 6000
    ]);
} ?>

<div class="row">
    <?php if (Yii::$app->user->isGuest) { ?>
        <?= $this->render('_guest_block') ?>
    <?php } else { ?>
        <h2>Добро пожаловать, <?= Yii::$app->user->identity->username ?></h2>
    <?php } ?>
 </div>