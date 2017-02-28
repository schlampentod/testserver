<?php

// Routes
$app->get('/',  'App\Classes\Webservice:index' )->setName('homepage');

$app->get('/api/Members',  'App\Classes\AgentClass:allagents');
$app->post('/api/Members',  'App\Classes\AgentClass:addagents');
$app->get('/api/test',  'App\Classes\AgentClass:test');

