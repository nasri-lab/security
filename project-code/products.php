<html>
	<head></head>
	<body>

		<?php require_once "menu.php"; ?>
		
		<h1>Products</h1>

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

				echo '<table><tr><th>ID</th><th>LABEL</th><th>ID CATEGORY</th><th>DESCRIPTION</th><th></th></tr>';

				while ($row = $result->fetch_assoc()) {
			        $id 		= $row["id"];
			        $label 		= $row["label"];
			        $description 		= $row["description"];
			        $idCategory 		= $row["id_category"];
			
				?>
					<tr>
						<td><?php echo $id; ?></td>
						<td><?php echo $label; ?></td>
						<td><?php echo $idCategory; ?></td>
						<td><?php echo $description; ?></td>
						<td><a href="delete-product.php">Delete</a></td>
					</tr>
			<?php

				}

				echo '</table>';

			}
		
			$conn->close(); 
		?>

		<br /><a href="add-product.php">+ Add new product</a>

	</body>
</html>