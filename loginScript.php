<?php
    if(!isset($_POST["login"]) || !isset($_POST["haslo"])){
        header("location: login.php");
        exit();
    }
    session_start(); // Tworzymy sesje. Potrzeba tak w każdym pliku
    require_once "config.php";
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    if($polaczenie -> connect_errno!=0)
        echo "Error: ".$polaczenie->connect_errno;
    else{
        $login = $_POST["login"];
        $haslo = $_POST["haslo"]; 
        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        $sql = sprintf("SELECT * FROM uzytkownicy WHERE mail='%s'", 
                       mysqli_real_escape_string($polaczenie,$login));
        if($rezultat = @$polaczenie->query($sql)){
            $iluUserow = $rezultat->num_rows; 
            if($iluUserow > 0){
                $wiersz = $rezultat->fetch_assoc(); //Tworzymy tablie asocjacyjna
                if(password_verify($haslo, $wiersz["haslo"])){
                    $_SESSION['zalogowany'] = true;
                    $_SESSION['userId'] = $wiersz['id']; 
                    $_SESSION["user"] = $wiersz["mail"];
                    $_SESSION["czyPraco"] = $wiersz["czyPracodawca"];
                    unset($_SESSION['blad']);
                    $rezultat->close(); // zwalniamy pamięć
                    header("Location: sukces.html");
                }
                else{
                    $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło</span>';
                    header("Location: login.php");
                    }  
            }
            else{
                $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło</span>';
                header("Location: login.php");
            }
        }
        else{
            echo("Blad zapytania mysql");
        }
        $polaczenie -> close();
    }
    
?>
