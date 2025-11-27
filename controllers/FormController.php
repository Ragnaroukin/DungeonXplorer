<?php
class FormController
{
    public function index()
    {
        require_once __DIR__."/../views/form.php";
    }

    public function choose($type)
    {
        switch ($type) {
            case "monster":
                require_once __DIR__."/../views/formMonster.php";
                break;

            case "chapter":
                require_once __DIR__."/../views/formChap.php";
                break;

            case "item":
                require_once __DIR__."/../views/formItem.php";
                break;

            case "class":
                require_once __DIR__."/../views/formClass.php";
                break;

            default:
                require_once __DIR__."/../views/404.php";
        }
    }
}