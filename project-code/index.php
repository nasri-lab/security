<?php 

	require_once("config.php");

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	$connectedId 		= null;
	$connectedName 		= null;
	$connectedProfile 	= null;

	$message = '';

	if(isset ($_POST['email'])) {

		$email 		= $_POST['email'];
		$user_password 	= $_POST['password'];

		$sql = "SELECT * FROM account WHERE email = '" . $email . "' AND password = '" . MD5($user_password) . "' ";

		//echo $sql;

		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		    
		    if($row = $result->fetch_assoc()) {
		        $connectedId 		= $row["id"];
		        $connectedName 		= $row["name"];
		        $connectedProfile 	= $row["profile"];
		    }

		} else {
			$message = 'Données invalides';
		}

	}

	$conn->close(); 

	if($connectedId) {
			
		header( 'Location: ./categories.php' );
		die();

		/*echo 'Vous êtes connectés : ' . $connectedName . ' avec le profile : ' . $connectedProfile . '<br /><br />

		Cliquez <a href="categories.php">ici</a> pour lister des catégorie<br /><br />'; */
	} 

?><html>
	<head></head>
	<body>

		<h1>Login</h1>

		<?php if ( !$connectedId ) { ?>
			<span style="color:red; font-weight: bold;"><?php echo $message; ?></span><br /><br />
		<?php } ?>
		
		<form action='index.php' method="post">
			<table>
				<tr>
					<td>Email :</td>
					<td><input type="text" name="email" required="required"/></td>
				</tr>
				<tr>
					<td>Password :</td>
					<td><input type="password" name="password" value=""/></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="submit" value="Connexion" /></td>
				</tr>		
			</table>	
		</form>
	</body>
</html>