<?php

namespace App;

use App\Http\Controller\CabinetController;
use App\Http\Controller\HomeController;
use App\Http\Controller\LoginController;
use App\Http\Controller\LogoutController;
use App\Http\Controller\PayController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\GetOnlyMiddleware;
use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\PostOnlyMiddleware;
use App\Provider\Request;

error_reporting(E_ALL);
session_start();

//unset $_SESSION;

require_once __DIR__ . '/../vendor/autoload.php';

$request = new Request(
    parameters: $_GET,
    body: $_POST,
    headers: $_SERVER,
    session: $_SESSION,
);

$action = $_GET['action'] ?? null;

try {
    match ($action) {
        // for auth user
        'logout' => (new LogoutController)->execute($request->addMiddleware(new AuthMiddleware())->addMiddleware(new PostOnlyMiddleware())),
        'pay' => (new PayController)->execute($request->addMiddleware(new AuthMiddleware())->addMiddleware(new PostOnlyMiddleware())),
        'cabinet' => (new CabinetController)->execute($request->addMiddleware(new AuthMiddleware())->addMiddleware(new GetOnlyMiddleware())),
        // for guest
        'login' => (new LoginController)->execute($request->addMiddleware(new GuestMiddleware())->addMiddleware(new PostOnlyMiddleware())),
        default => !!$request->getAuth() ?
            (new CabinetController)->execute($request->addMiddleware(new AuthMiddleware())->addMiddleware(new GetOnlyMiddleware())) :
            (new HomeController)->execute($request->addMiddleware(new GuestMiddleware())->addMiddleware(new GetOnlyMiddleware()))
    };
} catch (\Exception $e) {
    echo 'total: ' . $e->getMessage();
}


