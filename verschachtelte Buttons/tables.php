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
			
			while($row = mysqli_fetch_assoc($result)) {
				
			}
			


			
		?>
	</body>
</html>