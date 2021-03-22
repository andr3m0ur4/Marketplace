<?php

    namespace Models;

    use Core\Model;

    class Address extends Model
    {
        private $id_address;

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

        public function getId()
        {
            return $this->id_address;
        }

        public function getAddress()
        {
            $data = [];

            $sql = "SELECT * FROM addresses WHERE id = :id";
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
            $sql = "INSERT INTO addresses (
                    public_place, number, neighborhood, complement, city, uf, zip_code, id_store
                ) VALUES (
                    :public_place, :number, :neighborhood, :complement, :city, :uf, :zip_code, :id_store
                )
            ";
            $result = $this->query($sql, [
                ':public_place' => $this->public_place,
                ':number' => $this->number,
                ':neighborhood' => $this->neighborhood,
                ':complement' => $this->complement,
                ':city' => $this->city,
                ':uf' => $this->uf,
                ':zip_code' => $this->zip_code,
                ':id_store' => $this->id_store
            ]);

            if ($result) {
                return true;
            }

            return false;
        }

        public function editAddress($id)
        {
            if ($this->id === $id) {
                $address = $this->getAddress();
                $this->validateAttributes($address);

                $sql = "UPDATE addresses SET
                        public_place = :public_place, number = :number, neighborhood = :neighborhood,
                        complement = :complement, city = :city, uf = :uf, zip_code = :zip_code
                    WHERE id = :id";

                $this->query($sql, [
                    ':id' => $address->id,
                    ':public_place' => $address->public_place,
                    ':number' => $address->number,
                    ':neighborhood' => $address->neighborhood,
                    ':complement' => $address->complement,
                    ':city' => $address->city,
                    ':uf' => $address->uf,
                    ':zip_code' => $address->zip_code
                ]);

                return '';
            }

            return 'Não é permitido editar outra loja.';
        }

        public function delete()
        {
            $sql = "DELETE FROM addresses WHERE id = :id";
            $this->query($sql, [
                ':id' => $this->id
            ]);
        }

        private function validateAttributes($address)
        {
            if (!empty($this->public_place)) {
                $address->public_place = $this->public_place;
            }
            if (!empty($this->number)) {
                $address->number = $this->number;
            }
            if (!empty($this->neighborhood)) {
                $address->neighborhood = $this->neighborhood;
            }
            if (!empty($this->complement)) {
                $address->complement = $this->complement;
            }
            if (!empty($this->city)) {
                $address->city = $this->city;
            }
            if (!empty($this->uf)) {
                $address->uf = $this->uf;
            }
            if (!empty($this->zip_code)) {
                $address->zip_code = $this->zip_code;
            }
        }
    }
