<?php

include_once 'LoginResultCode.php';

class AuthService
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(string $login, string $password): int
    {
        $user = $this->userService->getUserByLogin($login);

        if (!$user) {
            return LoginResultCode::LOGIN_RESULT_WRONG_LOGIN;
        }

        if ($user->isBanned()) {
            return LoginResultCode::LOGIN_RESULT_BANNED;
        }

        if ($user->getPassword() === '') {
            return LoginResultCode::LOGIN_RESULT_NEED_NEW_PASSWORD;
        }

        if ($user->getPassword() !== $password) {
            return LoginResultCode::LOGIN_RESULT_WRONG_PASSWORD;
        }

        setcookie('login', $login, time()+6000, '/');
        setcookie('secret', password_hash($password, PASSWORD_BCRYPT), time()+6000, '/');
        return LoginResultCode::LOGIN_RESULT_OK;
    }

    public function isAuthed(): bool
    {
        if (!isset($_COOKIE['secret']) || !isset($_COOKIE['login'])) {
            return false;
        }
        $secretCookie = $_COOKIE['secret'];
        $loginCookie = $_COOKIE['login'];

        $user = $this->userService->getUserByLogin($loginCookie);
        if (!$user) {
            return false;
        }

        if ($user->getPassword() === '' && $secretCookie === 'none') {
            return true;
        }
        if (password_verify($user->getPassword(), $secretCookie)) {
            return true;
        }

        return false;
    }

    public function isAdmin(): bool
    {
        if (!$this->isAuthed()) {
            return false;
        }
        return ($this->getCurrentUser()->getRole()->getRole() === Role::ROLE_ADMIN);
    }

    public function resetPassword(string $login, string $password, string $oldPassword): bool
    {
        $user = $this->userService->getUserByLogin($login);
        if ($user->getPassword() !== $oldPassword) {
            return false;
        }
        if ($user->isPasswordLimit()) {
            if (!$this->validPassword($password)) {
                return false;
            }
        }
        $user->setPassword($password);
        return $this->userService->patchUser($user);
    }

    private function validPassword($password): bool
    {
        return (
            preg_match('/^[А-яA-z\-+*\/]+$/', $password)
            && preg_match('/[А-яA-z]+/', $password)
            && preg_match('/[\-+*\/]+/', $password)
        );
    }

    public function getCurrentUser(): ?User
    {
        if (!isset($_COOKIE['secret']) || !isset($_COOKIE['login'])) {
            return null;
        }
        $secretCookie = $_COOKIE['secret'];
        $loginCookie = $_COOKIE['login'];

        $user = $this->userService->getUserByLogin($loginCookie);
        if (password_verify($user->getPassword(), $secretCookie)) {
            return $user;
        }

        return null;
    }
}