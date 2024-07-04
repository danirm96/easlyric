<?php

// activate debug PHP
ini_set('display_errors', 1);
error_reporting(E_ALL);


require_once 'controllers/db.php';

function e($e) {
    echo "<pre>";
    var_dump($e);
    echo "</pre>";
}

if(!empty($_GET)) {

    $get = (object) $_GET;
    $path = $get->path;
    useController($path);
    die();
} 

if(!empty($_POST)) {
    $post = (object) $_POST;
    $path = $post->path;
    useController($path);
    die();
}

if(empty($_GET) && empty($_POST)) {
    die('No request');
}


function response($status, $data = [], $message = '') {
    echo json_encode(array(
        'status' => $status,
        'data' => $data,
        'message' => $message,
    ));
}




function useController($path) {
    $controller = explode('/', $path)[0];
    $uController = ucfirst($controller);  
    $method = explode('/', $path)[1];

    if(file_exists('controllers/' . $controller . '.php')) {
        require_once 'controllers/' . $controller . '.php';
        $controller = new $uController;
        if(method_exists($controller, $method)) {
            $controller->$method();
        }
    }
}