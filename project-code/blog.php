<html>
	<head></head>
	<body>

		<?php require_once "menu.php"; ?>
		
		<h1>Blog Posts</h1>
		
		<?php 
		require_once("config.php");
		
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);

		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}


		// Check if form was submitted
		if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['title']) && !empty($_POST['content'])) {
		    
		    $title = $_POST['title']; // In a real application, sanitize this input
		    $content = $_POST['content']; // In a real application, sanitize this input

		    // Prepare an insert statement
		    $query = "INSERT INTO blog_posts (title, content) VALUES ('" . $title . "', '" . $content . "')";
		    
		    $result = $conn->query($query);

			if (!$result) {
			    printf("Erreur : %s\n", $conn->error);
			}
		}

		$result = $conn->query("SELECT title, content, post_date FROM blog_posts ORDER BY post_date DESC");

		if ($result->num_rows <= 0) 
			echo 'Aucun post trouvé<br /><br />'; 
		
		else {

			while ($row = $result->fetch_assoc()) { ?>
				<div>
			    	<h2><?php echo htmlspecialchars($row['title']); ?></h2>
			    	<p><em>Posted on: <?php echo $row['post_date'];?></em></p>
			    	<p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
			    </div>
			<?php
			}
		} ?>

		<hr />

		<h2>Add New Post</h2>
		<form action="blog.php" method="POST">
		    <label for="title">Title:</label><br>
		    <input type="text" id="title" name="title" required><br>
		    <label for="content">Content:</label><br>
		    <textarea id="content" name="content" rows="4" required></textarea><br>
		    <input type="submit" value="Submit">
		</form>

	</body>
</html>