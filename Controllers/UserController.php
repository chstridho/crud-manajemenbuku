<?php

require_once __DIR__ . '/../Models/User.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function register($username, $password)
    {
        return $this->userModel->register($username, $password);
    }

    public function login($username, $password)
    {
        return $this->userModel->login($username, $password);
    }
}