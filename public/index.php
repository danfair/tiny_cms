<?php 
	require_once("../includes/db_connect_include.php");
	require_once("../includes/functions.php");
	generate_header();
?>
<div name="contentarea" class="row-fluid" style="background-color:white; padding:10px 0;">
<?php
	generate_sidebar();
?>
	<div class="span8 media">
<?php
	$category = 0;
	if (!empty($_GET["category"]))
	{
		$category = $_GET["category"];
	}
	generate_post_listing($category);
?>
</div> <!--end of post listing div -->
</div> <!-- end of content area div -->
<?php
	generate_footer();
?>
