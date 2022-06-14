<?php

return [
    '' => 'site/index',
    'auth/sign-up' => 'auth/sign-up',
    'auth/sign-in' => 'auth/sign-in',
    'auth/sign-out' => 'auth/sign-out',
    'profile' => 'profile/index',
    'profile/settings' => 'profile/settings',
    'profile/questions' => 'profile/questions',
    'profile/questions/own' => 'profile/own-questions',
    'profile/questions/own/hide/<questionId>' => 'question/hide',
    'profile/questions/own/delete/<questionId>' => 'question/delete',
    'profile/<username>' => 'profile/index',
];