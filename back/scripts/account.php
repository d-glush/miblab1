<?php
include_once '../core/init.php';

$method = $_GET['method'];

$userService = new UserService();
$authService = new AuthService($userService);

if (!$authService->isAuthed() || !$authService->isAdmin()) {
    (new Response(['message' => 'access error'], 401))->display();
    exit;
}

switch ($method) {
    case 'getUsers':
        $users = $userService->getUsers();
        $usersArray = [];
        foreach ($users as $user) {
            $usersArray[] = $user->getArrayDataNoPassword();
        }
        (new Response($usersArray, 200))->display();
        break;
    case 'addUser':
        $login = $_POST['login'];
        if ($userService->getUserByLogin($login)) {
            (new Response(['message' => 'user exists'], 402))->display();
            return;
        }
        $userService->addUser($login);
        (new Response(['message'=>'OK'], 200))->display();
        break;
    case 'swapLimit':
        $login = $_POST['login'];
        $result = $userService->swapLimit($login);
        if ($result) {
            (new Response(['message'=>'OK'], 200))->display();
        } else {
            (new Response(['message'=>'error'], 402))->display();
        }
        break;
    case 'swapBan':
        $login = $_POST['login'];
        $result = $userService->swapBan($login);
        if ($result) {
            (new Response(['message'=>'OK'], 200))->display();
        } else {
            (new Response(['message'=>'error'], 402))->display();
        }
        break;
    default:
        (new Response(['message'=>'wrongMethodName'], 404))->display();
}
