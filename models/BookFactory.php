<?php
require_once "models/BookBuilder.php";

class FactoryBookBuilder
{
    public static function create(Book $book, int $userId, string $mode = null): CardBuilder
    {
        $bookBuilder = new BookNotOwnerCardBuilder();

        if ($userId == $book->getUserId()) {
            $bookBuilder = new BookOwnerCardBuilder();

            switch ($mode) {
                case "view":
                    $bookBuilder->setIsView();
                    break;

                case "update":
                    $bookBuilder->setIsUpdate();
                    break;

                case "create":
                    $bookBuilder->setIsCreate();
                    break;

                default:
                    break;
            }
        }

        $bookBuilder->setBook($book);

        return $bookBuilder;
    }
}
