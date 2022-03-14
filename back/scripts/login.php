<?php

include_once '../core/init.php';

$login = $_POST['login'];
$password = $_POST['password'];

$userService = new UserService();
$authService = new AuthService($userService);
$loginResult = $authService->login($login, $password);

switch ($loginResult) {
    case LoginResultCode::LOGIN_RESULT_OK:
        (new Response(['message' => 'OK'], $loginResult))->display();
        break;
    case LoginResultCode::LOGIN_RESULT_NEED_NEW_PASSWORD:
        (new Response(['message' => 'need set password'], $loginResult))->display();
        break;
    case LoginResultCode::LOGIN_RESULT_WRONG_PASSWORD:
        (new Response(['message' => 'wrong password'], $loginResult))->display();
        break;
    case LoginResultCode::LOGIN_RESULT_WRONG_LOGIN:
        (new Response(['message' => 'wrong login'], $loginResult))->display();
        break;
    case LoginResultCode::LOGIN_RESULT_BANNED:
        (new Response(['message' => 'banned'], $loginResult))->display();
        break;
}