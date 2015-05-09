<?php

class UsersController extends BaseController
{
    private $db;

    public function onInit()
    {
        $this->title = "Users";
        $this->db = new UsersModel();
    }

    public function register()
    {
        if ($this->isPost) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if ($username == null || strlen($username) < 6) {
                $this->addErrorMessage("Username should be at least 6 characters");
                $this->redirect('users', 'register');
            }

            if ($password == null || strlen($password) < 3) {
                $this->addErrorMessage("Password should be at least 3 characters");
                $this->redirect('users', 'register');
            }

            if ($this->db->register($username, $password)) {
                $_SESSION['username'] = $username;
                $this->addInfoMessage("Registration successful.");
                $this->redirect('questions');
            } else {
                $this->addErrorMessage("Registration error.");
            }
        }
    }

    public function login()
    {
        if ($this->isPost) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            if ($this->db->login($username, $password)) {
                $_SESSION['username'] = $username;
                $this->addInfoMessage("Login successful.");
                $this->redirect('questions');
            } else {
                $this->addErrorMessage("Login error.");
            }
        }
    }

    public function logout()
    {
        unset($_SESSION['username']);
        $this->isLoggedIn = false;
        $this->redirect('home');
    }
}