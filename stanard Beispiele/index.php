<html>
<!-- Lucas Tichy, 10.10.2018, INF -->
	<head>
		<!-- Stylesheet Integration -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	</head>
	
	<body>
		<h1>Mitarbeiter erstellen</h1>
		<!-- Navigatinsbutton -->
		<form action="search.php">
			<input type="submit" value="Gehe zu Suche" />
		</form>
	
		<!-- Beginn PHP -->
		<?php 
			#PHP Notizen deaktiviert
			error_reporting(0);
			$strDbLocation = 'mysql:dbname=lapaufgabezwei;host=127.0.0.1';
			$strDbUser = 'root';
			$strDbPassword = '';
			
			try 
			{
				$objDb = new PDO($strDbLocation, $strDbUser, $strDbPassword);
			}catch(PDOException $e){
				echo 'Datenbank-Fehler: '. $e -> getMessage();
				}
			
			if(isset($_POST["vorname"]) && isset($_POST["nachname"]) && isset($_POST["entlehnungsdatum"]) && isset($_POST["rueckgabedatum"])){		
				#Variablen zuweisen
				$vorname = $_POST["vorname"];
				$nachname = $_POST["nachname"];
				$svnnr = $_POST["svnnr"];
				$abteilung = $_POST["abteilung"];
				
				#Insert SQL
				$sql = "INSERT INTO mitarbeiter (vorname, nachname, svnnr, abteilung) VALUES('$vorname','$nachname','$svnnr','$abteilung')";
				#var_dump($sql);
				
				
				try {
					$objDb->query($sql);
					#echo "New record created successfully";
				} catch(PDOException $e) 
				{
					echo 'Datenbank-Fehler: '. $e->getMessage();
				}
				
			}else{
				#echo "Eingabe ist leer";
			}
			
		?>
	<!-- Input Felder -->
	<form method="post">			
		<p>Bitte befüllen Sie nachstehende Felder:</p>
		<input type="text" name="vorname" placeholder="Vorname eingeben"><br><br>
		
		<input type="text" name="nachname" placeholder="Nachname eingeben"><br><br>
		
		<input type="text" name="svnnr" placeholder="SVNNr eingeben"><br><br>
		
		<input type="text" name="abteilung" placeholder="Abteilung eingeben"><br><br>
		<input type="submit" value="Mitarbeiter erstellen">
	</form>
	
	</body>
</html>