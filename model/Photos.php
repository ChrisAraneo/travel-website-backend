<?
    include(dirname(__FILE__).'/Authors.php');
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
        public static uploadPhoto($file) {
            $target_file = dirname(__FILE__) . '/../upload/' . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $message = '';

            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($file["tmp_name"]);
                if($check !== false) {
                    $message = "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    $message = "File is not an image.";
                    $uploadOk = 0;
                }
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                $message = "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                $message = "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $message = "Sorry, your file was not uploaded.";
                return $message
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    $message = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                    return true;
                } else {
                    $message = "Sorry, there was an error uploading your file.";
                }
            }

            return $message;
        }
    }
 ?>