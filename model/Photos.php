<?

    include_once(dirname(__FILE__).'/Travels.php');

    /*
        CREATE TABLE Photos (
            id_photo int NOT NULL AUTO_INCREMENT,
            id_travel int NOT NULL,
            filename varchar(255),
            PRIMARY KEY (id_photo),
            FOREIGN KEY (id_travel) REFERENCES Travels(id_travel)
        );
    */
    class Photos {

        public static function saveBase64Photo($base64, $id_travel) {
            $dirname = dirname(__FILE__).'/../upload';
            if(!is_dir($dirname)) {
                try {
                    mkdir($dirname, 0755);
                } catch (Exception $e) {
                    return array(
                        "success" => false,
                        "message" => $e->getMessage()
                    );
                }
            }

            $filename = md5($base64 . $id_travel . time());
            while(file_exists($filename)) {
                $filename = md5($base64 . $id_travel . time());
            }

            try {
                $file = fopen(dirname(__FILE__).'/../upload/'. $filename .'.php', "w");

                if(!$file) {
                    return array(
                        "success" => false,
                        "message" => "Error opening file"
                    );
                }
            } catch (Exception $e) {
                return array(
                    "success" => false,
                    "message" => $e->getMessage()
                );
            }

            $text = "<?php\n";
            $text .= "include_once(dirname(__FILE__).'/../class/Request.php');\n";
            $text .= "if(Request::getUser() == true) {\n";
            $text .= "echo json_encode(array(\n";
            $text .= "'success' => true,\n'message' => 'OK',\n'data' => '";
            $text .= $base64;
            $text .= "'\n));\n}\n";
            $text .= "?>";
            
            try {
                fwrite($file, $text);
            } catch (Exception $e) {
                return array(
                    "success" => false,
                    "message" => $e->getMessage()
                );
            }
            
            try {
                fclose($file);
            } catch (Exception $e) {
                return array(
                    "success" => false,
                    "message" => $e->getMessage()
                );
            }
            
            return array(
                "success" => true,
                "message" => "Base64 image saved",
                "filename" => $filename
            );
        }

        public static function getPhotos($conn) {
            $query = 'SELECT * FROM Photos;';

            $statement = $conn->prepare($query);
            $statement->execute();

            $array = array();

            if($statement->rowCount() > 0) {
                while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $item = array(
                        'id_photo' => $id_photo,
                        'id_travel' => $id_travel,
                        'filename' => $filename
                    );
                    array_push($array, $item);
                }
            }
            
            return $array;
        }

        public static function postPhoto($conn, $id_travel, $filename) {
            // CHECKING IF TRAVEL EXIST
            if(sizeof(Travels::getTravel($conn, $id_travel)) < 1) {
                return array(
                    'success' => false,
                    'message' => "Travel ". $id_travel . " doesn't exist in database",
                    'filename' => $filename
                );
            }

            $query = 'INSERT INTO Photos (id_travel, filename) VALUES ('
            . $id_travel . ', '
            . '\'' . $filename . '\');';

            $statement = $conn->prepare($query);
            $statement->execute();

            return array(
                'success' => true,
                'message' => 'OK',
                'filename' => $filename
            );
        }
    }
 ?>