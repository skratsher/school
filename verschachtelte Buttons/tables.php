<html>
	<head>
	</head>
	<body>
		<?php
		$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliothek";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";
		
			echo 'Willkommen in der Datenbank: ' . htmlspecialchars($_GET["databasename"]) . '!';
			
			$dbname = $_GET["databasename"];
			
			$sql = "SHOW TABLES FROM bibliothek";
			$showtables= mysqli_query($conn, $sql);
			
//			while($row = mysqli_fetch_assoc($result)) {
				
//			}


/*while($table = mysql_fetch_array($showtables)) { // go through each row that was returned in $result
    echo($table[0] . "<BR>");    // print the table that was returned on that row.
}*/
			
if($stmt = $conn->query("SHOW TABLES FROM $dbname")){
  //echo "No of records : ".$stmt->num_rows."<br>";
  while ($row = $stmt->fetch_assoc()) {
	//echo $row['Database']."<br>".;
	echo "<tr>";
		echo "	<td>" . $row["Tables_in_bibliothek"] . "</td>";
		echo "	<td><button type=\"submit\" name=\"databasename\" value=\"" . $row["Tables_in_bibliothek"] . "\">Details</button></td>";
		echo "</tr>";
  }
}else{
echo $connection->error;
}

			
		?>
	</body>
</html>