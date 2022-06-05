<?php

return array_merge(
    require dirname(__DIR__) . '\app\Modules\Main\config\routes.php',
    require dirname(__DIR__) . '\app\Modules\Admin\config\routes.php'
);