<!DOCTYPE html>
<?php 
    session_start();
    if(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany']){
        header("location: portal.php");
        exit();
    }
?>
<html lang="pl">
	<head>
		<title>Logowanie</title>
		<link rel="stylesheet" href="css/login.css">
		<meta charset="utf-8">
	</head>
	<body>
		<section> </section>
		<form class="col-10 col-s-6s" id="loginForm" action="loginScript.php" method="post">
			<h2 id="loginHeader">Login</h2>
			<label to="username">Email</label> 
			<input id="username" type="text" name="login" placeholder="" autocomplete="off">
			<label to="password">Hasło</label> 
			<input id="password" type="password" name="haslo" placeholder="" autocomplete="off">
			<div id="blad">
			<?php 
				if(isset($_SESSION['blad']))echo $_SESSION['blad']."<br>";
			?>
			</div>
			<div class="btnBox col-3 col-s-6s">
				<input type="submit" value="Zaloguj">
			</div>
            <a href="rejestracja.php">Nie masz konta? Zarejestruj się!</a>     
		</form>

		<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js"></script>
		<script src="js/scriptLogin.js"></script>
	</body>
</html>