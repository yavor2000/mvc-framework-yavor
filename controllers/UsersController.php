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
        $this->title = "Register";
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
        $this->title = "Login";
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
        $this->addInfoMessage("Logout successful.");
        $this->isLoggedIn = false;
        $this->redirectToUrl('/');
    }

    public function profile($username)
    {
        $user = $this->db->getByUsername($username);
        if (isset($user['username'])) {
            $this->hasUser = true;
            $this->user = $user;
        } else {
            $this->hasUser = false;
            $this->addErrorMessage("No such user.");
        }
    }
}