<?php
/**
 * @var $this \yii\web\View
 * @var string $content
 */

use kartik\alert\Alert;
use yii\helpers\Html;
use yii\helpers\Url;

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
        <div class="d-flex bd-highlight mb-3 border-bottom">
            <div class="me-auto p-2 bd-highlight">
                <h2>Askwey</h2>
            </div>
            <?php if (Yii::$app->user->isGuest) { ?>
                <div class="p-2 bd-highlight">
                    <a class="btn btn-success" href="<?= Url::to(['auth/sign-up']) ?>">Зарегистрироваться</a>
                </div>
                <div class="p-2 bd-highlight">
                    <a class="btn btn-primary" href="<?= Url::to(['auth/sign-in']) ?>">Войти</a>
                </div>
            <?php } else { ?>
                <div class="p-2 bd-highlight">
                    <a class="btn btn-secondary" href="<?= Url::to(['auth/sign-out']) ?>">Выйти</a>
                </div>
            <?php } ?>
        </div>
        <?= $content ?>
    </div>
    <?= $this->render('_end_body') ?>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>