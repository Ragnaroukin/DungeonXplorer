<?php
class InventaireController  {
    public function show() {
        require_once 'views/inventaire.php';
    }

    public function get() {
        $pdo = Database::getConnection();
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
             require_once 'models/getInventaire.php';
        else
            require_once 'views/403.php';
    }
}