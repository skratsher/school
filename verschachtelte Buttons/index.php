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

			




?>
<form action="/tables.php">

<?php

if($stmt = $conn->query("SHOW DATABASES")){
  //echo "No of records : ".$stmt->num_rows."<br>";
  while ($row = $stmt->fetch_assoc()) {
	//echo $row['Database']."<br>".;
	echo "<tr>";
		echo "	<td>" . $row["Database"] . "</td>";
		echo "	<td><button type=\"submit\" name=\"databasename\" value=\"" . $row["Database"] . "\">Details</button></td>";
		echo "</tr>";
  }
}else{
echo $connection->error;
}

?>
</form>

</body>
</html>