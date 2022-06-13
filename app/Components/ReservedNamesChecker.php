<?php

namespace Askwey\App\Components;

use yii\base\Behavior;
use yii\base\Controller;
use yii\web\BadRequestHttpException;

class ReservedNamesChecker extends Behavior
{
    private array $reservedNames = [
        'settings', 'profile', 'auth'
    ];

    public array $actions;
    public array $attributes;

    private array $invalidNames;

    public function events(): array
    {
        return [
            Controller::EVENT_BEFORE_ACTION => [$this, 'checkActionNames']
        ];
    }

    public function checkActionNames()
    {
        if (in_array($action = $this->owner->action->id, array_keys($this->actions))) {
            $owner = $this->owner;

            if (!empty($this->invalidNames))
                throw new BadRequestHttpException("Неверный запрос с использованием зарезервированных имён: {$this->getInvalidNamesAsString()}");
        }
    }

    private function getInvalidNames(): array
    {
        return $this->invalidNames;
    }

    private function getInvalidNamesAsString(): string
    {
        return implode(', ', $this->invalidNames);
    }
}