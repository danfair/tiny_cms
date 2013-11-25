<?php
	require_once("../includes/db_connect_include.php");
	require_once("../includes/functions.php");
	session_start();

	global $connection;
	
	$edit_post_error = "";
	if (isset($_POST["submit"]))
	{
		if (!empty($_POST["title"]))
		{
			$title = mysqli_real_escape_string($connection, $_POST["title"]);
			//$_SESSION["title"] = $_POST["title"];
		}
		else 
		{
			$edit_post_error .= "You must include a title.<br />";
		}
		$trimmed_content = trim($_POST["postcontent"]); // will always exist by default
		if (!empty($trimmed_content))
		{
			$post_content = $_POST["postcontent"];
			//$_SESSION["post_content"] = $post_content;
		}
		else 
		{
			$edit_post_error .= "You must include post content.<br />";
		}
		// no way to not select one, no need for error message for these
		$category_name = $_POST["category"];
		$category_id = get_category_id_with_category_name($category_name);
		$author = $_POST["author"];
		$post_id = $_GET["post_id"];

		if (!empty($edit_post_error))
		{
			$_SESSION["edit_post_error"] = $post_error;
			redirect_to("edit_post.php?post_id=" . $post_id);
		}
		else 
		{
			$query = "UPDATE posts ";
			$query .= "SET title = '{$title}', ";
			$query .= "body = '{$post_content}', ";
			$query .= "category_id = {$category_id}, ";
			$query .= "author = '{$author}' ";
			$query .= "WHERE post_id = {$post_id}";
			$result = mysqli_query($connection, $query);
		}

		if (!$result)
		{
			$_SESSION["edit_post_error"] = "There was a database problem. Sorry.";
			redirect_to("edit_post.php?post_id=" . $post_id);
		}
		else
		{
			$_SESSION["post_success"] = "Your post has been edited!";
			$_SESSION["edit_post_error"] = "";
			//$_SESSION["post_content"] = "";
			//$_SESSION["title"] = "";
			redirect_to("admin.php");
		}
	}

?>