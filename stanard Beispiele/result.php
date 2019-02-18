<?php
	$result = false;
	$results = false;
	$noUser = false;
	
	if(isset($_GET['id']) && isset($_GET['month'])) {
		if($_GET['id'] != "" && $_GET['month'] != "") {
			$id = $_GET['id'];
			$month = $_GET['month'];
			require_once("db_inc.php");
			try {
				$stmt = $conn->prepare("SELECT Vorname,Nachname FROM tblkunden WHERE id = ".$id); 
				$stmt->execute();
				$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
				if($result){
					$data = $stmt->fetchAll();
					if ( count($data) > 0 ){
						$vorname = $data[0]['Vorname'];
						$nachname = $data[0]['Nachname'];
						
						$select = "SELECT e.Entlehnungsdatum,e.Rueckgabedatum,v.Name as 'VonName',n.Name as 'NachName'
						
						FROM tblentlehnungen e 
						
						JOIN tblstationsnamen v on e.StationVon=v.ID JOIN tblstationsnamen n on e.StationNach=n.ID WHERE e.KundenId = ".$id;
						
						if($month == "current") {
							$select .= " and MONTH(e.Entlehnungsdatum) = MONTH(CURRENT_DATE()) and YEAR(e.Entlehnungsdatum) = YEAR(CURRENT_DATE())";
						}
						
						$select .= " order by e.Entlehnungsdatum DESC";
						
						$stmt_rows = $conn->prepare($select);
						$stmt_rows->execute();
						$results = $stmt_rows->setFetchMode(PDO::FETCH_ASSOC);
					}else{
						$noUser = true;
					}
				}else{
					$noUser = true;
				}
			} catch(PDOException $e) {
				echo "Error: " . $e->getMessage();
			}
		
		}
	}
?>

<html>
	<head>
		<meta charset="utf-8"/>
		<title>Radverleih - Ergebniss</title>
	</head>
	<body>
		<?php
			if ( $result && !$noUser ) {
		?>
			<b>ID: <?= $id ?></b><br>
			Vorname: <?= $vorname ?><br>
			Nachname: <?= $nachname ?><br>
			<br>
			<br>
			<?php
				if ($results) {
			?>
				<table>
					<thead>
						<tr>
							<th>Entlehnungsdatum</th>
							<th>Rüeckgabedatum</th>
							<th>Station von</th>
							<th>Station nach</th>
						<tr>
					</thead>
					<tbody>
			<?php
					foreach($stmt_rows->fetchAll() as $k=>$v) {	
						$start = new DateTime($v['Entlehnungsdatum']);
						$end = new DateTime($v['Rueckgabedatum']);
						echo "
							<tr>
								<td>".$start->format("d.m.Y H:i")."</td>
								<td>".$end->format("d.m.Y H:i")."</td>
								<td>".$v['VonName']."</td>
								<td>".$v['NachName']."</td>
							</tr>
						";
						
					}
			?>
					</tbody>
				</table>
			<?php
				}else{
					echo "<p>Mit der angegebenen Daten wurden keine Einträge gefunden.</p>";
				}
			?>
			<a href="index.php">Zur Suche</a>
		<?php
			} elseif ( $noUser ) {
		?>
			<p>Mit der angegebenen KundenId wurde kein Kunde gefunden.</p>
			<a href="index.php">Zur Suche</a>
		<?php
			} else {
		?>
			<p>Es wurde keine gültige Suche durchgeführt</p>
			<a href="index.php">Zur Suche</a>
		<?php
			}
		?>
	</body>
<html>