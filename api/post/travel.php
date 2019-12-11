<?
    // TITLE
    // LOCATION
    // DATE
    // HOUR
    // ID_MEETINGPOINT
    // LATITUDE
    // LONGITUDE
    // DESCRIPTION
    // PHOTOS
    // AUTHORS

    > DODAWANIE PODRÓŻY
    > DODAWANIE AUTORÓW
    > DODAWANIE ZDJĘĆ
?>
// ADDING AUTHORS
            for ($i = 0; $i <= sizeof($authorsArray); $i++) {
                $id_author = $authorsArray[$i];
                if(sizeof(Authors::getAuthor($id)) > 0) {
                    // ADDING AUTHOR
                } else {
                    return "Author ". $id_author . " doesn't exist in database";
                }
            }