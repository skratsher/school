

<html>
<!-- Lucas Tichy, 17.09.2018, INF -->
	<head>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<meta charset="UTF-8">
	</head>
	<body>
			<h1>Suche</h1>
			<!-- Navigation 
			<form action="index.php">
				<input type="submit" value="Gehe zu Eingabe" />
			</form>
			</br>-->
			
			<!-- Suchfeld -->
		</br>
		<form method="post">			
			<input type="text" name="searchfield" placeholder="ID eingeben">	
			<input type="submit" value="Suchen">
		
		</br>
		</br>
			
		<!-- Ratio Buttons -->
		<label>Zeitraum:</label>
		</br>
		<input type="radio" name="radio" value="currentmonth">Aktueller Monat</br>
		<input type="radio" name="radio" value="all" checked="checked">Alle</br>
		</form>
				
			<!-- Beginn PHP -->
		<?php 
			error_reporting(0);
			#Erstellung des Tables
			echo "<table style='border: solid 1px black;'>";
			echo "<tr><th>Entlehungsdatum</th><th>Rückgabedatum</th><th>Station von</th><th>Station nach</th></tr>";
			
			

			class TableRows extends RecursiveIteratorIterator { 
				function __construct($it) { 
					parent::__construct($it, self::LEAVES_ONLY); 
				}

				function current() {
					return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
				}

				function beginChildren() { 
					echo "<tr>"; 
				} 

				function endChildren() { 
					echo "</tr>" . "\n";
				} 
			} 
			
			#Login festlegen
			$strDbLocation = 'mysql:dbname=lapaufgabezwei;host=127.0.0.1';
			$strDbUser = 'root';
			$strDbPassword = '';
			#Login
			try 
			{
				$objDb = new PDO($strDbLocation, $strDbUser, $strDbPassword);
			}
			catch(PDOException $e) 
			{
				echo 'Datenbank-Fehler: '. $e -> getMessage();
			}
			
			if(isset($_POST["searchfield"]))
			{		
		
				$searchfield = $_POST["searchfield"];						
				
				
				
				try {
					$objDb->query($sql);
					#echo "Filter erfolgreich";
				} catch(PDOException $e) 
				{
					echo 'Datenbank-Fehler: '. $e->getMessage();
				}
				}else{
				#echo "Eingabe ist leer \n"; 
				
			}
			$selected_radio = $_POST['radio'];
			#var_dump($_POST);
			if ($selected_radio == 'all'){
			
				#Select query
				try {
					$objDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sql = "SELECT  tblentlehnungen.entlehnungsdatum, 
					tblentlehnungen.rueckgabedatum, s1.name as stationvon, s2.name as 
					stationnach
					from tblentlehnungen 
					inner JOIN tblkunden ON tblentlehnungen.kundenid=tblkunden.id
					inner join tblstationsnamen as s1 on tblentlehnungen.stationvon=s1.id
					inner join tblstationsnamen as s2 on tblentlehnungen.stationnach=s2.id
							
							WHERE kundenid ='$searchfield'";
							#var_dump($sql);
					$stmt = $objDb->prepare($sql);
					$stmt->execute();

					// set the resulting array to associative
					$result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
					
					foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
						echo $v;
					}
					
					$sql = "SELECT Vorname, Nachname FROM tblkunden WHERE ID='$searchfield'";
					$stmt = $objDb->prepare($sql);
					$stmt->execute();
					$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
					
					$user = $stmt->fetchAll();
					echo "Vorname: " . $user[0]['Vorname'] . ' ';
					echo "<br />";
					echo "Nachname: " . $user[0]['Nachname'];
				}
				catch(PDOException $e) {
					echo "Error: " . $e->getMessage();
				}
				$sql = null;
				echo "</table>";
				
			}else{
			#Select query current month
				try {
					$objDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sql = "SELECT  tblentlehnungen.entlehnungsdatum, 
					tblentlehnungen.rueckgabedatum, s1.name as stationvon, s2.name as 
					stationnach
					from tblentlehnungen 
					inner JOIN tblkunden ON tblentlehnungen.kundenid=tblkunden.id
					inner join tblstationsnamen as s1 on tblentlehnungen.stationvon=s1.id
					inner join tblstationsnamen as s2 on tblentlehnungen.stationnach=s2.id
							
							WHERE kundenid ='$searchfield' AND MONTH(tblentlehnungen.entlehnungsdatum) = MONTH(CURRENT_DATE())";
							#var_dump($sql);
					$stmt = $objDb->prepare($sql);
					$stmt->execute();

					// set the resulting array to associative
					$result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
					
					foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
						echo $v;
					}
					
					$sql = "SELECT Vorname, Nachname FROM tblkunden WHERE ID='$searchfield'";
					$stmt = $objDb->prepare($sql);
					$stmt->execute();
					$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
					
					$user = $stmt->fetchAll();
					echo "Vorname: " . $user[0]['Vorname'] . ' ';
					echo "<br />";
					echo "Nachname: " . $user[0]['Nachname'];
				}
				catch(PDOException $e) {
					echo "Error: " . $e->getMessage();
				}
				$sql = null;
				echo "</table>";
			
			
			}
		
		?>
		
		
	</body>
</html>