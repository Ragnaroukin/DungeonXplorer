<?php
class FormController
{
    public function index()
    {
        echo "TYPE index";
        require_once 'views/form.php';
    }

    public function choose($type)
    {
        switch ($type) {
            case "monster":
                require_once "views/formMonster.php";
                break;

            case "chapter":
                require_once "views/formChap.php";
                break;

            case "item":
                require_once "views/formItem.php";
                break;

            case "class":
                require_once "views/formClass.php";
                break;

            default:
                require_once "views/404.php";
        }
    }
}