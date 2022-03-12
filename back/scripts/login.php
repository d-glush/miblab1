<?php

include_once '../core/init.php';

$login = $_POST['login'];
$password = $_POST['password'];
$dbSecret = $_POST['dbSecret'];

$dbDecoder = new DBDecoder();
$dbDecoder->decode($dbSecret);

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
        $dbDecoder->destroyDecoded();
        (new Response(['message' => 'wrong password'], $loginResult))->display();
        break;
    case LoginResultCode::LOGIN_RESULT_WRONG_LOGIN:
        $dbDecoder->destroyDecoded();
        (new Response(['message' => 'wrong login'], $loginResult))->display();
        break;
    case LoginResultCode::LOGIN_RESULT_BANNED:
        $dbDecoder->destroyDecoded();
        (new Response(['message' => 'banned'], $loginResult))->display();
        break;
}