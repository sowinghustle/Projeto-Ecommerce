<?php

require_once "models/Bookerr.php";
require_once "models/User.php";
require_once "models/FactoryBook.php";

class BookNaoPublicado extends AbstractBook implements Book
{
    public function publicar()
    {
    }

    public function getPublicado(): bool
    {
        return false;
    }



    public function renderizarCard(): string
    {
        return "";
    }
}
