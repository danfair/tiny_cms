<?php
	require_once("../includes/db_connect_include.php");
	require_once("../includes/functions.php");
	generate_header();
?>
<div name="contentarea" class="row-fluid" style="background-color:white; padding-top:10px;">
<?php
	global $connection;

	generate_recent_posts_sidebar();

	// process form starts here
	$contact_error = "";
	$contact_success = "";
	$first_name = "";
	$last_name = "";
	$email_address = "";
	$phone_number = "";
	if (isset($_POST['submit'])) 
	{
		if (!empty($_POST["firstname"]))
		{
			$first_name = $_POST["firstname"];
			$first_name = mysqli_real_escape_string($connection, $first_name);
		}
		else
		{
			$contact_error .= "First name is required. <br />";
		}
		if (!empty($_POST["lastname"]))
		{
			$last_name = $_POST["lastname"];
			$last_name = mysqli_real_escape_string($connection, $last_name);
		}
		else
		{
			$contact_error .= "Last name is required. <br />";
		}
		if (!empty($_POST["emailaddress"]))
		{
			$email_address = $_POST["emailaddress"];
			$email_address = mysqli_real_escape_string($connection, $email_address);
		}
		else 
		{
			$contact_error .= "Email address is required. <br />";
		}
		if (!empty($_POST["phonenumber"]))
		{
			$phone_number = $_POST["phonenumber"];
			$phone_number = mysqli_real_escape_string($connection, $phone_number);
		}
		else
		{
			$phone_number = "XXX-XXX-XXXX";
		}
		// phone number not required

		$query = "INSERT INTO contact_info ";
		$query .= "(first_name, last_name, email_address, phone)";
		$query .= "VALUES ";
		$query .= "('{$first_name}', '{$last_name}', '{$email_address}', '{$phone_number}')";
		if (empty($contact_error))
		{
			$result = mysqli_query($connection, $query);
			if ($result) 
			{
				$contact_success = "Thanks for your info. We'll be in touch soon!";
			}
			else
			{
				$contact_error .= "There was a database error. ";
			}
		}
	}
?>

	<div name ="contactform" class="span7 media">
		<h3>Contact WorkSpace</h3>
		<?php 
			if (!empty($contact_error)) 
			{
				echo "<div class=\"alert alert-error\">";
				echo $contact_error;
				echo "</div>";
			}
			elseif (!empty($contact_success))
			{
				echo "<div class=\"alert alert-success\">";
				echo $contact_success;
				echo "</div>";
			}
		?>
		<p>Thanks for your interest in WorkSpace projects. If you have any questions or comments, please feel free to contact us! Please fill out the information below and we'll be in touch within 48 hours of receiving your information. </p>
		<form action="contact.php" method="post">
			First Name*: <input type="text" name="firstname" value="<?php if (isset($first_name)) { htmlspecialchars($first_name); } ?>" /><br />
			Last Name*: <input type="text" name="lastname" value="<?php if (isset($last_name)) { htmlspecialchars($last_name); } ?>" /><br /><br />
			Email address*: <input type="text" name="emailaddress" value="<?php if (isset($email_address)) { htmlspecialchars($email_address); } ?>" /><br />
			Phone number: <input type="text" name="phonenumber" value="<?php if (isset($phone_number)) { htmlspecialchars($phone_number); } ?>"/><br /><br />
			<p style="color:red;">* Required fields</p>
			<input type="submit" class="btn" name="submit" value="Submit" />
		</form>

	</div> <!--end of contact form div -->
</div> <!-- end of content area div -->
<?php
	generate_footer();
?>