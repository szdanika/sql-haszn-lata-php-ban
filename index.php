<style>
	div#lista
	{
		float: left;
		width : 256 px;
	}
	
	div#reszletek
	{
		margin: left;
	}
</style>



<?php // ahoz hogy használni tudd a sql adatbázist meg kell nyitni phpmyadminba (legyen benne ugyebár)
$servernev = "localhost";
$felhasznalonev ="root";
$jelszo = NULL;
$tablanev ="orszagok";
$adatbazis = mysqli_connect($servernev, $felhasznalonev, $jelszo, $tablanev); //csatlakozás sql táblához mysqli_connect(serverneve, felhasznalonev, jelszo, adatbázis neve)

$ertek = mysqli_query($adatbazis, "SELECT * FROM orszagok WHERE foldr_hely LIKE 'Nyugat-Európa'" ); // adatbázisról lekérdezés   mysqli_query( adatbazisneve , "sql parancssor ")  //'$_GET[$v]' behelyetesítés egy sql lekérdezésébe
$x = mysqli_fetch_array($ertek);			//feltördeli a sql lekérdezést (egy tömböt add majd vissza aminek több része van )
//print_r($x); // így kapod meg 		mysqli_fetch_assoc nevkent hivatkozik az oszlopokra, a mysqli_fetch_array viszont megadja sorrendbe és névként is 
echo "<br>";
	echo"<div id='lista'>";
while($sor = mysqli_fetch_array($ertek)) // így lehet kiíratni az összes értékét 
{
		echo "<a href='./?okod=". $sor['0'] ."'>". $sor['2'] . "</a> <br>";
}
	echo"</div>";


	if(isset($_GET['okod'])) // kiírás ha az adott linkre kattintva szeretnénk megjeleníteni egy oldalt
	{
		$segedvalatozo = $_GET['okod']; // változó hogy ne keveredjen össze a lekérdezésnél
		$tabla = mysqli_query($adatbazis, "SELECT *, nepesseg*1000/terulet AS nepsuruseg FROM orszagok WHERE id = '$segedvalatozo'" ); // lekerdezés az adott országról
		$sor = $sor = mysqli_fetch_array($tabla); // az érték amit lekonventáltuk a lekérdezés után  (ha ilyet kérdezünk le akkor egy értéket kapunk vissza)
		echo "
			<div id='reszletek'>
				<span> Ország :</span>". $sor['orszag']."<br> 
				<span> Fovaros:</span>". $sor['fovaros']."<br>
				<span> Foldrajzi hely:</span>". $sor['foldr_hely']."<br>
				<span> terület:</span>". $sor['terulet']."<br>
				<span> államforma:</span>". $sor['allamforma']."<br>
				<span>  népsürüség php:</span> ". $sor['nepesseg'] * 1000/ $sor['terulet'] . " <br>
				<span> népsürüség sql: </span> ". $sor['nepsuruseg'] . "<br>
			
			
				
			</div>
		"; // itt kiírtuk az adott adatokat az adott várossal kapcsolatban 
		
		
		
	}










mysqli_close($adatbazis); // sql tábla lecsatlakozása lezárása
?>