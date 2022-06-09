<?php

/**
 * @var \yii\web\View $this
 * @var \Askwey\App\Common\Models\User\User $model
 * @var ActiveForm $form
 */

use yii\helpers\Html;
use kartik\form\ActiveForm;

$this->title = 'Панель регистрации' ?>

<div class="row">
    <div class="col-8">
        <?php
        $form = ActiveForm::begin([
            'id' => 'login-form-horizontal',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_X_SMALL],
            'options' => ['enctype' => 'multipart/form-data']
        ]);
        ?>
        <h4>Информация об аккаунте</h4>
        <?= $form->field($model, 'username') ?>
        <?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'passwordRepeat')->passwordInput() ?>

        <h4>Информация о вашем профиле</h4>
        <?= $form->field($model->profile, 'preferred_name') ?>
        <?= $form->field($model->profile, 'first_name') ?>
        <?= $form->field($model->profile, 'last_name') ?>
        <?= $form->field($model->profile, 'family_name') ?>
        <?= $form->field($model->profile, 'birthday')->textInput(['type' => 'date']) ?>
        <?= $form->field($model->profile, 'avatar')->fileInput() ?>
        <div class="form-group mb-3 row">
            <div class="col-sm-3"></div>
            <div class="col-sm-9">
                <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary mr-1']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-4">

    </div>
</div>