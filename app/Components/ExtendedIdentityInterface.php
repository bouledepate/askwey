<?php

namespace Askwey\App\Components;

use yii\web\IdentityInterface;

interface ExtendedIdentityInterface extends IdentityInterface
{
    public static function findIdentityByUsername($username);
}