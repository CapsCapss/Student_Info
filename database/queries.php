<?php

    class Queries {

        public function getData(): array {
            require "database/connect.php";

            $sql = "SELECT * FROM students";

            $statement = $connection->prepare($sql);
            $statement->execute();

            $data = $statement->fetchAll(PDO::FETCH_OBJ);

            return $data;
        }
    }


?>
