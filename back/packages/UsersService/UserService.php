<?php

include_once 'Role.php';
include_once 'User.php';

class UserService
{
    private string $dbFilePath;
    /** @var array<User> $users */
    private array $users = [];

    public function __construct()
    {
        $this->dbFilePath = $_SERVER['DOCUMENT_ROOT'] . '/src/db/database_decoded.db';
        $usersArray = json_decode(file_get_contents($this->dbFilePath), true);
        if (!$usersArray) {
            $this->users = [];
        } else {
            foreach ($usersArray as $user) {
                $this->users[] = new User($user);
            }
        }
    }

    /**
     * @return array<User>
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    public function getUserByLogin(string $login): User|bool
    {
        foreach ($this->users as $user) {
            if ($user->getLogin() === $login) {
                return $user;
            }
        }
        return false;
    }

    public function addUser($login) {
        $user = new User([
            'login' => $login,
            'password' => '',
            'role' => 'user',
            'is_banned' => false,
            'is_password_limit' => true,
        ]);
        $this->users[] = $user;
        $this->rewriteDb();
    }

    public function patchUser(User $patchedUser): bool
    {
        foreach ($this->users as $id => $user) {
            if ($user->getLogin() === $patchedUser->getLogin()) {
                $this->users[$id] = $patchedUser;
            }
        }
        return $this->rewriteDb();
    }

    public function swapBan($login): bool
    {
        $user = $this->getUserByLogin($login);
        $user->setIsBanned(!$user->isBanned());
        $this->patchUser($user);
        $this->rewriteDb();
        return true;
    }

    public function swapLimit($login): bool
    {
        $user = $this->getUserByLogin($login);
        $user->setIsPasswordLimit(!$user->isPasswordLimit());
        $this->patchUser($user);
        $this->rewriteDb();
        return true;
    }

    private function rewriteDb(): bool
    {
        $data = [];
        foreach ($this->users as $user) {
            $data[] = $user->getArrayData();
        }
        file_put_contents($this->dbFilePath, json_encode($data));
        return true;
    }
}