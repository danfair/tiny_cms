<?php
	require_once("../includes/db_connect_include.php");
	require_once("../includes/functions.php");
	session_start();
	
	if (isset($_GET["post_id"]))
	{
		$post_id = $_GET["post_id"];
		$result = find_specific_post_info($post_id);
		$row = mysqli_fetch_assoc($result); // only one
		$title = $row["title"];
		$post_content = $row["body"];
		$author = $row["author"];
		$date = $row["date"];
		$category_name = $row["name"];
	}
	else
	{
		$_SESSION["post_error"] = "Sorry, there was an error. Please try to edit your post again.";
		redirect_to("admin.php");
	}
	generate_header();
?>
<div name="contentarea" class="row-fluid" style="background-color:white; padding-top:10px;">
<?php
	generate_recent_posts_sidebar();  // replace with admin sidebar later
?>
<div name="editpostform" class="span7">
	<legend>Edit blog post: <?php echo $title; ?></legend>
	<?php
		if (!empty($_SESSION["edit_post_error"]))
		{
				echo "<div class=\"alert alert-error\">";
				echo $_SESSION["edit_post_error"];
				$_SESSION["edit_post_error"] = "";
				echo "</div>";
		}
	?>
	<form action="process_post_edit.php?post_id=<?php echo $post_id; ?>" method="post">
		<fieldset>
		<label for="title">Title of Post: </label>
			<input type="text" name="title" class="input-xxlarge" style="height:30px;" value="<?php echo $title; ?>" /><br />
		<label for="category">Category: </label>
		<select name="category">
			<?php
				generate_category_select_list($category_name);
			?>
		</select><br />
		<label for="author">Author: </label>
		<select name="author">
			<?php
				generate_author_select_list($author);
			?>
		</select><br />
		<label for="postcontent">Post content: </label>
			<textarea name="postcontent" rows="20" style="width: 85%;"><?php echo $post_content; ?>
			</textarea><br />
		<input type="submit" class="btn btn-primary btn-large" name="submit" value="Submit" />
		</fieldset>
	</form>