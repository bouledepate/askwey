<?php

/** @var \Askwey\App\Models\Question $model */

/** @var \Askwey\App\Models\Answer $form */

use Askwey\App\Enums\QuestionState;
use kartik\form\ActiveForm;
use yii\bootstrap5\Html;

?>

<div class="card">
    <div class="card-body d-flex">
        <div class="flex-grow-1">
            <h5 class="card-title">
                <?= \Askwey\App\Components\QuestionViewHelper::getQuestionTitle($model) ?>
            </h5>
            <p class="card-subtitle mb-2 text-muted"><?= Yii::$app->formatter->asDatetime($model->date_create) ?></p>
            <p class="card-text"><?= Html::encode($model->description) ?></p>
        </div>
        <div>
            <a class="btn btn-sm btn-light shadow-sm" href="<?= \yii\helpers\Url::to(['profile/hide-question', 'questionId' => $model->id]) ?>"><i class="far fa-eye-slash"></i></a>
        </div>
    </div>
</div>
