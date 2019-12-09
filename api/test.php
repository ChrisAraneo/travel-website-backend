<?
    include('../class/Main.php');
    
    $abc = new Main();
    if($abc->isLogged()) {
        echo "Zalogowany";
    } else {
        echo "Niezalogowany";
    }
    //echo $abc->isLogged();
?>