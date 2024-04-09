<?php

require_once "BaseController.php";

class BookController extends BaseController
{
    public function index()
    {
        $this->view->title = "Books";
        include "views/book/list.php";
    }

    public function create()
    {
        $this->ensureIsLogged();

        if ($this->requestIsPOST()) {
        } else {
        }

        $this->view->title = "Create Book";
        include "views/book/create.php";
    }

    public function update()
    {
        $this->ensureIsLogged();

        if ($this->requestIsPOST()) {
        } else {
        }

        $this->view->title = "Update Book";
        include "views/book/update.php";
    }

    public function delete()
    {
        $this->ensureIsLogged();

        if (!$this->requestIsPOST()) {
            header("location:/books");
            return;
        }
    }

    private function ensureIsLogged()
    {
        if (!$this->isUserLogged()) {
            header("location:/books");
            return;
        }
    }

    private function ensureIsAdmin()
    {
        if (!$this->isAdmin()) {
            header("location:/books");
            return;
        }
    }
}
