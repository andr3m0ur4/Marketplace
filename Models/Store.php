<?php

    namespace Models;

    use Core\Model;
    use Models\Address;

    class Store extends Model
    {
        private $id_store;

        public function __get($name)
        {
            return $this->$name ?? null;
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

            $sql = "SELECT * FROM stores WHERE id = :id";
            $result = $this->select($sql, $this, [
                ':id' => $this->getId()
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

                $sql = "INSERT INTO stores (
                        fantasy_name, cnpj, company_name, phone, cell_phone,
                        responsible_contact, email, password
                    ) VALUES (
                        :fantasy_name, :cnpj, :company_name, :phone, :cell_phone,
                        :responsible_contact, :email, :password
                    )
                ";
                $result = $this->query($sql, [
                    ':fantasy_name' => $this->fantasy_name,
                    ':cnpj' => $this->cnpj,
                    ':company_name' => $this->company_name,
                    ':phone' => $this->phone,
                    ':cell_phone' => $this->cell_phone,
                    ':responsible_contact' => $this->responsible_contact,
                    ':email' => $this->email,
                    ':password' => $hash
                ]);

                if ($result) {
                    $this->id_store = $this->db->lastInsertId();

                    $address = new Address();
                    $address->setData($this->address);
                    $address->id_store = $this->id_store;
                    
                    if ($address->create()) {
                        return true;
                    }
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

        public function editStore()
        {
            if ($this->id === $this->getId()) {
                $store = $this->getStore();
                $this->validateAttributes($store);

                $sql = "UPDATE stores SET
                        fantasy_name = :fantasy_name, cnpj = :cnpj, company_name = :company_name,
                        phone = :phone, cell_phone = :cell_phone, responsible_contact = :responsible_contact,
                        email = :email, password = :password
                    WHERE id = :id";

                $this->query($sql, [
                    ':id' => $store->id,
                    ':fantasy_name' => $store->fantasy_name,
                    ':cnpj' => $store->cnpj,
                    ':company_name' => $store->company_name,
                    ':phone' => $store->phone,
                    ':cell_phone' => $store->cell_phone,
                    ':responsible_contact' => $store->responsible_contact,
                    ':email' => $store->email,
                    ':password' => $store->password,
                ]);

                return '';
            }

            return 'N??o ?? permitido editar outra loja.';
        }

        public function delete()
        {
            if ($this->id === $this->getId()) {
                $store = $this->getStore();

                $sql = "DELETE FROM stores WHERE id = :id";
                $this->query($sql, [
                    ':id' => $this->id
                ]);

                $address = new Address();
                $address->id = $store->id_address;
                $address->delete();
                return '';
            } else {
                return 'N??o ?? permitido excluir outro usu??rio.';
            }
        }

        public function total()
        {
            $sql = "SELECT COUNT(*) AS counter FROM stores";
            $results = $this->select($sql, $this);
            return $results[0]->counter;
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
                $this->id_store = intval($value->id_store);
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

        private function validateAttributes($store)
        {
            if (!empty($this->fantasy_name)) {
                $store->fantasy_name = $this->fantasy_name;
            }
            if (!empty($this->cnpj)) {
                $store->cnpj = $this->cnpj;
            }
            if (!empty($this->company_name)) {
                $store->company_name = $this->company_name;
            }
            if (!empty($this->phone)) {
                $store->phone = $this->phone;
            }
            if (!empty($this->cell_phone)) {
                $store->cell_phone = $this->cell_phone;
            }
            if (!empty($this->responsible_contact)) {
                $store->responsible_contact = $this->responsible_contact;
            }
            if (!empty($this->email)) {
                if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                    if (!$this->emailExists($this->email)) {
                        $store->email = $this->email;
                    } else {
                        return 'Novo e-mail j?? existe.';
                    }
                } else {
                    return 'E-mail inv??lido!';
                }
            }
            if (!empty($this->password)) {
                $store->password = password_hash($this->password, PASSWORD_DEFAULT);
            }
        }
    }
    