<!DOCTYPE html>
<html lang="pl">
	<head>
		<meta charset="utf-8">
		<title>Strona główna</title>
		<link rel="stylesheet" type="text/css" href="css/index.css">
		<link rel="stylesheet" type="text/css" hreg="css/jquery.fsscroll.css">
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
		<script type="text/javascript" src="js/jquery.fsscroll.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js"></script>
		<script type="text/javascript" src="js/script.js" defer></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<div class="page-header">
	        <div class="page-btn"><li><a href="index.php"><img src="img/iconIndex.png">Strona Główna</a></li></div>
	        <div class="page-btn"><li><a href="portal.php"><img src="img/megaphoneIndex.png">Ogłoszenia</a></li></div>
	    </div>

		<div class="menu">
		</div>
		
		<div class="content" data-fs-scroll>
			<div class="sections">
				<div class="section section1" id="page1">
					<h2>Czym się zajmujemy?</h2>
					<div>
					<p id="pleft">
					Nasza iniciatywa skupia się na pomaganiu w znalezieniu pracy przez osoby niepełnosprawny jak i tym, którzy nie do końca są obeznani z językiem czy naszą kulturą. Nasza nazwa strony wzieła się zresztą od nazwiska słynnego astrofizyka Stephena Williama Hawkinga, który osiągnał wielki sukces będac przykutym do wózka.
					</p>
					<img id="fim" src="img/hands.png">
					</div>
				</div>
				<div class="section section2" id="page2" style="background-color: #409EFF;">
					<h2>Osoby niepełnosprawne</h2>
					<div>
					<img id="fim2" src="img/wykresIndex.png">
					<p id="pleft2">
						Rynek pracy dla osób niepełnosprawnych jest dość mały przez co większość osób nawet nie próbuje podjąć żadnej pracy. Duża ilosć pracodawców również nie wie, że zatrudniając osobę niepełnosprawną dostaje się dofinansowanie.
					</p>
						<a href="https://www.pfron.org.pl/pracodawcy/dofinansowanie-wynagrodzen/wysokosc-dofinansowania-do-wynagrodzen-pracownikow-niepelnosprawnych/"><div id="nbttn">Dofinansowania</div></a>
					</div>
				</div>
				<div class="section section3" id="page3" style="background-color: #67C23A;">
					<h2>Uchodźcy</h2>
					<div>
					<p id="pleft4">
						Osoby które musiały opuścić swój kraj z obawy o swoje życie lub zdrowie są nazywane uchodźcami. Przez to, że media pokazują ich w niekorzystnym świetle (przedstawianie uchodźców jako terrorystów), stali się oni bardzo negatywnie postrzegani przez co często mają problem ze znalezieniem pracy. Pamiętajmy,że są to ludzie którzy są tacy jak my, więc również należy im się uczciwa praca.
					</p>
					<img id="fim4" src="img/earthIndex.png">
					</div>
				</div>
				<div class="section section4" id="page4" style="background-color: #E6A23C;">
					<h2>Ogłoszenia o pracę</h2>
					<div>
					<img id="fim5" src="img/humanResIndex.png">
					<p id="pleft5">
						Dzięki naszemu portalowi, możesz bezproblemowo zamieszczać swoje oferty pracy oraz szkolenia dla osób które mają problemy ze zdrowiem lub z innego powodu nie mogą znaleźć zatrudnienia. Użytkownik będzie mógł je zobaczyć według własnego uznania, pozwalają na to tagi, które są umieszczane przez pracodawcę podczas tworzenia oferty. Dzięki ograniczonej grupie odbiorców szukanie pracowników na odpowiednie stanowisko będzie szybsze i mniej pracochłonne.
						<a href="portal.php"><div id="nbttn2">Przejdź do portalu</div></a>
					</p>
					</div>
				</div>
				<div class="section section5" id="page5" style="background-color: #F56C6C;">
					<h2>Autorzy projektu</h2>
					<div>
                        <div class="authorBox">
                            <div class="authorTitle">
                                <h3>PHP &amp; SQL Developer</h3>
                            </div>
                            <div class="authorName">
                                <img src="img/php.png">
                                <img src="img/files.svg">
                                <h4>Wojciech Szczucki</h4>
                            </div>
                        </div>
                        <div class="authorBox">
                            <div class="authorTitle">
                                <h3>JS Developer</h3>
                            </div>
                            <div class="authorName">
                                <img src="img/js.png">
                                <h4>Maciek Kubus</h4>
                            </div>
                        </div>
                        <div class="authorBox">
                            <div class="authorTitle">
                                <h3>PHP Developer</h3>
                            </div>
                            <div class="authorName">
                                <img src="img/front.png">
                                <h4>Emil Łapka &nbsp; &amp; &nbsp; Damian Fuchler &nbsp; &amp; &nbsp; Wojciech Szczucki</h4>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</body>
</html>