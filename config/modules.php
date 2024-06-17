<?php

return [
    'auth' => [
        'className' => MyApp\Auth\Module::class,
        'path'      => __DIR__ . '/../src/Modules/Auth/Module.php',
    ],
    'user' => [
        'className' => MyApp\User\Module::class,
        'path'      => __DIR__ . '/../src/Modules/User/Module.php',
    ],
    'student' => [
        'className' => MyApp\Student\Module::class,
        'path'      => __DIR__ . '/../src/Modules/Student/Module.php',
    ],
    'error' => [
        'className' => MyApp\Error\Module::class,
        'path'      => __DIR__ . '/../src/Modules/Error/Module.php',
    ],
];