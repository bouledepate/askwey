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
        <div class="row">
            <div class="d-flex bd-highlight mb-3 border-bottom">
                <div class="me-auto p-2 bd-highlight">
                    <a class="fs-2 fw-bold text-black text-decoration-none" href="<?= Url::to(['/']) ?>">Askwey</a>
                </div>
                <?php if (Yii::$app->user->isGuest) { ?>
                    <div class="p-2 bd-highlight">
                        <a class="btn btn-outline-success" href="<?= Url::to(['auth/sign-up']) ?>">Зарегистрироваться</a>
                    </div>
                    <div class="p-2 bd-highlight">
                        <a class="btn btn-outline-primary" href="<?= Url::to(['auth/sign-in']) ?>">Войти</a>
                    </div>
                <?php } else { ?>
                    <div class="p-2 bd-highlight">
                    <span class="text-muted me-3">
                        Вы авторизованы, как <a class="text-decoration-none fw-bold text-muted"
                                                href="<?= Url::to(['profile/index']) ?>"><?= Yii::$app->user->identity->username ?></a>
                    </span>
                        <a class="btn btn-outline-secondary" href="<?= Url::to(['auth/sign-out']) ?>">Выйти</a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?= $content ?>
    </div>
    <?= $this->render('_end_body') ?>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>