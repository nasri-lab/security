<html>
	<head></head>
	<body>

		<?php 

			session_start();

			$_SESSION['user_id'] = "lkad12321";

			if(isset($_POST['id'])) {

				$id = $_POST['id'];
				$libelle = $_POST['libelle'];
				$category_id = $_POST['category_id'];
				
				require_once("config.php");

				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);

				// Check connection
				if ($conn->connect_error) {
				    die("Connection failed: " . $conn->connect_error);
				}
					
				echo $libelle;
				
				$query = "INSERT INTO product VALUES(" . $id . ", '" . $libelle . "', " . $category_id . ")";

				echo $query;

				$result = $conn->query($query);

				if (!$result) {
			        printf("Erreur : %s\n", $conn->error);
			    }

				echo $result;

				$conn->close(); 

			}
		?>

		<form action="" method="POST">
			product id <input type="text" name="id" /><br />
			product libelle <input type="text" name="libelle" /><br />
			product category id <input type="text" name="category_id" /><br />
			<input type="submit" name="submit" value="Submit" />
		</form>

	</body>
</html>