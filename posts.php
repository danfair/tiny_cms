<?php
require_once("../includes/db_connect_include.php");
require_once("../includes/functions.php");
	
	generate_header();
	echo "<div name=\"contentarea\" class=\"row-fluid\" style=\"background-color:white; padding-top:10px;\">";
	generate_sidebar();
	echo "<div class=\"span8 media\">";
	generate_post_listing();
	echo "</div>"; // end of post listing div
	echo "</div>"; // end of content area div
	generate_footer();

?>