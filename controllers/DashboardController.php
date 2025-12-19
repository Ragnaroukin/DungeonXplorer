<?php
class DashboardController
{
    public function index()
    {
        if (empty($_SESSION["admin"]) || $_SESSION["admin"] != 1)
            require_once "views/404.php";
        else {
            $pdo = Database::getConnection();
            require_once 'views/dashboard.php';
        }
    }
}