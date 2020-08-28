<?php

use Slim\App;

return function (App $app) {
    $app->get('/', \App\Action\HomeAction::class);

    $app->get('/users', \App\Action\UsersAction::class);

    $app->post('/posts', \App\Action\PostsAction::class);

    $app->get('/user/{id}/{taken}', \App\Action\UserAction::class);

    $app->get('/template', \App\Action\HomeActionTWIG::class);

    $app->get('/dashboard/{name}', \App\Action\DashboardAction::class);

    $app->get('/update', \App\Action\UpdateAction::class);
    $app->get('/delete', \App\Action\DeleteAction::class);
    $app->get('/register', \App\Action\RegisterAction::class);
    $app->post('/register', \App\Action\RegisterPostAction::class);


};