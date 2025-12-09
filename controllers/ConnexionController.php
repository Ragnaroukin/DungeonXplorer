<?php
class ConnexionController {
    public function index() {
        $pdo = Database::getConnection();
        return 'models/connexion.php';
    }
}