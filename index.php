<?php

// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todo";
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Add task
if (isset($_POST['add'])) {
    $task = $_POST['task'];
    $sql = "INSERT INTO tasks (task) VALUES ('$task')";
    mysqli_query($conn, $sql);
    header('location: index.php');
}

// Delete task
if (isset($_GET['del_task'])) {
    $id = $_GET['del_task'];
    $sql = "DELETE FROM tasks WHERE id=$id";
    mysqli_query($conn, $sql);
    header('location: index.php');
}

// Mark task as completed
if (isset($_GET['complete_task'])) {
    $id = $_GET['complete_task'];
    $sql = "UPDATE tasks SET completed=1 WHERE id=$id";
    mysqli_query($conn, $sql);
    header('location: index.php');
}

// Get tasks from database
$sql = "SELECT * FROM tasks";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
	<title>TODO App</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 0;
		}

		h1 {
			margin-top: 50px;
			text-align: center;
		}

		form {
			margin-top: 20px;
			text-align: center;
		}

		input[type="text"] {
			padding: 10px;
			width: 60%;
			border-radius: 5px;
			border: 1px solid #ccc;
		}

		button {
			padding: 10px 20px;
			border-radius: 5px;
			border: none;
			background-color: #4CAF50;
			color: white;
			font-size: 16px;
			cursor: pointer;
		}

		button:hover {
			background-color: #3e8e41;
		}

		ul {
			list-style-type: none;
			margin: 0;
			padding: 0;
		}

		li {
			padding: 10px;
			margin: 5px;
			border-radius: 5px;
			border: 1px solid #ccc;
			background-color: #f2f2f2;
		}

		.completed {
			text-decoration: line-through;
			color: #888;
		}
	</style>
</head>
<body>
	<h1>TODO App</h1>
	<form method="POST" action="index.php">
		<input type="text" name="task" required>
		<button type="submit" name="add">Add Task</button>
	</form>
	<ul>
		<?php while ($row = mysqli_fetch_array($result)) { ?>
			<li <?php if ($row['completed']) echo 'class="completed"' ?>>
				<?php echo $row['task'] ?>
				<a href="index.php?del_task=<?php echo $row['id'] ?>">x</a>
				<?php if (!$row['completed']) { ?>
					<a href="index.php?complete_task=<?php echo $row['id'] ?>">Complete</a>
				<?php } ?>
			</li>
		<?php } ?>
