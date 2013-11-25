<?php
	require_once("../includes/db_connect_include.php");
	require_once("../includes/functions.php");
	session_start();

	// get post info
	global $connection;
	$post_error = "";

	if (isset($_POST['submit']))
	{
		if (!empty($_POST["title"]))
		{
			$title = mysqli_real_escape_string($connection, $_POST["title"]);
			$_SESSION["title"] = $_POST["title"];
		}
		else 
		{
			$post_error .= "You must include a title.<br />";
		}
		$trimmed_content = trim($_POST["postcontent"]); // will always exist by default
		if (!empty($trimmed_content))
		{
			$post_content = $_POST["postcontent"];
			$_SESSION["post_content"] = $post_content;
		}
		else 
		{
			$post_error .= "You must include post content.<br />";
		}
		// no way to not select one, no need for error message for these
		$category = $_POST["category"];
		$author = $_POST["author"];

		if (!empty($post_error))
		{
			$_SESSION["post_error"] = $post_error;
			redirect_to("add_post.php");
		}
		else
		{
			$category_id = get_category_id_with_category_name($category);
			$query = "INSERT INTO posts ";
			$query .= "(title, body, date, author, category_id) ";
			$query .= "VALUES ( ";
			$query .= "'{$title}', '{$post_content}', CURDATE(), '{$author}', $category_id )";
			$result = mysqli_query($connection, $query);
			if (!$result)
			{
				$_SESSION["post_error"] = "There was a database problem. Sorry.";
				redirect_to("add_post.php");
			}
			else
			{
				$_SESSION["post_success"] = "Your post has been added!";
				$_SESSION["post_error"] = "";
				$_SESSION["post_content"] = "";
				$_SESSION["title"] = "";
				redirect_to("admin.php");
			}
		}
	}

?>