<?php

/** @var \Askwey\App\Models\Question $model */

/** @var \Askwey\App\Models\Answer $form */

use Askwey\App\Enums\QuestionState;
use kartik\form\ActiveForm;
use yii\bootstrap5\Html;

?>

<div class="card">
    <div class="card-body">
        <p class="card-subtitle mb-2 text-muted"><?= Yii::$app->formatter->asDatetime($model->date_create) ?></p>
        <p class="card-text"><?= Html::encode($model->description) ?></p>
        <?php if (Yii::$app->user->isGuest) { ?>
            <div class="row">
                <div class="col-8">
                    <p>
                        <button class="btn btn-light shadow-sm" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-<?= $model->id ?>" aria-expanded="false" aria-controls="collapse-<?= $model->id ?>">
                            Раскрыть
                        </button>
                    </p>
                    <div class="collapse" id="collapse-<?= $model->id ?>">
                        <div class="card card-body">
                            <?php $htmlForm = \kartik\form\ActiveForm::begin([
                                'id' => 'answer-form-to-question-' . $model->id,
                                'enableAjaxValidation' => false,
                                'type' => ActiveForm::TYPE_FLOATING,
                                'fieldConfig' => ['options' => ['class' => 'form-group mb-3 mr-2 me-2']]
                            ]) ?>
                            <?= $htmlForm->field($form, 'description')->textarea()->label(false) ?>
                            <?= $htmlForm->field($form, 'question_id')->hiddenInput(['value' => $model->id])->label(false) ?>
                            <?= Html::submitButton('Ответить', ['class' => 'btn btn-primary mr-1 shadow-sm']) ?>
                            <?php \kartik\form\ActiveForm::end() ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else {
            if ($model->author_id !== Yii::$app->user->id) { ?>
                <div class="row">
                    <div class="col-8">
                        <p>
                            <button class="btn btn-light shadow-sm" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-<?= $model->id ?>" aria-expanded="false" aria-controls="collapse-<?= $model->id ?>">
                                Раскрыть
                            </button>
                        </p>
                        <div class="collapse" id="collapse-<?= $model->id ?>">
                            <div class="card card-body">
                                <?php $htmlForm = \kartik\form\ActiveForm::begin([
                                    'id' => 'answer-form-to-question-' . $model->id,
                                    'enableAjaxValidation' => false,
                                    'type' => ActiveForm::TYPE_FLOATING,
                                    'fieldConfig' => ['options' => ['class' => 'form-group mb-3 mr-2 me-2']]
                                ]) ?>
                                <?= $htmlForm->field($form, 'description')->textarea()->label(false) ?>
                                <?= $htmlForm->field($form, 'is_anonymous')->checkbox() ?>
                                <?= $htmlForm->field($form, 'question_id')->hiddenInput(['value' => $model->id])->label(false) ?>
                                <?= $htmlForm->field($form, 'author_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>
                                <?= Html::submitButton('Ответить', ['class' => 'btn btn-primary mr-1 shadow-sm']) ?>
                                <?php \kartik\form\ActiveForm::end() ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
        } ?>
    </div>
</div>
