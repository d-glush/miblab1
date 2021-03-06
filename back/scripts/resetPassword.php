<?php

include_once '../core/init.php';

$login = $_POST['login'];
$oldPassword = $_POST['old_password'] ?? "";
$password = $_POST['password'];

$userService = new UserService();
$authService = new AuthService($userService);

if (!$authService->isAuthed()) {
    (new Response(['message' => 'not authorized!'], 401))->display();
    exit;
}

if (!$authService->resetPassword($login, $password, $oldPassword)) {
    (new Response(['message' => 'invalidPassword'], 402))->display();
    exit;
}

$loginResult = $authService->login($login, $password);

(new Response(['message' => 'password changed'], 200))->display();
