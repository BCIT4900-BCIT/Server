<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

$app->get('/', 'HomeController:index')->setName('home');

$app->group('', function() {

    $this->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
    $this->post('/auth/signup', 'AuthController:postSignUp');

    $this->get('/auth/signin', 'AuthController:getSignIn')->setName('auth.signin');
    $this->post('/auth/signin', 'AuthController:postSignIn');
})->add(new GuestMiddleware($container));


$app->group('', function() {

    $this->get('/child/childin', 'ChildController:getChildIn')->setName('child.childin');

    $this->get('/child/childup', 'ChildController:getChildUp')->setName('child.childup');
    $this->post('/child/childup', 'ChildController:postChildUp');

    $this->get('/child/childlist', 'ChildController:getChildList')->setName('child.childlist');
    $this->post('/child/childlist', 'ChildController:postChildList');

    $this->get('/task/taskslist', 'TasksController:getTasksList')->setName('task.taskslist');
    $this->post('/task/taskslist', 'TasksController:postTasksList');

    $this->get('/task/taskup', 'TaskUpController:getTaskUp')->setName('task.taskup');
    $this->post('/task/taskup', 'TaskUpController:postTaskUp');

    $this->get('/auth/signout', 'AuthController:getSignOut')->setName('auth.signout');
})->add(new AuthMiddleware($container));

