<?php
	require_once("../includes/db_connect_include.php");
	require_once("../includes/functions.php");
	session_start();
	generate_header();

?>
<div name="contentarea" class="row-fluid" style="background-color:white; padding-top:10px;">
<?php
	generate_recent_posts_sidebar();  // replace with admin sidebar later
?>
<div name="postform" class="span7">
	<legend>Add a blog post</legend>
	<?php
		if (!empty($_SESSION["post_error"]))
		{
				echo "<div class=\"alert alert-error\">";
				echo $_SESSION["post_error"];
				$_SESSION["post_error"] = "";
				echo "</div>";
		}
	?>
	<form action="process_post.php" method="post">
		<fieldset>
		<label for="title">Title of Post: </label>
			<input type="text" name="title" class="input-xxlarge" style="height:30px;" value="<?php if (!empty($_SESSION["title"])) {echo $_SESSION["title"];} $_SESSION["title"] = ""; ?>" /><br />
		<label for="category">Category: </label>
		<select name="category">
			<?php
				generate_category_select_list($category_name);
			?>
		</select><br />
		<label for="author">Author: </label>
		<select name="author">
			<?php
				generate_author_select_list();
			?>
		</select><br />
		<label for="postcontent">Post content: </label>
			<textarea name="postcontent" rows="20" style="width: 85%;"><?php if (!empty($_SESSION["post_content"])) {echo $_SESSION["post_content"];} $_SESSION["post_content"] = ""; ?>
			</textarea><br />
		<input type="submit" class="btn btn-primary btn-large" name="submit" value="Submit" />
		</fieldset>
	</form>