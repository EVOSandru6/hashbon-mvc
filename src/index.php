<?php

namespace App;

use App\Http\Controller\BalanceController;
use App\Http\Controller\HomeController;
use App\Http\Controller\LoginController;
use App\Http\Controller\LogoutController;
use App\Http\Controller\PayController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\GuestMiddleware;
use App\Provider\Request;

error_reporting(E_ALL);
session_start();

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
        'logout' => (new LogoutController)->execute($request->addMiddleware(new AuthMiddleware())),
        'pay' => (new PayController)->execute($request->addMiddleware(new AuthMiddleware())),
        'balance' => (new BalanceController)->execute($request->addMiddleware(new AuthMiddleware())),
        // for guest
        'login' => (new LoginController)->execute($request->addMiddleware(new GuestMiddleware())),
        default => (new HomeController)->execute($request->addMiddleware(new GuestMiddleware()))
    };
} catch (\Exception $e) {
    echo 'total: ' . $e->getMessage();
}


