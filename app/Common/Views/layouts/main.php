<?php
/**
 * @var $this \yii\web\View
 * @var string $content
 */

use kartik\alert\Alert;
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
        <?= $content ?>
    </div>
    <?= $this->render('_end_body') ?>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>