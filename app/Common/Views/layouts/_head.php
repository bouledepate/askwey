<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/images/favicon.ico"
      type="image/x-icon"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
<?php $this->registerCsrfMetaTags() ?>
<?php \Askwey\App\Common\Components\AppAsset::register($this) ?>
