<?php 
class CompteController {
    public function login() {
        $pdo = Database::getConnection();
        require_once 'views/compte/login.php';
    }

     public function signup() {
        $pdo = Database::getConnection();
        require_once 'views/compte/signup.php';
    }
}