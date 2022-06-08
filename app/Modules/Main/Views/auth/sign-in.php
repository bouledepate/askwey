<?php

/**
 * @var \yii\web\View $this
 * @var \Askwey\App\Modules\Main\Models\Forms\LoginForm $model
 * @var ActiveForm $form
 */

use yii\helpers\Html;
use kartik\form\ActiveForm;

$this->title = 'Панель авторизации' ?>

<div class="row">
    <div class="col-4">
        <?php
        $form = ActiveForm::begin([
            'id' => 'login-form-vertical',
            'type' => ActiveForm::TYPE_FLOATING
        ]);
        ?>
        <?= $form->field($model, 'username') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <div class="form-group mb-3">
            <?= Html::submitButton('Авторизоваться', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>