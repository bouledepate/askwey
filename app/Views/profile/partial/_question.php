<?php

/** @var \Askwey\App\Models\Question $model */

/** @var \Askwey\App\Models\Answer $form */

use Askwey\App\Enums\QuestionState;
use kartik\form\ActiveForm;
use yii\bootstrap5\Html;

?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">
            <?= $model->state == QuestionState::NEW->value ? "<span class='badge bg-secondary rounded-pill'>Новый вопрос</span>" : ''; ?>
            <?= $model->is_anonymous
                ? 'Анонимный вопрос'
                : "Вопрос от пользователя <a class='text-decoration-none' href='/profile/{$model->author->username}'>{$model->author->profile->getProfileName()}</a>";
            ?>
        </h5>
        <p class="card-subtitle mb-2 text-muted"><?= Yii::$app->formatter->asDatetime($model->date_create) ?></p>
        <p class="card-text"><?= Html::encode($model->description) ?></p>
        <p>
            <button class="btn btn-sm btn-warning shadow-sm" type="button" data-bs-toggle="collapse"
                    data-bs-target="#question-<?= $model->id ?>" aria-expanded="false"
                    aria-controls="question-<?= $model->id ?>">
                Ответить на вопрос
            </button>
        </p>
        <div class="collapse" id="question-<?= $model->id ?>">
            <div class="card card-body">
                <?php $htmlForm = \kartik\form\ActiveForm::begin([
                    'id' => 'answer-form-to-question-' . $model->id,
                    'enableAjaxValidation' => false,
                    'type' => ActiveForm::TYPE_FLOATING,
                    'fieldConfig' => ['options' => ['class' => 'form-group mb-3 mr-2 me-2']]
                ]) ?>
                <?= $htmlForm->field($form, 'description')->textarea()->label(false) ?>
                <?= $htmlForm->field($form, 'is_public')->checkbox() ?>
                <?= $htmlForm->field($form, 'question_id')->hiddenInput(['value' => $model->id])->label(false) ?>
                <?= $htmlForm->field($form, 'author_id')->hiddenInput(['value' => Yii::$app->user->id ?? ''])->label(false) ?>
                <?= Html::submitButton('Отправить ответ', ['class' => 'btn btn-primary mr-1 shadow-sm']) ?>
                <?php \kartik\form\ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>
