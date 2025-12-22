<?php
class HomeController
{
    public function index()
    {
        $pdo = Database::getConnection();
        require_once __DIR__ . "/../views/header.php";
        require_once 'views/home.php';
    }
}