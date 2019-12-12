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
            if (file_exists($target)) {
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
                if (move_uploaded_file($file["tmp_name"], $target)) {
                    $message .= "The file ". basename( $file["name"]). " has been uploaded. ";
                    return array(
                        "success" => true,
                        "message" => $message
                    );
                } else {
                    $message .= "Sorry, there was an error uploading your file. ";
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
                return "Travel ". $id_travel . " doesn't exist in database";
            }

            $query = 'INSERT INTO Photos (id_travel, filename) VALUES ('
            . $id_travel . ', '
            . '\'' . $filename . '\');';

            $statement = $conn->prepare($query);
            $statement->execute();

            return true;
        }
    }
 ?>