<?php
class HomeController {
    public function index() {
        $pdo = Database::getConnection();
        require_once 'views/home.php';
    }
}