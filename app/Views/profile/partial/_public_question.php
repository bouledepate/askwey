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
    </div>
</div>
