<?php

require_once "models/Bookerr.php";
require_once "models/User.php";
require_once "models/FactoryBook.php";

class BookPublicado extends AbstractBook implements Book
{
    public function despublicar()
    {
    }

    public function getPublicado(): bool
    {
        return true;
    }

    public function renderizarCard(): string
    {
        return "";
    }
}
