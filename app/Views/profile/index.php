<?php
/**
 * @var \yii\web\View $this
 * @var \Askwey\App\Models\User\User $model
 * @var \Askwey\App\Models\Question $questionForm
 * @var \yii\data\ActiveDataProvider $questions
 */

use kartik\alert\Alert;
use kartik\form\ActiveForm;
use yii\bootstrap5\Html;

if (!Yii::$app->user->isGuest)
    $this->title = $model->username === Yii::$app->user->identity->username || Yii::$app->user->isGuest
        ? 'Ваш профиль'
        : "Профиль $model->username";
else
    $this->title = "Профиль $model->username";

?>

<?php if (Yii::$app->session->hasFlash('success')) {
    echo Alert::widget([
        'type' => Alert::TYPE_SUCCESS,
        'title' => 'Вопрос успешно задан',
        'icon' => 'fas fa-check-circle',
        'body' => Yii::$app->session->getFlash('success'),
        'showSeparator' => true,
        'delay' => 6000
    ]);
} elseif (Yii::$app->session->hasFlash('error')) {
    echo Alert::widget([
        'type' => Alert::TYPE_DANGER,
        'title' => 'Произошла ошибка',
        'icon' => 'fas fa-times-circle',
        'body' => Yii::$app->session->getFlash('error'),
        'showSeparator' => true,
        'delay' => 6000
    ]);
} ?>

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
        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->id == $model->id) { ?>
            <div class="row mt-2">
                <div class="col">
                    <div class="d-grid gap-2">
                        <a href="<?= \yii\helpers\Url::to(['profile/own-questions']) ?>" class="btn btn-light shadow-sm" type="button">Ваши вопросы / ответы</a>
                        <a href="<?= \yii\helpers\Url::to(['profile/questions']) ?>" class="btn btn-light shadow-sm"
                           type="button">Вопросы для вас <?php
                            $count = Yii::$app->user->identity->getCountOfAllNewQuestions();
                            if ($count > 0)
                                echo "<span class='badge bg-secondary rounded-pill'>$count</span>"
                            ?></a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="col-9">
        <div class="d-flex">
            <div class="flex-grow-1">
                <span class="fs-4 fw-bold"><?= $model->profile->getProfileName() ?></span>
            </div>
            <div>
                <a href="<?= \yii\helpers\Url::to(['profile/settings']) ?>" class="btn btn-sm btn-light shadow-sm"
                   title="Настройки профиля"><i class="fas fa-bars"></i></a>
                <a class="btn btn-sm btn-light shadow-sm" title="Редактировать пользователя"><i
                            class="fas fa-user-cog"></i></a>
            </div>
        </div>
        <div class="row border-bottom mb-2 pb-2">
            <div class="col">
                <span class="fw-light fst-italic"><?= $model->profile->getProfileStatus() ?></span>
            </div>
        </div>
        <?php if ($model->id !== Yii::$app->user->id) { ?>
            <div class="row border-bottom mt-4 mb-2 pb-2">
                <div class="col-8">
                    <p>
                        <button class="btn btn-warning shadow-sm" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Задать вопрос
                        </button>
                    </p>
                    <div class="collapse" id="collapseExample">
                        <div class="card card-body">
                            <?php $form = \kartik\form\ActiveForm::begin([
                                'enableAjaxValidation' => false,
                                'type' => ActiveForm::TYPE_FLOATING,
                                'fieldConfig' => ['options' => ['class' => 'form-group mb-3 mr-2 me-2']]
                            ]) ?>
                            <?= $form->field($questionForm, 'description')->textarea()->label(false) ?>
                            <?php if (!Yii::$app->user->isGuest) { ?>
                                <?= $form->field($questionForm, 'is_anonymous')->checkbox() ?>
                            <?php } ?>
                            <?= $form->field($questionForm, 'member_id')->hiddenInput(['value' => $model->id])->label(false) ?>
                            <?= $form->field($questionForm, 'author_id')->hiddenInput(['value' => Yii::$app->user->id ?? ''])->label(false) ?>
                            <?= Html::submitButton('Отправить вопрос', ['class' => 'btn btn-primary mr-1 shadow-sm']) ?>
                            <?php \kartik\form\ActiveForm::end() ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row border-bottom mb-2 pb-2">
                <div class="col">
                    <h5>Опубликованные вопросы.</h5>
                    <?= \yii\widgets\ListView::widget([
                        'dataProvider' => $questions,
                        'itemView' => 'partial/_public_question',
                        'layout' => "{pager}\n{items}\n{pager}",
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h5>Опубликованные ответы.</h5>
                </div>
            </div>
        <?php } else { ?>
            <div class="row border-bottom mt-4 mb-2 pb-2">
                <div class="col-8">
                    <p>
                        <button class="btn btn-warning shadow-sm" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Опубликовать новый вопрос
                        </button>
                    </p>
                    <div class="collapse" id="collapseExample">
                        <div class="card card-body">
                            <?php $form = \kartik\form\ActiveForm::begin([
                                'enableAjaxValidation' => false,
                                'type' => ActiveForm::TYPE_FLOATING,
                                'fieldConfig' => ['options' => ['class' => 'form-group mb-3 mr-2 me-2']]
                            ]) ?>
                            <?= $form->field($questionForm, 'description')->textarea()->label(false) ?>
                            <?= $form->field($questionForm, 'author_id')->hiddenInput(['value' => Yii::$app->user->id ?? ''])->label(false) ?>
                            <?= Html::submitButton('Опубликовать', ['class' => 'btn btn-primary mr-1 shadow-sm']) ?>
                            <?php \kartik\form\ActiveForm::end() ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row border-bottom mb-2 pb-2">
                <div class="col">
                    <h5>Ваши вопросы</h5>
                    <?= \yii\widgets\ListView::widget([
                        'dataProvider' => $questions,
                        'itemView' => 'partial/_public_question',
                        'layout' => "{pager}\n{items}\n{pager}",
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h5>Ваши опубликованные ответы</h5>
                </div>
            </div>
        <?php } ?>
    </div>
</div>