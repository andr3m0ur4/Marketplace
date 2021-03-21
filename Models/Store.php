<?php

    namespace Models;

    use Core\Model;

    class Store extends Model
    {
        private $id_store;

        public function __get($name)
        {
            return $this->$name;
        }

        public function __set($name, $value)
        {
            $this->$name = $value;
        }

        public function setData($data = [])
        {
            foreach ($data as $key => $value) {
                $this->__set($key, $value);
            }
        }

        public function getAll()
        {
            $sql = "SELECT * FROM stores";
            return $this->select($sql, $this);
        }

        public function getId()
        {
            return $this->id_store;
        }

        public function getStore()
        {
            $data = [];

            $sql = "SELECT * FROM stores AS s
                INNER JOIN addresses AS a ON s.id_address = a.id
                WHERE s.id = :id";
            $result = $this->select($sql, $this, [
                ':id' => $this->id
            ]);

            if (count($result) > 0) {
                $data = $result[0];
            }

            return $data;
        }

        public function create()
        {
            if (!$this->emailExists()) {
                $hash = password_hash($this->password, PASSWORD_DEFAULT);
                $address = new Address();
                $address->setData($this->address);
                
                if ($address->create()) {
                    $sql = "INSERT INTO stores (
                            fantasy_name, cnpj, company_name, id_address, phone, cell_phone,
                            responsible_contact, email, password
                        ) VALUES (
                            :fantasy_name, :cnpj, :company_name, :id_address, :phone, :cell_phone,
                            :responsible_contact, :email, :password
                        )
                    ";
                    $this->query($sql, [
                        ':fantasy_name' => $this->fantasy_name,
                        ':cnpj' => $this->cnpj,
                        ':company_name' => $this->company_name,
                        ':id_address' => $address->id_address,
                        ':phone' => $this->phone,
                        ':cell_phone' => $this->cell_phone,
                        ':responsible_contact' => $this->responsible_contact,
                        ':email' => $this->email,
                        ':password' => $hash
                    ]);

                    $this->id_store = $this->db->lastInsertId();

                    return true;
                }
            }

            return false;
        }

        public function checkCredentials() {
            $sql = "SELECT id, password FROM stores WHERE email = :email";
            $data = $this->select($sql, $this, [
                ':email' => $this->email
            ]);

            if (count($data) > 0) {
                $store = $data[0];

                if (password_verify($this->password, $store->password)) {
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

        public function validateJWT($token)
        {
            $jwt = new JWT();
            $value = $jwt->validate($token);

            if (isset($value->id_store)) {
                $this->id_store = $value->id_store;
                return true;
            }

            return false;
        }

        private function emailExists()
        {
            $sql = "SELECT id FROM stores WHERE email = :email";
            $data = $this->select($sql, $this, [
                ':email' => $this->email
            ]);

            if (count($data) > 0) {
                return true;
            }

            return false;
        }
    }
    