<?php
    session_start();
    if(isset($_POST['mail'])){
        $wszystkoOK = true; // warunek dla walidacji
                    //SPRAWDZANIE IMIENIA I NAZWISKA//
        $imie = $_POST["name"]; $nazwisko = $_POST["surname"];
        if(strlen($imie) > 35 || strlen($imie) < 3){
            $wszystkoOK = false;
            $_SESSION["e_name"] = "Podaj prawidłowe imie";
        }
        
        if(strlen($nazwisko) > 50 || strlen($nazwisko) <3){
            $wszystkoOK = false;
            $_SESSION["e_surname"] = "Podaj prawidłowe nazwisko";
        }
                    //SPRAWDZANIE NR_TELEFONU//
        $telefon= $_POST["phnNum"];
        $telefonS = filter_var($telefon, FILTER_SANITIZE_NUMBER_INT);
        if($telefon != $telefonS){
            $wszystkoOK = false;
            $_SESSION["e_phnNum"] = "Podaj prawidłowy nr telefonu";
        }
        if(strlen($telefon) !=0){
            if(strlen($telefon) != 9){
            $wszystkoOK = false;
            $_SESSION["e_phnNum"] = "Nr telefonu musi zawierać tylko 9 cyfr";
            }
        }
        
        if($wszystkoOK && strlen($telefon) !=0){//sprawdzic
           for($i=0;$i<strlen($telefon);$i++){
               if($telefon[$i] === "+" || $telefon[$i] == "-" || $telefon[$i] == " "){
                   $wszystkoOK = false;
                   $_SESSION["e_phnNum"] = "Nr telefonu nie może zawierać + lub - lub znaku spacji";
               }
           }
               
        }
        
                    //SPRAWDZANIE MAILA//
        $mail = $_POST["mail"];
        
        //CZYSCIMY MAIL ze złych znaków $, ł...
        $mailS = filter_var($mail, FILTER_SANITIZE_EMAIL);
        //Sprawdzamy czy po sanityzacja ciąg znaków może być mailem
        if(!filter_var($mailS, FILTER_VALIDATE_EMAIL) || $mail != $mailS){
            $wszystkoOK = false;
            $_SESSION["e_mail"] = "Podaj poprawny adres email!";
        }
        
                    //SPRAWDZANIE HASŁA//
        $password1 = $_POST["password1"];
        $password2 = $_POST["password2"];
        
        if(strlen($password1) < 8 || strlen($password1) > 16){
            $wszystkoOK = false;
            $_SESSION["e_password"] = "Hasło musi zawierać od 8 do 16 znaków!";
        }
        
        if($password1 != $password2){
             $wszystkoOK = false;
             $_SESSION["e_password"] = "Hasła nie są identyczne";
        }
        // algorytm się może w przyszłości zmienić, dlatego w bazie
        // długość znaku powinna być conajmniej 255
        // PASSWORD_DEFAULT oznacza najnowszy sposób zabezpieczenia danych
        $password_hash = password_hash($password1, PASSWORD_BCRYPT);
                
                    //SPRAWDZANIE CHECKBOXA//
        if(!isset($_POST["regulamin"])){
             $wszystkoOK = false;
             $_SESSION["e_checkbox"] = "Zaakceptuj regulamin";
        }
        
                    //SPRAWDZANIE PRACODAWCY//
        $pracodawca = $_POST["pracodawca"];
        $czyPracodawca = $_POST["czyPracodawca"];
        if($czyPracodawca){
           if(strlen($pracodawca) > 60){
                $wszystkoOK = false;
                $_SESSION["e_pracodawca"] = "Zbyt długa nazwa firmy!";
            }
           if(strlen($pracodawca) < 2){
                $wszystkoOK = false;
                $_SESSION["e_pracodawca"] = "Zbyt krótka nazwa firmy!";
           }
        }
         
        
                    //SPRAWDZANIE LOGINU I MAILA - REDUNDANCJA + WSZYSTKOOK//
        mysqli_report(MYSQLI_REPORT_STRICT); // rzucamy exceptionami zamiast warningami
        try{
            require_once("config.php");
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
            $polaczenie -> query("SET NAMES 'utf8'");
            if($polaczenie->connect_errno!=0){
                throw new Exception(mysqli_connect_errno());
            }
            else{
                @$imie = $polaczenie->real_escape_string($imie);
                @$nazwisko = $polaczenie->real_escape_string($nazwisko);
                @$pracodawca = $polaczenie->real_escape_string($pracodawca);
                $checkName = "SELECT ID_imie FROM imie WHERE imie = '$imie'";
                $insertName = "Insert into imie VALUES('','$imie')";
                
                $checkSurname = "SELECT ID_nazwisko FROM nazwisko WHERE nazwisko = '$nazwisko'";
                $insertSurname = "Insert into nazwisko VALUES('','$nazwisko')";
                
                $checkPracodawca = "SELECT ID_pracodawca FROM pracodawca WHERE pracodawca = '$pracodawca'";
                $insertPracodawca = "Insert into pracodawca VALUES('','$pracodawca')";
                
                if($wszystkoOK){
                    $rezultat = $polaczenie->query($checkName);
                    if(!$rezultat) throw new Exception($polaczenie->error);
                    if($rezultat -> num_rows == 0){
                        $polaczenie->query($insertName);
                    }

                    $rezultat = $polaczenie->query($checkName);
                    $wiersz = $rezultat -> fetch_assoc();
                    $ID_imie = $wiersz["ID_imie"];

                                //NAZWISKO//

                    $rezultat = $polaczenie->query($checkSurname);
                    if(!$rezultat) throw new Exception($polaczenie->error);
                    $iloscWierszy = $rezultat -> num_rows;

                    if($rezultat -> num_rows == 0){
                        $polaczenie->query($insertSurname);
                    }

                    $rezultat = $polaczenie->query($checkSurname);
                    $wiersz = $rezultat -> fetch_assoc();
                    $ID_nazwisko = $wiersz["ID_nazwisko"];
                    
                    
                                //PRACODAWCA//
                    if(strlen($pracodawca) !=0){
                        $rezultat = $polaczenie->query($checkPracodawca);
                        if(!$rezultat) throw new Exception($polaczenie->error);
                        $iloscWierszy = $rezultat -> num_rows;

                        if($rezultat -> num_rows == 0){
                            $polaczenie->query($insertPracodawca);
                        }

                        $rezultat = $polaczenie->query($checkPracodawca);
                        $wiersz = $rezultat -> fetch_assoc();
                        $ID_pracodawca = $wiersz["ID_pracodawca"]; 
                    }
                    else $ID_pracodawca = "NULL";
                    
                }
                
                
                
                $checkMail =  "SELECT ID_uzytkownicy FROM uzytkownicy WHERE mail = '$mailS'";
                $checkNumber =  "SELECT ID_uzytkownicy FROM uzytkownicy WHERE nr_telefonu = '$telefon' AND nr_telefonu != ''";
                @$insertData = "Insert into uzytkownicy VALUES(NULL,'$ID_imie', '$ID_nazwisko', '$mail', $czyPracodawca, '$telefon','$password_hash', $ID_pracodawca)";
    
                $rezultat = $polaczenie->query($checkMail);
                if(!$rezultat) throw new Exception($polaczenie->error);
                $iloscMaili = $rezultat -> num_rows;
                if($iloscMaili > 0){
                    $wszystkoOK = false;
                    $_SESSION["e_mail"] = "Podany mail już istnieje w bazie!";
                }
                
                $rezultat = $polaczenie->query($checkNumber);
                if(!$rezultat) throw new Exception($polaczenie->error);
                $iloscNumerow = $rezultat -> num_rows;
                if($iloscNumerow > 0){
                    $wszystkoOK = false;
                    $_SESSION["e_phnNum"] = "Podany nr telefonu juz istnieje w bazie";
                }
                if($wszystkoOK){
                    $rezultat = $polaczenie->query($insertData);
                    if(!$rezultat) throw new Exception($polaczenie->error);
                    $_SESSION["zarejestrowany"] = true;
                    
                    header("location: witaj.html");
                }
                $polaczenie->close();
            }
        }
        catch(Exception $e){
            echo "<div class='error'>Wystąpił nieoczekiwany błąd. Prosze wrócić później. Za niedogodności szczerze przepraszamy.</div>";
            echo $e;
        }
    }
    function errors($name){
        if(isset($_SESSION[$name])){
                echo '<p class="errorsd">'.$_SESSION[$name]."</p>";
                unset($_SESSION[$name]);
            }    
    }
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Zarejestruj się</title>
		<link rel="stylesheet" href="CSS/rejestracja.css">    
    <style>
        .error {
            color: red;
            width: 100%;
            background-color: black;
            text-align: center;
            float: left;
        }
        
        .errorsd{
            color: red;
        }

    </style>
</head>
<body>
		<section> </section>    
		<form class="col-10 col-s-6" id="loginForm" method="post">
            <h2 id="loginHeader">Rejestracja</h2>    
        <label to="name">Imie</label>   
        <input id="name" type="text" name="name" placeholder="" autocomplete="off">
        			<div id="blad">     
                        <?php errors("e_name");?>
                    </div>    
        <label to="surname">Nazwisko</label>  
        <input id="surname" type="text" name="surname" placeholder="" autocomplete="off">
        			<div id="blad">               
                        <?php errors("e_surname");?>
                    </div>  
        <label to="mail">Mail(login)</label>  
        <input type="text" name="mail" id="mail" placeholder="" autocomplete="off">
                <div id="blad">          
                    <?php errors("e_mail");?>
                </div>
        <label to="password1">Haslo</label>  
        <input type="password" name="password1" id="password1" placeholder="" autocomplete="off">
                <div id="blad">             
                    <?php errors("e_password");?>
                </div>
        <label to="password2">Potwierdź hasło</label> 
        <input type="password" name="password2" id="password2" placeholder="" autocomplete="off">
        
        <label to="phnNum">Nr telefonu (Opcjonalne)</label> 
        <input type="text" name="phnNum" id="phnNum" placeholder="" autocomplete="off">
                <div id="blad">             
                    <?php errors("e_phnNum");?>
                </div>    
   
        
        <div class="cjp">    
            <label class="nieLabel">
                <input type="checkbox" name="regulamin">
                Akceptuje <a href="regulamin.html">regulamin</a>
            </label>

            <div id="blad"> 
                <br>
                <?php errors("e_checkbox");?>
            </div>  
        </div>
            
        <div class="cjp">
            
                Kim jesteś?<br>
              
                        <label class="nieLabel"><input onclick="hide()" id="pracodawcaButton" type="radio" name="czyPracodawca" value="1" checked>
                        Pracodawcą</label>
                        <label class="nieLabel"><input type="radio"  onclick="hide()" name="czyPracodawca" value="0">             
                        Pracownikiem</label>
                     
        </div> 
            
        <div id="pracodawcaText" class="cjp">                      
            <input type="text" name="pracodawca" id="pracodawca" placeholder="Podaj nazwę firmy" autocomplete="off">
            <div id="blad">            
                <?php errors("e_pracodawca");?>
            </div> 
        </div>    
 
			<div class="btnBox">
				<input type="submit" value="Zarejestruj się">
			</div>            
            
    </form>
    <script>
        function hide(){
            $pracodawcaButton = document.getElementById("pracodawcaButton");
            $pracodawcaText = document.getElementById("pracodawcaText");
            if($pracodawcaButton.checked){
                $pracodawcaText.style.display="initial";
            }
            else{
                $pracodawcaText.style.display="none";
            }
        }
        
 function showhide(id) {
  if (document.getElementById) {
    var divid = document.getElementById(id);
    var divs = document.getElementsByClassName("hideable");
    for (var i = 0; i < divs.length; i = i + 1) {
      $(divs[i]).fadeOut("slow");
    }
    $(divid).fadeIn("slow");
  }
  return false;
}
        
    </script>    
		<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js"></script>
		<script src="js/scriptlogin.js"></script>        
</body>
</html>
<?php //Sanityzacja imiona, nazwiska i wywalanie błędu ?>