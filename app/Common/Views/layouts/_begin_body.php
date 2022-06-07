<?php use kartik\alert\Alert;

if (Yii::$app->session->hasFlash('success')) {
    Alert::widget([
        'type' => Alert::TYPE_SUCCESS,
        'title' => null,
        'icon' => 'fas fa-exclamation-circle',
        'body' => Yii::$app->session->getFlash('success'),
        'showSeparator' => true,
        'delay' => 6000
    ]);
} else {
    Alert::widget([
        'type' => Alert::TYPE_DANGER,
        'title' => 'Произошла ошибка.',
        'icon' => 'fas fa-exclamation-circle',
        'body' => Yii::$app->session->getFlash('error'),
        'showSeparator' => true,
        'delay' => 6000
    ]);
}?>