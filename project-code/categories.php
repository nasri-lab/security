<html>
	<head></head>
	<body>

		<?php require_once "menu.php"; ?>
		
		<h1>Categories</h1>
		
		<?php 

			require_once("config.php");
			
			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);

			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			}

			$result = $conn->query("SELECT * FROM category");

			if ($result->num_rows <= 0) 
				echo 'Aucune catégorie trouvée<br /><br />'; 
			else {

				echo '<table><tr><th>ID</th><th>LABEL</th><th>ACTIONS</th></tr>';

				while ($row = $result->fetch_assoc()) {
			        $id 		= $row["id"];
			        $label 		= $row["label"];
			
				?>
					<tr>
						<td><?php echo $id; ?></td>
						<td><?php echo $label; ?></td>
						<td><a href="products.php?category_id=<?php echo $id; ?>">Products</a></td>
					</tr>
			<?php

				}

				echo '</table>';

			}
		
			$conn->close(); 
		?>

	</body>
</html>