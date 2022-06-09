<?php
/**
 * @var \yii\web\View $this
 * @var \Askwey\App\Common\Models\User\User $model
 */

use yii\bootstrap5\Html;

$this->title = $model->username === Yii::$app->user->identity->username
    ? 'Ваш профиль'
    : "Профиль $model->username"

?>
<div class="row">
    <div class="col-3">
        <div class="row">
            <div class="col">
                <?= Html::img(!empty($model->profile->avatar)
                    ? Yii::$app->request->baseUrl . '/static/' . $model->profile->avatar
                    : 'http://placekitten.com/g/400/400', [
                    'class' => 'img-thumbnail']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col">
                Подпись
            </div>
        </div>
    </div>
    <div class="col-9">
        <div class="row">
            <div class="col">
                <span class="fs-4 fw-bold"><?= $model->profile->getProfileName() ?></span>
            </div>
            <div class="col">
                Кнопки настроек
            </div>
        </div>
        <div class="row border-bottom mb-2 pb-2">
            <div class="col">
                <span class="fw-light fst-italic"><?= $model->profile->getProfileStatus() ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                Ещё инфа какая нибудь
            </div>
        </div>
        <div class="row">
            <div class="col">
                Записи тут
            </div>
        </div>
    </div>
</div>