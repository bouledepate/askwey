<?php

namespace Askwey\App\Common\Components;

use yii\web\IdentityInterface;

interface ExtendedIdentityInterface extends IdentityInterface
{
    public static function findIdentityByUsername($username);
}