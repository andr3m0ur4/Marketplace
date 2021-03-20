<?php

    namespace Models;

    use Core\Model;

    class Store extends Model
    {
        private $id_store;

        public function getAll()
        {
            $array = [];

            $sql = "SELECT * FROM stores";
            $sql = $this->db->query($sql);

            if ($sql->rowCount() > 0) {
                $array = $sql->fetchAll(\PDO::FETCH_OBJ);
            }

            return $array;
        }

        public function checkCredentials($email, $password) {
            $sql = "SELECT id, password FROM stores WHERE email = :email";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(':email', $email);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $store = $sql->fetch(\PDO::FETCH_OBJ);

                if (password_verify($password, $store->password)) {
                    $this->id_store = $store->id;

                    return true;
                }
            }

            return false;
        }

        public function createJWT()
        {
            $jwt = new JWT();
            return $jwt->create(['id_store' => $this->id_store]);
        }
    }
    