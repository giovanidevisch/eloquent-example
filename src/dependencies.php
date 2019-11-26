<?php

use Illuminate\Database\Capsule\Manager as Capsule;

return function ($containerBuilder) {
    $containerBuilder->addDefinitions([
        Capsule::class => function ($container) {
            $eloquent = new Capsule;
            $eloquent->addConnection(
                [
                    'driver' => 'mysql',
                    'host' => 'localhost',
                    'database' => 'eloquent',
                    'username' => 'root',
                    'password' => ''
                ]
            );
            $eloquent->setAsGlobal();
            $eloquent->bootEloquent();
            return $eloquent;
        }
    ]);
};
