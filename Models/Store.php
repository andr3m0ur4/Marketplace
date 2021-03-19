<?php

    namespace Models;

    use Core\Model;

    class Store extends Model
    {
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
    }
    