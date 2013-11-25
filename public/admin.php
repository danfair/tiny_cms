<?php
	require_once("../includes/db_connect_include.php");
	require_once("../includes/functions.php");
	generate_header();

session_start();
//echo $_SESSION["post_success"];
?>

<div name="contentarea" class="row-fluid" style="background-color:white; padding-top:10px;">
<?php
	global $connection;

	generate_recent_posts_sidebar(); // replace with admin sidebar later
?>
<div name="adminpostlisting" class="span8">
	<legend>Administer blog posts</legend>
	<?php
		if (!empty($_SESSION["post_success"]))
		{
			echo "<div class=\"alert alert-success\">";
			echo $_SESSION["post_success"];
			$_SESSION["post_success"] = "";
			echo "</div>";
		}
		else if (!empty($_SESSION["post_error"]))
		{
			echo "<div class=\"alert alert-error\">";
			echo $_SESSION["post_error"];
			$_SESSION["post_error"] = "";
			echo "</div>";
		}

		echo "<table class=\"table table-striped table-bordered\">";
		echo "<thead>";
		echo "<tr><td><strong>Title</td><td><strong>Author</strong></td><td><strong>Date</strong></td><td><strong>Category</strong></td><td><strong>Edit</strong></td><td><strong>Delete</strong></td></tr>";
		echo "</thead><tbody>";
		$result = find_all_post_info();
		while ($row = mysqli_fetch_assoc($result))
		{
			echo "<tr>";
			echo "<td>" . $row["title"] . "</td>";
			echo "<td>" . $row["author"] . "</td>";
			echo "<td>" . $row["date"] . "</td>";
			echo "<td>" . $row["name"] . "</td>";
			echo "<td><a href=\"edit_post.php?post_id=" . $row["post_id"] . "\"> edit </a></td>";
			echo "<td><a href=\"delete_post.php?post_id=" . $row["post_id"] . "\"> delete </a></td>";
		}
		echo "</tbody></table>"
	?>

</div><!-- end of adminpostlisting -->
</div><!-- end of contentarea -->

?>