<?php

    namespace Core;
    
    class Model
    {
        protected $db;

        public function __construct()
        {
            global $config;

            try {
                $db = new \PDO(
                    "mysql:dbname={$config['dbname']};host={$config['host']};charset=utf8",
                    $config['dbuser'],
                    $config['dbpass']
                );
                $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                die("ERRO: {$e->getMessage()}");
            }
            
            $this->db = $db;
        }

        private function setParams($statement, $parameters = [])
        {
            foreach ($parameters as $key => $value) {
                $this->bindParam($statement, $key, $value);
            }
        }

        private function bindParam($statement, $key, $value)
        {
            $statement->bindValue($key, $value);
        }

        public function query($rawQuery, $params = [])
        {
            $statement = $this->db->prepare($rawQuery);

            $this->setParams($statement, $params);

            return $statement->execute();
        }

        public function select($rawQuery, $class, $params = [])
        {
            $data = [];

            $statement = $this->db->prepare($rawQuery);

            $this->setParams($statement, $params);

            $statement->execute();

            if ($statement->rowCount() > 0) {
                $data = $statement->fetchAll(\PDO::FETCH_CLASS, get_class($class));
            }

            return $data;
        }
    }
    