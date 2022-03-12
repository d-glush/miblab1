<?php

class Role
{
    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER = 'user';

    private string $role;

    public function __construct(string $role)
    {
        $this->role = $role;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;
        return $this;
    }
}