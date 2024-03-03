<?php 

	if(isset($_POST['libelle'])) {

		$libelle = $_POST['libelle'];
		$description = $_POST['description'];
		$category_id = $_POST['category_id'];
		
		require_once("config.php");

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);

		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
			
		$query = "INSERT INTO product VALUES(null, '" . $libelle . "', " . $category_id . ", '" . $description . "')";

		$result = $conn->query($query);

		if (!$result) {
	        printf("Erreur : %s\n", $conn->error);
	    }

		//echo $result;

		$conn->close(); 

		header ('Location:./products.php?category_id=' . $category_id);
	}
?><html>
	<head></head>
	<body>


		<h1>Add new product</h1>

		<form action="" method="POST">
			Libelle <input type="text" name="libelle" /><br />
			Description <textarea name="description" ></textarea><br />
			Category id <input type="text" name="category_id" /><br />
			<input type="submit" name="submit" value="Submit" />
		</form>

	</body>
</html>