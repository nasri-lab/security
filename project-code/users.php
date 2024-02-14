<html>
	<head></head>
	<body>


		<h1>Users</h1>

		<?php 

			require_once("config.php");

			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);

			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			}

			$result = $conn->query("SELECT * FROM account");

			if ($result->num_rows <= 0) 
				echo 'Aucun utilisateur trouvé<br /><br />'; 
			else {

				echo '<table><tr><th>ID</th><th>NAME</th><th>EMAIL</th><th>PASSWORD</th><th>PROFILE</th></tr>';

				while ($row = $result->fetch_assoc()) {
			        $id 		= $row["id"];
			        $name 		= $row["name"];
			        $email 		= $row["email"];
			        $password 		= $row["password"];
			        $profil 		= $row["profile"];
			
				?>
					<tr>
						<td><?php echo $id; ?></td>
						<td><?php echo $name; ?></td>
						<td><?php echo $email; ?></td>
						<td><?php echo $password; ?></td>
						<td><?php echo $profil; ?></td>
					</tr>
			<?php

				}

				echo '</table>';

			}
		
			$conn->close(); 
		?>

	</body>
</html>