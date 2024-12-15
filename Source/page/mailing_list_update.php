<?php
// Require Database Connection
require_once "../dbconnect.php";

// Include Data Object
require_once "../data_object/MailingList.php";

// Create New Data Object
$do = new MailingList();

// Get Entry
$existingData = $do->selectOne($pdo, $_GET['id']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Update Mailing List</title>

	<style>
		.container {
			border: 1px solid black;
			padding: 20px;
			margin-bottom: 10px;
		}
	</style>
</head>

<body>

	<div class="container" style="max-width: 300px;">
		<h3>Update Entry</h3>
		<form method="post" action="../process/mailing_list.php?action=update">

			<input type="hidden" name="id" value="<?php echo $existingData['id']; ?>" />

			<div style="margin-bottom: 10px;">
				Name: <input type="text" name="name" value="<?php echo $existingData['person_name']; ?>" />
			</div>
			<div style="margin-bottom: 10px;">
				Email: <input type="text" name="email" value="<?php echo $existingData['person_email']; ?>" />
			</div>
			<div style="margin-bottom: 10px; text-align: right;">
				<button type="submit">Update Entry</button>
			</div>
			<div style="margin-bottom: 10px; text-align: right;">
				<a href="mailing_list.php">Back to List</a>
			</div>
		</form>
	</div>

</body>

</html>