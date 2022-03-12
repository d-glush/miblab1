<?php

include_once 'Role.php';

class User
{
    private string $login;
    private string $password;
    private Role $role;
    private bool $isBanned;
    private bool $isPasswordLimit;

    public function __construct(array $data)
    {
        $this->login = $data['login'];
        $this->password = $data['password'];
        $this->role = new Role($data['role']);
        $this->isBanned = $data['is_banned'];
        $this->isPasswordLimit = $data['is_password_limit'];
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function setRole(Role $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function isBanned(): bool
    {
        return $this->isBanned;
    }

    public function setIsBanned(bool $isBanned): self
    {
        $this->isBanned = $isBanned;
        return $this;
    }

    public function isPasswordLimit(): bool
    {
        return $this->isPasswordLimit;
    }

    public function setIsPasswordLimit(bool $isPasswordLimit): self
    {
        $this->isPasswordLimit = $isPasswordLimit;
        return $this;
    }

    public function getArrayData(): array
    {
        return [
            "login" => $this->login,
            "password" => $this->password,
            "role" => $this->role->getRole(),
            "is_banned" => $this->isBanned,
            "is_password_limit" => $this->isPasswordLimit,
        ];
    }

    public function getArrayDataNoPassword(): array
    {
        return [
            "login" => $this->login,
            "role" => $this->role->getRole(),
            "is_banned" => $this->isBanned,
            "is_password_limit" => $this->isPasswordLimit,
        ];
    }
}