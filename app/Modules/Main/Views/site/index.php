<?php

/** @var \yii\web\View $this */

$this->title = 'Главная | Askwey' ?>

<div class="row">
    <?php if (Yii::$app->user->isGuest) { ?>
        <?= $this->render('_guest_block') ?>
    <?php } else { ?>
        <h2>Добро пожаловать, <?= Yii::$app->user->identity->username ?></h2>
    <?php } ?>
 </div>