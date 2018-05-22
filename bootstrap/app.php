<?php

use Respect\Validation\Validator as v;

session_start();

require __DIR__ . '/../vendor/autoload.php';

/**
 * Instantiate the Slim app and configure settings and database.
 */
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
        'determineRouteBeforeAppMiddleware' => true,
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'id5769772_app',
            'username' => 'id5769772_group23',
            'password' => 'group23password',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]
    ],
]);

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function($container) use ($capsule) {
    return $capsule;
};

/**
 * Add function to container to enable PDO.
 */
$container['db'] = function ($c) {
   
   try{
       $db = $c['settings']['db'];
       $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
       PDO::ATTR_DEFAULT_FETCH_MODE                      => PDO::FETCH_ASSOC,
       );
       $pdo = new PDO("mysql:host=localhost;dbname=id5769772_app",
       $db['username'], $db['password'],$options);
       return $pdo;
   }
   catch(\Exception $ex){
       return $ex->getMessage();
   }
   
};

/**
 * Parent authentication end point. Receives email and password and
 * checks it against the database. Returns pass if an email and password
 * combo exists with a NULL groupid.
 */
$app->get('/parentAuth/{email}/{password}', function ($request,$response) {
   try{
       $email     = $request->getAttribute('email');
       $password     = $request->getAttribute('password');
       $con = $this->db;
       $sql = "SELECT * FROM users WHERE email = :email AND password = :password";
       $pre  = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
       $values = array(
       ':email' => $email,
        ':password' => $password);
       $pre->execute($values);
       $data = $pre->fetch();
       if($data && $data['groupid'] == NULL){
           return $response->withJson(array('status' => 'pass'),200);
       }else{
           return $response->withJson(array('status' => 'fail'),422);
       }
      
   }
   catch(\Exception $ex){
       return $response->withJson(array('error' => $ex->getMessage()),422);
   }
   
});

/**
 * Child authentication end point. Receives email and password and
 * checks it against the database. Returns pass if an email and password
 * combo exists with a NOT NULL groupid.
 */
$app->get('/childAuth/{email}/{password}', function ($request,$response) {
   try{
       $email     = $request->getAttribute('email');
       $password     = $request->getAttribute('password');
       $con = $this->db;
       $sql = "SELECT * FROM users WHERE email = :email AND password = :password";
       $pre  = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
       $values = array(
       ':email' => $email,
        ':password' => $password);
       $pre->execute($values);
       $data = $pre->fetch();
       if($data && $data['groupid'] != NULL){
           return $response->withJson(array('status' => 'pass'),200);
       }else{
           return $response->withJson(array('status' => 'fail'),422);
       }
      
   }
   catch(\Exception $ex){
       return $response->withJson(array('error' => $ex->getMessage()),422);
   }
   
});

/**
 * Task retrieval endpoint for an entire group. Receives email in request
 * and returns  JSON formatted array of all tasks with that email as groupid.
 */
$app->get('/group/{groupid}', function ($request,$response) {
   try{
       $con = $this->db;
       $sql = "SELECT * FROM tasks WHERE groupid = '" . $request->getAttribute('groupid') . "'";
       $data = null;
       foreach ($con->query($sql) as $row) {
           $data[] = $row;
       }
       if($data){
           return $response->withJson(array('status' => 'pass','data'=>$data),200);
       }else{
           return $response->withJson(array('status' => 'fail'),422);
       }
              
   }
   catch(\Exception $ex){
       return $response->withJson(array('error' => $ex->getMessage()),422);
   }
   
});

/**
 * Task retrieval endpoint for a parent's children. Receives email in request
 * and returns  JSON formatted array of all children  with that email as groupid.
 */
$app->get('/children/{groupid}', function ($request,$response) {
   try{
       $con = $this->db;
       $sql = "SELECT * FROM users WHERE groupid = '" . $request->getAttribute('groupid') . "'";
       $data = null;
       foreach ($con->query($sql) as $row) {
           $data[] = $row;
       }
       if($data){
           return $response->withJson(array('status' => 'pass','data'=>$data),200);
       }else{
           return $response->withJson(array('status' => 'fail'),422);
       }
              
   }
   catch(\Exception $ex){
       return $response->withJson(array('error' => $ex->getMessage()),422);
   }
   
});

/**
 * Task retrieval endpoint for a single child. Receives email in request
 * and returns  JSON formatted array of all tasks with that email as email.
 */
$app->get('/individual/{email}', function ($request,$response) {
   try{
       $con = $this->db;
       $sql = "SELECT * FROM tasks WHERE email = '" . $request->getAttribute('email') . "'";
       $data = null;
       foreach ($con->query($sql) as $row) {
           $data[] = $row;
       }
       if($data){
           return $response->withJson(array('status' => 'pass','data'=>$data),200);
       }else{
           return $response->withJson(array('status' => 'fail'),422);
       }
              
   }
   catch(\Exception $ex){
       return $response->withJson(array('error' => $ex->getMessage()),422);
   }
   
});

/**
 * The endpoint for adding a task. Fields and values can be included in URI.
 */
$app->post('/add', function ($request, $response) {
   
   try{
       $con = $this->db;
       $sql = "INSERT INTO `tasks`(`email`, `groupid`, `description`,`start`,`end`,`day`,`alarm`) VALUES (:email,:groupid,:description,:start,:end,:day,:alarm)";
       $pre  = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
       $values = array(
       ':email' => $request->getParam('email'),
       ':groupid' => $request->getParam('groupid'),
       ':description' => $request->getParam('description'),
       ':start' => $request->getParam('start'),
       ':end' => $request->getParam('end'),
       ':day' => $request->getParam('day'),
       ':alarm' => $request->getParam('alarm'),
       );
       $result = $pre->execute($values);
       return $response->withJson(array('status' => 'pass'),200);
       
   }
   catch(\Exception $ex){
       return $response->withJson(array('error' => $ex->getMessage()),422);
   }
   
})->setName('addtask');

/**
 * The endpoint for adding multiple tasks. Receives JSON formatted array in body
 * of request, parses it for task objects and inserts these objects into the task
 * database.
 */
$app->post('/addall', function ($request, $response) {

  $json = file_get_contents('php://input'); 
  $obj = json_decode($json, true);
   
   try{
    foreach($obj['data'] as $data)
    {
      $con = $this->db;
      $sql = "INSERT INTO `tasks`(`email`, `groupid`, `description`,`start`,`end`,`day`,`alarm`) VALUES (
          '" . $data['email'] . "',
          '" . $data['groupid'] . "',
          '" . $data['description'] . "',
          '" . $data['start'] . "',
          '" . $data['end'] . "',
          '" . $data['day'] . "',
          '" . $data['alarm'] . "')";

          $pre  = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

          $values = array(
            'email' => $data['email'],
            'groupid' => $data['groupid'],
            'description' => $data['description'],
            'start' => $data['start'],
            'end' => $data['end'],
            'day' => $data['day'],
            'alarm' => $data['alarm'],
          );

          $result = $pre->execute($values);
    }
       return $response->withJson(array('status' => 'pass'),200);
       
   }
   catch(\Exception $ex){
       return $response->withJson(array('error' => $ex->getMessage()),422);
   }
   
})->setName('addall');

/**
 * The endpoint of deleting a single task. Task fields and values can be included in
 * the URI.
 */
$app->delete('/delete', function ($request,$response) {
   try{
       $con = $this->db;
       $sql = "DELETE FROM tasks WHERE email = :email AND groupid = :groupid AND description = :description AND start = :start AND end = :end AND day = :day AND alarm = :alarm";
       $pre  = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
       $values = array(
       ':email' => $request->getParam('email'),
       ':groupid' => $request->getParam('groupid'),
       ':description' => $request->getParam('description'),
       ':start' => $request->getParam('start'),
       ':end' => $request->getParam('end'),
       ':day' => $request->getParam('day'),
       ':alarm' => $request->getParam('alarm'),
       );
       $result = $pre->execute($values);
       if($result){
           return $response->withJson(array('status' => 'pass'),200);
       }else{
           return $response->withJson(array('status' => 'fail'),422);
       }
      
   }
   catch(\Exception $ex){
       return $response->withJson(array('error' => $ex->getMessage()),422);
   }
   
})->setName('deletetask');

/**
 * The endpoint for deleting all tasks in a group. Receives the an email in the request
 * and deleted all tasks with that email as groupid.
 */
$app->delete('/delete/{groupid}', function ($request,$response) {
   try{
      $groupid = $request->getAttribute('groupid');
       $con = $this->db;
       $sql = "DELETE FROM tasks WHERE groupid = :groupid";
       $pre  = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
       $values = array(
       ':groupid' => $groupid,
       );
       $result = $pre->execute($values);
       if($result){
           return $response->withJson(array('status' => 'pass'),200);
       }else{
           return $response->withJson(array('status' => 'fail'),422);
       }
      
   }
   catch(\Exception $ex){
       return $response->withJson(array('error' => $ex->getMessage()),422);
   }
   
})->setName('deleteall');

/**
 * Add auth to container.
 */
$container['auth'] = function ($container) {
    return new \App\Auth\Auth;
};

/**
 * Add flash to container.
 */
$container['flash'] = function ($container) {
    return new \Slim\Flash\Messages;
};

/**
 * Add twig to container.
 */
$container['view'] = function($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => false,
    ]);

    $view->addExtension(new \Slim\Views\TwigExtension(
            $container->router, $container->request->getUri()
    ));

    $view->getEnvironment()->addGlobal('auth', [
        'check' => $container->auth->check(),
        'user' => $container->auth->user()
    ]);

    $view->getEnvironment()->addGlobal('flash', $container->flash);
    return $view;
};

/**
 * Add HomeController to container.
 */
$container['HomeController'] = function($container) {
    return new \App\Controllers\HomeController($container);
};

/**
 * Add Validator to container.
 */
$container['validator'] = function($container) {
    return new App\Validation\Validator;
};

/**
 * Add AuthController to container.
 */
$container['AuthController'] = function($container) {
    return new \App\Controllers\Auth\AuthController($container);
};

/**
 * Add ChildController to container.
 */
$container['ChildController'] = function($container) {
    return new \App\Controllers\Child\ChildController($container);
};

/**
 * Add TasksController to container.
 */
$container['TasksController'] = function($container) {
    return new \App\Controllers\Task\TasksController($container);
};

/**
 * Add TaskUpController to container.
 */
$container['TaskUpController'] = function($container) {
    return new \App\Controllers\Task\TaskUpController($container);
};

/**
 * Add Csrf to container.
 */
$container['csrf'] = function($container) {
    return new \App\Middleware\MyCsrfMiddleware; // Now the container returns your middleware under 'csrf' key
};

/**
 * Add ValidationErrorsMiddleware to app.
 */
$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));

/**
 * Add OldInputMiddleware to app.
 */
$app->add(new \App\Middleware\OldInputMiddleware($container));

/**
 * Add CsrfViewMiddleware to app.
 */
$app->add(new \App\Middleware\CsrfViewMiddleware($container));

/**
 * Add my custom Csrf middleware to app.
 */
$app->add('csrf:processRequest');

/**
 * Add custom rules.
 */
v::with('App\\Validation\\Rules\\');

require __DIR__ . '/../app/routes.php';

