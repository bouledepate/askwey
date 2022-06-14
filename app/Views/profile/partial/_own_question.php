<?php

/** @var \Askwey\App\Models\Question $model */

/** @var \Askwey\App\Models\Answer $form */

use yii\bootstrap5\Html;

$answers = $model->getAnswers()->where(['state' => \Askwey\App\Enums\AnswerState::ACTIVE->value])->all();

?>

<div class="card my-2">
    <div class="card-body d-flex">
        <div class="flex-grow-1">
            <h5 class="card-title">
                <?= \Askwey\App\Components\QuestionViewHelper::getQuestionTitle($model) ?>
            </h5>
            <p class="card-subtitle mb-2 text-muted"><?= Yii::$app->formatter->asDatetime($model->date_create) ?></p>
            <p class="card-text"><?= Html::encode($model->description) ?></p>
            <?php $answer = $model->getAnswers()->where(['author_id' => $model->member_id])->one();
            if (!empty($answer) && !empty($model->member_id)) { ?>
                <hr>
                <div class="card">
                    <div class="card-body">
                        <p class="card-subtitle mb-2 text-muted">
                            <strong><?= $model->member->profile->getProfileName() ?> ответил вам </strong>
                            (<?= Yii::$app->formatter->asDatetime($answer->date_create) ?>):</p>
                        <p class="card-text"><?= $answer->description ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div>
            <a class="btn btn-sm btn-light shadow-sm"
               href="<?= \yii\helpers\Url::to(['question/hide', 'questionId' => $model->id]) ?>"><i
                        class="far fa-eye-slash"></i></a>
        </div>
    </div>
    <?php if (empty($model->member_id)) { ?>
        <div class="row">
            <div class="col">
                <ul class="list-group">
                    <?php
                    /**
                     * @var \Askwey\App\Models\Answer $answer
                     */
                    foreach ($answers as $answer) { ?>
                        <li href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1"><?= $answer->author?->profile->getProfileName() ?? 'Аноним' ?> ответил:</h5>
                                <small class="text-muted"><?= Yii::$app->formatter->asDatetime($answer->date_create) ?></small>
                            </div>
                            <p class="mb-1"><?= Html::decode($answer->description) ?></p>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    <?php } ?>
</div>
