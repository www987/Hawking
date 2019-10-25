<?php
    session_start();
    $isLoged = true;
    if(!@$_SESSION['zalogowany'])
        $isLoged = false;
?>

<!DOCTYPE>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal</title>
    <link rel="stylesheet" href="css/poprtal.css" type="text/css">
</head>

<body>
    <div class="page-header">
	        <div class="page-btn"><li><a href="index.php"><img src="img/iconIndex.png">Strona Główna</a></li></div>
	        <div class="page-btn"><li><a href="portal.php"><img src="img/megaphoneIndex.png">Ogłoszenia</a></li></div>
	    </div>
    <div id="left">
        <!--Zalogowany-->
        
    </div>
    <div id="praca">OFERTY PRACY
       <?php    
    
    /*
        0 - id ogłoszenie
        1 - umowa o pracę
        2 - pracodawca
        3 - miasto
        4 - tytuł
        5 - opis
        6 - data
        7 - wynagrodznie
        8 - tagi
        Tablica[wiersz w tablicy][kolumna][*jesli tag to istnieje]
    */
    function getData() {
        require("config.php");
        $db = new mysqli($host, $db_user, $db_password, $db_name);
        $db -> query("SET NAMES 'utf8'");
        $res = $db->query("SELECT ogloszenie.ID_ogloszenie, umowa.umowa, pracodawca.pracodawca, miasto.miasto, ogloszenie.tytul, ogloszenie.opis, ogloszenie.data, ogloszenie.wynagrodzenie FROM ogloszenie INNER JOIN uzytkownicy on uzytkownicy.ID_uzytkownicy = ogloszenie.ID_uzytkownicy INNER JOIN imie on imie.ID_imie = uzytkownicy.ID_imie INNER JOIN nazwisko on nazwisko.ID_nazwisko = uzytkownicy.ID_nazwisko INNER JOIN miasto on  miasto.ID_miasto  = ogloszenie.ID_miasto INNER JOIN umowa on umowa.ID_umowa = ogloszenie.ID_umowa INNER JOIN pracodawca on  pracodawca.ID_pracodawca = uzytkownicy.ID_pracodawca");
        $table = array();
        while($row = $res->fetch_row()){ // wypisujemy wiersze z 1 zapytania
            $oneRow = array(); // do tablicy 1 wiersz bedziemy wrzucac
            $res2 = $db->query("SELECT tag.tag, ogloszenie.ID_ogloszenie FROM tag_do_ogloszenia INNER JOIN ogloszenie on ogloszenie.ID_ogloszenie = tag_do_ogloszenia.ID_ogloszenie INNER JOIN tag on tag.ID_tag = tag_do_ogloszenia.ID_tag WHERE ogloszenie.ID_ogloszenie = ".$row[0]);
            foreach($row as $el)
                array_push($oneRow, $el); // wrzucamy wiersze do tablicy
            $deepRow = array();
            while($row2 = $res2->fetch_row()) // wypisujemy wiersze z 2 zapytania
                array_push($deepRow, $row2[0]);
            array_push($oneRow, $deepRow); // pcha tagi na 2 poziom tablicy
            array_push($table, $oneRow);    // wrzucamy do kazdej tablicy, wiersz dzieki czemu mozemy sie do tego odwoływać łatwo
        }
        $db->close();
        return $table;
    }
    $table = getData();
    $wyn = "Płaca do ustalenia";
    
    foreach($table as $row){
        $tag="";
        if($row[7])
            $wyn = $row[7]." zł/msc";
        foreach($row[8] as $tagWloz) $tag .= "#".$tagWloz." ";
        
        echo <<<END
        <div class="port" tags="$tag">
            <div class="kolumna1">
                <h1>$row[4]</h1>
                <h3>$row[2]</h3>
                <p>$row[5]</p>
            </div>
            <div class="kolumna2">
                <h1>$wyn</h1>
                <h3>$row[1]</h3>
                <h3>$row[3]</h3>
            </div>
            <div class = "kolumna3">
                <div style="display: none;">
                    <label><input type="checkbox"> dodaj do obserwowanych</label>
                </div>
                <div>
                    <h4>$tag</h4>
                </div>
            </div>
            <div class="klik" style="display: none;">Więcej</div>
        </div>
END;
    }

?>
    </div>
</div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="js/portal.js"></script>

    <div class="menu hidden">
        <div id="user">
            <?php
                if(@$_SESSION['user']){
                echo"<div class='user_text'>Zalogowany jako <span class='mailText'><br>".@$_SESSION['user']."</span></div>
            
                <a href='logout.php' class='user_log'>
                    <img src='img/shutdownPortal.png'>
                </a></div>";
                    if($_SESSION['czyPraco']) 
                        echo "<div id='dodajOgloszenie'><a style='color:white;' href='dodajWydarzenie.php'>Dodaj ogłoszenie</a></div>
                    ";
                }
                else
                    echo "<div class='user_text'>Nie zalogowano
                        <a href='login.php'>Zaloguj się</a>
                    </div></div>";
            ?>
        
        <!--Pierwszy temat-->
        <div id="con">
            <h2>TAGI</h2>
            <?php
                require("config.php");
                $db = new mysqli($host, $db_user, $db_password, $db_name);
                $db->query("SET NAMES 'utf8'");
                $res = $db->query("SELECT * FROM `tag`");
                while($row = $res->fetch_row())
                    echo '<div class="box_s">'.$row[1].'<div tag="'.$row[1].'" onclick="Portal.change(this, '."'".$row[1]."'".')" class="x active">Ukryj</div></div>';
                $db->close();
            ?>
        </div>
    </div>
		<div class="btn" id="menuHide">Pokaż/Schowaj menu</div>

		<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js"></script>
		<script type="text/javascript">
			$('.btn').on('click', () => {
				if($('.menu.hidden').length >= 1){
					TweenMax.to($('.menu.hidden'), 1, {left: "0"});	
					$('.menu.hidden').addClass('active')
					$('.menu.hidden').removeClass('hidden')
				} else {
					TweenMax.to($('.menu.active'), 1, {left: "-35vw"});	
					$('.menu.active').addClass('hidden')
					$('.menu.active').removeClass('active')
				}
			})
		</script>
</body>

</html>
