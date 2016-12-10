<?php
/*session_start();
if (isset($_SESSION['zalogowany_user'])){
	header('Location: http://serwer1686836.home.pl/kucharski/z6/panel_user.php');
}
}*/
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<BODY>
Formularz rejestracji
<form method="post">
Login:<input type="text" name="user" maxlength="20" size="20"><br>
Haslo:<input type="password" name="pass" maxlength="20" size="20"><br>
<input type="submit" value="Rejestruj"/>
<br><br>
<a href="./index.html"><input type="button" value="Powrót" /></a>
</form>
<?php
$user=$_POST['user']; // login z formularza
$pass=$_POST['pass']; // hasło z formularza
$link = mysqli_connect('serwer1686836.home.pl', '21695415_kucharski','e8,9qabC-1ip', '21695415_kucharski'); // połączenie z BD – wpisać swoje parametry !!!
if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); } // obsługa błędu połączenia z BD
mysqli_query($link, "SET NAMES 'utf8'"); // ustawienie polskich znaków
$result = mysqli_query($link, "SELECT * FROM user WHERE login='$user'"); // pobranie z BD wiersza, w którym login=login z formularza
$rekord = mysqli_fetch_array($result); // wiersza z BD, struktura zmiennej jak w BD
if(isset($_POST["user"])){
if($rekord){
	echo "Podany login jest zajety";
}
else{
	mkdir("./users/$user", 0777);
	$dodawanie = mysqli_query($link, "INSERT INTO user values(null, '$user', '$pass', '0' )")or die('Błąd zapytania');
	echo "Rejestracja udana. Mozesz powrocic do strony logowania";
}
}
?>
</BODY>
</HTML>