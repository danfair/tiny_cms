<?php

function redirect_to($new_location) 
{
    header("Location: " . $new_location);
    exit;
}

function generate_header() 
{
	global $connection;
	$title = "";

	if (empty($_GET["category"]) || $_GET["category"] == 0)
	{
		$title = "WorkSpace | A place for testing, demos, and learning";
	}
	else 
	{
		$result = find_category_info($_GET["category"]);
		$row = mysqli_fetch_assoc($result);
		$title = "WorkSpace | " . $row["name"] . " posts";
	}

	echo "<html><head>
	<meta charset=\"utf-8\">
	<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
	<title>{$title}</title>
	<link rel=\"stylesheet\" type=\"text/css\" href=\"css/bootstrap.css\" />
	<link rel=\"stylesheet\" type=\"text/css\" href=\"css/bootstrap-responsive.css\" />
	</head><body style=\"background-color: gray\">";
	echo "<div name=\"wrapper\" class=\"container-fluid\">";
	echo "<div class=\"row-fluid\">";
	echo "<img src=\"images/main_graphic.jpg\" class=\"span12\"/>";
	echo "</div><!--end of header image -->";
	echo "<div class=\"row-fluid\">";
	echo "<nav class=\"navbar navbar-inverse span12\" role=\"navigation\">";
	echo "<div class=\"navbar-inner\">";
	echo "<a class=\"brand\" href=\"index.html\">WorkSpace</a>";
	echo "<ul class=\"nav\">";
	$query = "SELECT * ";
	$query .= "FROM menu_items ";
	$query .= "ORDER BY position ASC";
	$menu_set = mysqli_query($connection, $query);
	while ($item = mysqli_fetch_assoc($menu_set))
	{ 
		echo "<li ";
		if ($item["name"] == "Home")
		{ echo "class=\"active\"";};
		echo ">";
		echo "<a href='" . $item["link"] . "'>"; 
		echo $item["name"] . "</a></li>";
	}
	echo "</ul></div></nav>";
}

function generate_footer() 
{
	global $connection;

	echo "</div> <!--end of wrapper -->";
	echo "<div class=\"row-fluid\">";
	echo "<nav class=\"navbar navbar-inverse span12\" role=\"navigation\">";
	echo "<div class=\"navbar-inner\">";
	echo "<a class=\"brand\" href=\"index.html\">WorkSpace</a>";
	echo "<ul class=\"nav\">";
	$query = "SELECT * ";
	$query .= "FROM menu_items ";
	$query .= "ORDER BY position ASC";
	$menu_set = mysqli_query($connection, $query);
	while ($item = mysqli_fetch_assoc($menu_set))
	{ 
		echo "<li ";
		if ($item["name"] == "Home")
		{ echo "class=\"active\"";};
		echo ">";
		echo "<a href='" . $item["link"] . "'>"; 
		echo $item["name"] . "</a></li>";
	}
	echo "</ul></div></nav>";
	echo "</body></html>";
}

function generate_sidebar() 
{

	global $connection;

	echo "<div class='span3 pull-left well' style='margin-left: 10px;'>";
	echo "<ul class='nav nav-list'>";
	echo "<h3>Post Categories</h3>";
	
	$query = "SELECT * ";
	$query .= "FROM categories ";
	$query .= "ORDER BY position ASC";
	$category_set = mysqli_query($connection, $query);
	while ($row = mysqli_fetch_assoc($category_set))
	{ 
		echo "<li ";
		if ($row["name"] == "Home")
		{ echo "class=\"active\"";};
		echo ">";
		echo "<a href='index.php?category=" . $row["category_id"] . "'>"; 
		echo $row["name"] . "</a></li>";
	}

	echo "</ul></div>"; // end of span3 pull left div
}

// creates an unfiltered post listing on page
function find_all_post_info() 
{
	global $connection;

	$query = "SELECT * ";
	$query .= "FROM posts ";
	$query .= "LEFT JOIN categories ";
	$query .= "ON (posts.category_id = categories.category_id) ";
	$query .= "ORDER BY date DESC";
	$result = mysqli_query($connection, $query);
	return $result;
}

function find_specific_post_info($post_id)
{
	global $connection;

	$query = "SELECT * ";
	$query .= "FROM posts ";
	$query .= "LEFT JOIN categories ";
	$query .= "ON (posts.category_id = categories.category_id) ";
	$query .= "WHERE post_id = {$post_id} ";
	$query .= "LIMIT 1";
	$result = mysqli_query($connection, $query);
	return $result;
}

// creates a filtered post listing on front page
function find_category_post_info($category) 
{
	global $connection;

	$query = "SELECT * ";
	$query .= "FROM posts ";
	$query .= "LEFT JOIN categories ";
	$query .= "ON (posts.category_id = categories.category_id) ";
	$query .= "WHERE posts.category_id = {$category} ";
	$query .= "ORDER BY date DESC";
	$result = mysqli_query($connection, $query);
	return $result;
}

function generate_post_listing($category = 0) {
	
	if ($category == 0) 
	{
		$result = find_all_post_info();
	}
	else 
	{
		$result = find_category_post_info($category);
	}
	
	while ($row = mysqli_fetch_assoc($result))
	{ 
		echo "<h4>" . $row["title"] . "</h4>";
		echo "<p><strong>By " . $row["author"] . "</strong> | " . $row["date"] . "</p>"; 
		echo "<p>" . $row["body"] . "&nbsp;&nbsp;<a href=\"index.php?category=" . $row["category_id"] . "\"><span class=\"label\">" . $row["name"] . "</span></a></p>"; 
		echo "<a href=\"post.php?post_id=" . $row["post_id"] . "\"><button class=\"btn btn-mini btn-primary\" type=\"button\" style=\"margin-bottom: 15px;\">See this post</button></a>";
	}
}

function find_category_info($category)
{

	global $connection;

	$query = "SELECT * ";
	$query .= "FROM categories ";
	$query .= "WHERE category_id = {$category} ";
	$query .= "LIMIT 1";
	$result = mysqli_query($connection, $query);
	return $result;
}

function generate_recent_posts_sidebar() 
{
	
	global $connection;

	echo "<div class='span3 pull-left well' style='margin-left: 10px;'>";
	echo "<ul class='nav nav-list'>";
	echo "<h4>Recent Posts</h4>";
	
	$query = "SELECT * ";
	$query .= "FROM posts ";
	$query .= "ORDER BY date DESC";
	$post_set = mysqli_query($connection, $query);
	$counter = 0;
	while ($row = mysqli_fetch_assoc($post_set))
	{ 
		echo "<li>";
		echo "<a href=\"post.php?post=" . $row["post_id"] . "\">"; 
		echo $row["title"] . "</a>";
		echo "By " . $row["author"] . "<br />";
		echo $row["date"] . "</li><br />";
		$counter++;
		if ($counter > 4) 
		{
			break;
		}
	}
	echo "</ul></div>"; // end of recent posts sidebar
}

function generate_category_select_list ($category = "Java") 
{
	global $connection;

	$query = "SELECT * ";
	$query .= "FROM categories ";
	$result = mysqli_query($connection, $query);
	while ($row = mysqli_fetch_assoc($result))
	{
		echo "<option";
		if ($category == $row["name"]) 
			{ 
				echo " selected"; 
			}
		echo ">";
		echo $row["name"];
		echo "</option>";
	}
}

function generate_author_select_list ($author = "Togi Mullany") 
{
	global $connection;

	$query = "SELECT DISTINCT author ";
	$query .= "FROM posts ";
	$result = mysqli_query($connection, $query);
	while ($row = mysqli_fetch_assoc($result))
	{
		echo "<option";
		if ($author == $row["author"]) 
		{ 
			echo " selected"; 
		}
		echo ">";
		echo $row["author"];
		echo "</option>";
	}
}

function get_category_id_with_category_name ($category_name)
{
	global $connection;

	$query = "SELECT * FROM categories ";
	$query .= "WHERE name = '{$category_name}' ";
	$query .= "LIMIT 1";
	$result = mysqli_query($connection, $query);
	$row = mysqli_fetch_assoc($result);
	return $row["category_id"];
}
?>