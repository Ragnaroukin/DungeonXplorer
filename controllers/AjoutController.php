<?php
class AjoutController
{
    public function index($type)
    {
        switch ($type) {
            case "monster":
                require_once "views/ajoutMonster.php";
                break;

            case "chapter":
                require_once "views/ajoutChap.php";
                break;

            case "item":
                require_once "views/ajoutItem.php";
                break;

            case "class":
                require_once "views/ajoutClass.php";
                break;

            default:
                require_once "views/404.php";
        }
    }
}