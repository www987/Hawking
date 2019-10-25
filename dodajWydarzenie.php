<?php
    session_start();
    if(!$_SESSION['zalogowany']){
        header("location: login.php");
        die();
    } 
    if(!$_SESSION['czyPraco']){
        header("location: portal.php");
        die();
    } 
if(isset($_POST["title"])){
    require_once("config.php");
    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
    $polaczenie -> query("SET NAMES 'utf8'");
    if($polaczenie->connect_errno!=0){
        echo "Przepraszamy za utrudnienia. Mamy problemy z bazą. Prosimy wrócić poźniej";
    }
    else{
        $tag = @$_POST['tags'];
        $title = $_POST["title"];
        $salary = $_POST["salary"]; 
        $city = $_POST["city"];
        $contract = $_POST["contract"];
        $notice = $_POST["notice"];
        $description = $_POST["php_post_text"];
        $wszystkoOk = true;
        
                            //pokazuje wszystkie tagi
        echo "<div style='position: fixed; width: 100vw; background-color: #eee; top: 0;'>";
        if($tag){ // sprawdza czy tag został dodany przez użytkownika
           foreach ($_POST['tags'] as $tagEl){
                if(strlen($tagEl) > 30){
                    $wszystkoOk = false;
                    $_SESSION["e_tag"] = "Tag musi nie może być dłuższy niż 30 znaków";
                }
                else echo strtoupper($tagEl).", ";
           }
               
        }
        else{
            $wszystkoOk = false;
            $_SESSION["e_tag"] = "Dodaj przynajmniej 1 tag";
        }
        echo "</div>";
        
        
        
                            //SPRAWDZAMY Tytuł//
        if(strlen($title) > 60 || strlen($title) <9 ){
            $wszystkoOk = false;
            $_SESSION["e_title"] = "Tytuł musi być w przedziale 10-60 znaków!";
        }

                            //SPRAWDZAMY WYPŁATE//
        $salary = preg_replace('~[^0-9|^.|(?=2.)]~', '', $salary);
        @$salary = round($salary,2);
        
                            //SPRAWDZAMY MIASTO//
        if(strlen($city) > 40 || strlen($city) < 2){
            $wszystkoOk = false;
            $_SESSION["e_city"] = "Miasto musi mieć od 3 do 40 znaków!";
        }
                            //SPRAWDZAMY OPIS//
        if(strlen($description) > 1000 || strlen($description) <= 50 ){
            $wszystkoOk = false;
            $_SESSION["e_description"] = "Opis musi być w przedziale 50-1000 znaków!";
        }
        
        if($wszystkoOk){
            foreach($tag as $i => $el){
                $tag[$i] = $polaczenie ->real_escape_string($el);
                $tag[$i] = strtoupper($el);
            }
            $title = $polaczenie->real_escape_string($title);
            $salary = $polaczenie->real_escape_string($salary);
            $city = $polaczenie->real_escape_string($city);
            $contract = $polaczenie->real_escape_string($contract);
            $notice = $polaczenie->real_escape_string($notice);
            $description = $polaczenie->real_escape_string($description);
        }
        
        function slownikID($baza, $wartosc, $polaczenie){
            $sqlSelect = "SELECT ID_$baza FROM $baza WHERE $baza = '$wartosc'";
            if($rezultat = $polaczenie -> query($sqlSelect)){
                if($rezultat -> num_rows >0){
                    $wiersz = $rezultat ->fetch_row();
                    return $wiersz[0];
                }
                else{
                    $rezultat = $polaczenie -> query("Insert into $baza VALUES(NULL, '$wartosc')");
                    $rezultat = $polaczenie -> query("$sqlSelect");
                    $wiersz = $rezultat ->fetch_row();
                    return $wiersz[0];
                }    
            }
        }
        
        if($wszystkoOk){
            
            $IDCity = slownikID("miasto", $city, $polaczenie);
            $IDContract = slownikID("umowa", $contract, $polaczenie);
            
            
            $IDTag = array();
            foreach($tag as $el){
                @$sqlSelectTag = "SELECT ID_tag FROM tag WHERE tag = '$el'";
                if($rezultat = $polaczenie ->query($sqlSelectTag)){
                    if($rezultat ->num_rows>0){
                        $wiersz = $rezultat ->fetch_row();
                        array_push($IDTag,$wiersz[0]);
                    }
                    else{
                        $rezultat = $polaczenie -> query("Insert into tag VALUES(NULL, '$el')");
                        $rezultat = $polaczenie -> query("$sqlSelectTag");
                        $wiersz = $rezultat ->fetch_row();
                        array_push($IDTag,$wiersz[0]);
                    }
                }
            }
            $rezultat = $polaczenie ->query("SELECT ID_ogloszenie from ogloszenie");
            $IDNotice = $rezultat->num_rows + 1;
            foreach($IDTag as $el){
                $rezultat = $polaczenie ->query("INSERT INTO tag_do_ogloszenia VALUES(NULL,$el, $IDNotice)");
            }
            
            if(strlen($salary) == "0") $salary="NULL";
            
            $insertSQL = "INSERT INTO ogloszenie VALUES(NULL, '$title', '$description', NULL, $salary, 1, $IDContract, $IDCity);";
            
            $insertALL = $polaczenie ->query($insertSQL);
            
        }
        
    }
    
}
    function errors($name){
        if(isset($_SESSION[$name])){
                echo '<h4 class="error">'.$_SESSION[$name]."</h4>";
                unset($_SESSION[$name]);
            }    
    }
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <title>Dodaj wydarzenie</title>
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="texteditor/css/bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="texteditor/css/site.css">
    <link rel="stylesheet" href="texteditor/css/richtext.min.css">

    <script src="texteditor/js/jquery.min.js"></script>
    <script src="texteditor/js/jquery.richtext.js"></script>

    <link rel="stylesheet" href="css/add.css">
    
</head>
<body>
    <form method="post" id="loginForm">
        <div class="subPage" id="sub1">
            <h3>Podaj tytuł</h3>
            <input type="text" name="title">
            <?php errors("e_title");?>
            <div class="next">Dalej</div>
        </div>
        <div class="subPage" id="sub2">
            <div class="prev">Wstecz</div>
            <h3>Podaj wynagrodzenie</h3>
            <h4>pozostaw puste jeśli do ustalenia</h4>
            <input type="text" name="salary">
            <?php errors("e_salary");?>
            <div class="next">Dalej</div>
        </div>
        <div class="subPage" id="sub3">
            <div class="prev">Wstecz</div>
            <h3>Podaj miasto</h3>
            <input type="text" name="city">
            <?php errors("e_city");?>
            <div class="next">Dalej</div>
        </div>
        <div class="subPage" id="sub4">
            <div class="prev">Wstecz</div>
            <h3>Wybierz rodzaj umowy:</h3>
            <select name="contract">
                <!-- Jak ktos bedzie to zmienial to musi sprawdzac ID-->
                <option value="Umowa o pracę">Umowa o pracę</option>
                <option value="Umowa zlecenie">Umowa zlecenie</option>
                <option value="Umowa o dzieło">Umowa o dzieło</option>
                <option value="Inny">Inny</option>
            </select>
            <?php errors("e_contract");?>
            <div class="next">Dalej</div>
        </div>
        <div class="subPage" id="sub5">
            <div class="prev">Wstecz</div>
            <h3>Wybierz rodzaj ogłoszenia:</h3>
            <select name="notice">
                <!-- Jak ktos bedzie to zmienial to musi sprawdzac ID-->
                <option value="PRACA">o pracę</option>
                <option value="SZKOLENIE">szkolenie</option>
            </select>
            <?php errors("e_notice");?>
            <div class="next">Dalej</div>
        </div>
        <div class="subPage" id="sub6">
            <div class="prev">Wstecz</div>
            <h3>Opis ogłoszenia</h3>
            <div>
                <!-----------------pseodo text area-------->
                <textarea id="php_post_text" name="php_post_text" placeholder="blog Description" class="form-control " style="display:none;"></textarea>
                <!----------------MAIN TEXT EDITOR-------->
                <textarea id="y" class="form-control content" name="example"></textarea>
                 <!---------------ON SUBMIT ASIGN VALUE OF PSEOUDO TEXT AREA WITH TEXT EDITOR-------->
            </div>
            <div style="width: 4px; height: 4px; margin-top: 2vw;"></div>
            <?php errors("e_description");?>
            <div class="next">Dalej</div>
        </div>
        <div class="subPage" id="sub7">
            <div class="prev">Wstecz</div>
            <h3>Wybierz tagi</h3>
            <h4>kliknij na dodany wcześniej tag by go usunąć</h4>
            <div id="tagAdd">
                <input type="text" id="tagInput" placeholder="Nowy tag">
                <div id="tagAddBtn">+</div>
            </div>
            <?php errors("e_tag");?>
            <div id="tags"></div>
            <input class="next" type="submit" value="Zakończ i dodaj ogloszenie"  name="save_text" onclick="$('#php_post_text').val($('.content').val());">
        </div>
        <!--div class="subPage" id="sub8">
            <div class="prev">Wstecz</div>
            <input type ="submit" value="Potwierdź"  name="save_text" onclick="$('#php_post_text').val($('.content').val());">
        </div-->
    </form>
    <script>
        $(document).ready(function() {
            $('.content').richText();
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js"></script>
    <script src="js/add.js"></script>
</body>
</html>