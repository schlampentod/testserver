<?php

// database
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($settings['settings']['database']);
$capsule->setAsGlobal();
$capsule->bootEloquent();
