<html>
	<head></head>
	<body>

		<?php 

			require_once("config.php");

			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);

			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			}

			$id_category = $_GET['category_id'];
				

			$result = $conn->query("SELECT * FROM product WHERE id_category = " . $id_category);

			//echo "SELECT * FROM product WHERE id_category = " . $id_category;

			if ($result->num_rows <= 0) 
				echo 'Aucun produit trouvé<br /><br />'; 
			else {

				echo '<table>';

				while ($row = $result->fetch_assoc()) {
			        $id 		= $row["id"];
			        $label 		= $row["label"];
			        $idCategory 		= $row["id_category"];
			
				?>
					<tr>
						<td><?php echo $id; ?></td>
						<td><?php echo $label; ?></td>
						<td><?php echo $idCategory; ?></td>
					</tr>
			<?php

				}

				echo '</table>';

			}
		
			$conn->close(); 
		?>

	</body>
</html>