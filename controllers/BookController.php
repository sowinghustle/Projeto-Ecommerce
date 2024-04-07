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
        if ($this->requestIsPOST()) {
        } else {
        }

        $this->view->title = "Create Book";
        include "views/book/create.php";
    }

    public function update()
    {
        if ($this->requestIsPOST()) {
        } else {
        }

        $this->view->title = "Update Book";
        include "views/book/update.php";
    }

    public function delete()
    {
        if (!$this->requestIsPOST()) {
            header("location:/books");
            return;
        }
    }
}
