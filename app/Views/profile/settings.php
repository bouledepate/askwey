<?php
/**
 * @var \yii\web\View $this
 * @var \Askwey\App\Models\User\User $model
 */

use kartik\editable\Editable;
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
        <div class="row mt-2">
            <div class="col">
                <div class="d-grid gap-2">
                    <a href="<?= \yii\helpers\Url::to(['profile/index']) ?>" class="btn btn-light shadow-sm" type="button">Ваш профиль</a>
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
    </div>
    <div class="col-9">
        <div class="d-flex border-bottom mb-3 pb-3">
            <div class="flex-grow-1">
                <span class="fs-4 fw-bold">Управление настройками профиля</span>
            </div>
        </div>
        <div class="row">
            <div class="col-10">
                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col fw-bold">Псевдоним:</div>
                            <div class="col">
                                <?= Editable::widget([
                                    'model' => $model->profile,
                                    'attribute' => 'preferred_name',
                                    'asPopover' => true,
                                    'size' => 'sm',
                                    'options' => ['class' => 'form-control']
                                ]); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col fw-bold">Имя:</div>
                            <div class="col">
                                <?= Editable::widget([
                                    'model' => $model->profile,
                                    'attribute' => 'first_name',
                                    'asPopover' => true,
                                    'size' => 'sm',
                                    'options' => ['class' => 'form-control']
                                ]); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col fw-bold">Фамилия:</div>
                            <div class="col">
                                <?= Editable::widget([
                                    'model' => $model->profile,
                                    'attribute' => 'last_name',
                                    'asPopover' => true,
                                    'size' => 'sm',
                                    'options' => ['class' => 'form-control']
                                ]); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col fw-bold">Отчество:</div>
                            <div class="col">
                                <?= Editable::widget([
                                    'model' => $model->profile,
                                    'attribute' => 'family_name',
                                    'asPopover' => true,
                                    'size' => 'sm',
                                    'options' => ['class' => 'form-control']
                                ]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col fw-bold">Отображаемое имя</div>
                            <div class="col">
                                <?= Editable::widget([
                                    'model' => $model->profile->settings,
                                    'attribute' => 'shown_name',
                                    'asPopover' => true,
                                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                                    'data' => \Askwey\App\Enums\ShownName::titles(),
                                    'size' => 'sm',
                                    'options' => ['class' => 'form-control', 'prompt' => '> Выберите стиль отображения <'],
                                    'displayValueConfig' => \Askwey\App\Enums\ShownName::titles()
                                ]); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col fw-bold">Отображение фамилии</div>
                            <div class="col">
                                <?= Editable::widget([
                                    'model' => $model->profile->settings,
                                    'attribute' => 'show_family_name',
                                    'asPopover' => true,
                                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                                    'data' => ['Скрывать', 'Показывать'],
                                    'size' => 'sm',
                                    'options' => ['class' => 'form-control', 'prompt' => '> Выберите стиль отображения <'],
                                    'displayValueConfig' => ['Скрывать', 'Показывать']
                                ]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
</div>