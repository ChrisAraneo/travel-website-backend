<?php
    /*
        CREATE TABLE Users (
            id_user int NOT NULL AUTO_INCREMENT,
            username varchar(255) NOT NULL,
            password varchar(255) NOT NULL,
            PRIMARY KEY (id_user)
        );
    */

    class Users {
        public static function getUser($conn, $username) {
            $query = 'SELECT * FROM Users WHERE username = \'' . $username . '\';';

            $statement = $conn->prepare($query);
            $statement->execute();

            $array = array();

            if($statement->rowCount() > 0) {
                while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $item = array(
                        'id_user' => $id_user,
                        'username' => $username,
                        'password' => $password
                    );
                    array_push($array, $item);
                }
            }
            
            return $array;
        }

        public static function postUser($conn, $username, $password) {
            $result = Users::getUser($conn, $username);

            if(empty($result)) {
                $hash = password_hash($password, PASSWORD_DEFAULT);

                $query = 'INSERT INTO Users (username, password) VALUES ('
                . '\'' . $username . '\', '
                . '\'' . $hash . '\');';
    
                $statement = $conn->prepare($query);
                $statement->execute();
    
                return array(
                    'success' => true,
                    'message' => 'OK'
                );
            }
            
            return array(
                'success' => false,
                'message' => 'This username already exist'
            );
        }
    }
?>