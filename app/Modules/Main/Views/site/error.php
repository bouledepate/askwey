<?php
/**
 * @var Exception $exception
 */

if ($exception->getCode() === 500) { ?>
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Ошибка сервера.</h4>
        <hr>
        <?php if (YII_DEBUG) {?>
            <p class="mb-0"><strong>Сообщение:</strong> <?= $exception->getMessage() ?></p>
            <p class="mb-0"><strong>Файл:</strong> <?= $exception->getFile() ?></p>
            <p class="mb-0"><strong>Строка:</strong> <?= $exception->getLine() ?></p>
        <?php } else { ?>
            <p class="mb-0">Пожалуйста, сообщите об ошибке в нашу поддержку для скорого её решения.</p>
        <?php } ?>
    </div>
<?php } else { ?>
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading"><?= $exception->getMessage() ?></h4>
        <hr>
        <p class="mb-0">Убедитесь в корректности введёных вами данных. В случае возникновения похожих ошибок, обратитесь в нашу поддержку.</p>
    </div>
<?php } ?>
<div class="row justify-content-center">
    <div class="col-2">
        <a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['/']) ?>">На главную</a>
    </div>
</div>
