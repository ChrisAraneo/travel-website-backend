<?
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

        private static function saveImage($file) {
            $target = dirname(__FILE__, 1) . '/upload/' . basename($file["name"]);
            $filetype = strtolower(pathinfo($target, PATHINFO_EXTENSION));

            $data = file_get_contents($file["tmp_name"]);
            $base64 = 'data:image/' . $filetype . ';base64,' . base64_encode($data);

            $file_handler = fopen($target . '.php', "w");

            $text = "<?php' . '\n";
            $text .= Include(dirname(__FILE__).'/../class/Login.php');" . "\n";
            $text .= "header('Access-Control-Allow-Origin: *');" . "\n";
            $text .= "header('Content-Type: application/json');" . "\n";
            $text .= "\$result_logged = Login::isLogged();" . "\n";
            $text .= "if(\$result_logged['success'] == true) {" . "\n";
            $text .= "    echo json_encode(array(" . "\n";
            $text .= "        'success' => true," . "\n";
            $text .= "        'message' => '" . basename($file["name"]) . ".php'," . "\n";
            $text .= "        'data' => \" . $base64 .\"" . "\n";
            $text .= "    ));" . "\n";
            $text .= "} else {" . "\n";
            $text .= "    echo json_encode(\$result_logged);" . "\n";
            $text .= "}" . "\n";
            $text .= "?>" . "\n";

            fwrite($file_handler, $text);
            fclose($file_handler);

            return array(
                "success" => true,
                "message" => 'File saved at ' . $target . '.php'
            );
        }

        public static function uploadPhoto($file) {
            $target = dirname(__FILE__, 1) . '/upload/' . basename($file["name"]);
            $filetype = strtolower(pathinfo($target, PATHINFO_EXTENSION));
            $message = '';
            $ok = true;

            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($file["tmp_name"]);
                if($check !== false) {
                    $message .= "File is an image - " . $check["mime"] . ". ";
                    $ok = true;
                } else {
                    $message .= "File is not an image. ";
                    $ok = false;
                }
            }

            // Check if file already exists
            if (file_exists($target . '.php')) {
                $message .= "Sorry, file already exists. ";
                $ok = false;
            }

            // Check file size
            if ($file["size"] > 500000) {
                $message .= "Sorry, your file is too large. ";
                $ok = false;
            }

            // Allow certain file formats
            if($filetype != "jpg" && $filetype != "png" && $filetype != "jpeg"
            && $filetype != "gif" ) {
                $message .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
                $ok = 0;
            }

            // Check if $ok is set to false by an error
            if ($ok == false) {
                $message .= "Sorry, your file was not uploaded. ";
            }
            // if everything is ok, try to upload file
            else {
                
                $result = Photos::saveImage($file);
                
                if($result['success'] == true) {
                    return array(
                        "success" => true,
                        'message' => $message . $result['message']
                    );
                } else {
                    $message .= "Sorry, there was an error uploading your file. " . $result['message'];
                }
            }

            return array(
                "success" => false,
                "message" => $message
            );
        }

        public static function postPhoto($conn, $id_travel, $filename) {
            // CHECKING IF TRAVEL EXIST
            if(sizeof(Travels::getTravel($conn, $id_tarvel)) < 1) {
                return array(
                    'success' => false,
                    'message' => "Travel ". $id_travel . " doesn't exist in database"
                );
            }

            $query = 'INSERT INTO Photos (id_travel, filename) VALUES ('
            . $id_travel . ', '
            . '\'' . $filename . '\');';

            $statement = $conn->prepare($query);
            $statement->execute();

            return array(
                'success' => true,
                'message' => 'OK'
            );
        }
    }
 ?>