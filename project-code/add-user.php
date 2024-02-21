<html>
	<head></head>
	<body>


		<h1>Add new user</h1>

		<?php 

			if(isset($_POST['name'])) {

				$name = $_POST['name'];
				$email = $_POST['email'];
				$user_password = $_POST['password'];
				$profile = $_POST['profile'];
				
				require_once("config.php");

				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);

				// Check connection
				if ($conn->connect_error) {
				    die("Connection failed: " . $conn->connect_error);
				}
					
				echo $libelle;
				
				$query = "INSERT INTO account VALUES(null, '" . $name . "', '" . $email . "', '" . MD5($user_password) . "', '" . $profile . "')";

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
			User name <input type="text" name="name" /><br />
			User email <input type="email" name="email" /><br />
			User password <input type="password" name="password" /><br />
			User profile <select name="profile">
				<option value="user">User</option>
				<option value="admin">Admin</option>
			</select>
			<br />
			<input type="submit" name="submit" value="Submit" />
		</form>

	</body>
</html>