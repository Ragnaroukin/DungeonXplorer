<?php
class DashboardController {
    public function index() {
        $pdo = Database::getConnection();
        require_once 'views/dashboard.php';
    }
}