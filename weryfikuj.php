<?php
session_start();
$user=$_POST['user']; // login z formularza
$pass=$_POST['pass']; // hasło z formularza
$link = mysqli_connect('serwer1686836.home.pl', '21695415_kucharski','e8,9qabC-1ip', '21695415_kucharski'); // połączenie z BD – wpisać swoje parametry !!!
if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); } // obsługa błędu połączenia z BD
mysqli_query($link, "SET NAMES 'utf8'"); // ustawienie polskich znaków
$result = mysqli_query($link, "SELECT * FROM user WHERE login='$user'"); // pobranie z BD wiersza, w którym login=login z formularza
$rekord = mysqli_fetch_array($result); // wiersza z BD, struktura zmiennej jak w BD
$id_user = $rekord['id'];
$il_bl_log =  $rekord['il_bl_log'];
$ip = $_SERVER["REMOTE_ADDR"];
$time=time();
$time2=date("r",$time);
if(!$rekord) //Jeśli brak, to nie ma użytkownika o podanym loginie
{
	mysqli_close($link); // zamknięcie połączenia z BD
	echo "Brak użytkownika o takim loginie !"; // UWAGA nie wyświetlamy takich podpowiedzi dla hakerów
	echo '<br>'; echo '<a href="./index.html"><input type="button" value="Powrót" /></a>';
}
else
{ // Jeśli $rekord istnieje

	if($il_bl_log<3){
	if($rekord['haslo']==$pass) // czy hasło zgadza się z BD
	{
	$dodawanie = mysqli_query($link, "INSERT INTO logi values(null, '$id_user', '$ip', '$time2','1' )")or die('Błąd zapytania');
	$aktualizacja = mysqli_query($link, "UPDATE user SET il_bl_log=0 WHERE id='$id_user' ")or die('Błąd zapytania2');
	$_SESSION['zalogowany_user'] = $user;
	$_SESSION['zalogowany_user_id'] = $id_user;
	$URL="./panel_user.php"; //URL do pliku
	$sec=0; //Liczba sekund opóźnienia
	header("refresh: ".$sec.";URL=".$URL);
	}
	else
	{
	$il_bl_log=$il_bl_log+1;
	$dodawanie = mysqli_query($link, "INSERT INTO logi values(null, '$id_user', '$ip', '$time2','0' )")or die('Błąd zapytania3');
	$aktualizacja = mysqli_query($link, "UPDATE user SET il_bl_log='$il_bl_log' WHERE id='$id_user' ")or die('Błąd zapytania4');
	mysqli_close($link);
	if($il_bl_log==3){echo "Konto zablokowane po 3 nieudanych probach logowania !";echo '<br>';}
	else{
		$poz_il=3-$il_bl_log;
		echo "Błąd w haśle ! Pozostaly $poz_il proby/a logowania. "; 
		}
	echo '<br>'; echo '<a href="./index.html"><input type="button" value="Powrót" /></a>';
	}
	}
	else{
		echo "Konto zablokowane !"; // UWAGA nie wyświetlamy takich podpowiedzi dla hakerów
		echo '<br>'; echo '<a href="./index.html"><input type="button" value="Powrót" /></a>';
	}
}
?>
</BODY>
</HTML>
