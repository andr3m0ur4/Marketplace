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

        public function create()
        {
            $sql = "INSERT INTO addresses (
                    public_place, number, neighborhood, complement, city, uf, zip_code
                ) VALUES (
                    :public_place, :number, :neighborhood, :complement, :city, :uf, :zip_code
                )
            ";
            $result = $this->query($sql, [
                ':public_place' => $this->public_place,
                ':number' => $this->number,
                ':neighborhood' => $this->neighborhood,
                ':complement' => $this->complement,
                ':city' => $this->city,
                ':uf' => $this->uf,
                ':zip_code' => $this->zip_code
            ]);

            if ($result) {
                $this->id_address = $this->db->lastInsertId();
                return true;
            }

            return false;
        }
    }