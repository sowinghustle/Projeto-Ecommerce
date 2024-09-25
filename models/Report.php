<?php
    require_once "models/BookList.php";
    require_once "models/Bookerr.php";
    require_once "models/User.php";

     class Report {
        private $books;
        private $users;

        public function getBooks() {
            return $this->books;
        }

        public function getUsers() {
            return $this->users;
        }

        public function fillData() {
            $bookList = new BookList("");
            if (!$bookList->fillByAllBooks()){
                return false;
            }
            $this->books = $bookList->getBooks();
            return $this->fillByAllUsers();
        }


        public function fillByAllUsers(){
            try {
                $db = Database::getDatabase();
                $stmt = $db->pdo->prepare("SELECT c.id, c.username, c.password, c.email, c.is_admin FROM users c");
                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->users = array();
                foreach($rows as $row){
                  $user = new User($row['username'], $row['email'], $row['password'], $row['id']);
                  if ($row['is_admin'] == 1) {
                    $user->setIsAdmin();
                  }

                  array_push($this->users, $user);
                }
                return true;
            } catch (Exception $e) {
                var_dump($e);
                $this->throw_exception();
            }
    
            return false;
        }

        private function throw_exception()
        {
            throw Bookerr::Exception("Desculpe, ocorreu um erro e não foi possível completar a requisição!");
        }
    }