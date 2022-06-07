<?php
/**
 * @var $this \yii\web\View
 * @var string $content
 */

use yii\helpers\Html;

?>
    <!doctype html>
    <?php $this->beginPage() ?>
    <html lang="ru">
    <head>
        <?= $this->render('_head') ?>
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <?= $this->render('_begin_body') ?>
    <div class="container">
        <div class="d-flex justify-content-between py-3 mb-3 border-bottom">
            <h2>Панель администратора</h2>
            <?= Yii::$app->user->isGuest ? '<button class="btn btn-primary">Sign in</button>' : '<button class="btn btn-secondary">Sign out</button>' ; ?>
        </div>
        <?= $content ?>
    </div>
    <?= $this->render('_end_body') ?>
    <?php $this->endBody() ?>
    </body>
    </html>

<?php $this->endPage() ?>