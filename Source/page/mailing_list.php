<?php
// Require Database Connection
require_once "../dbconnect.php";
// Include Data Object
require_once "../data_object/MailingList.php";

// Start session for CSRF protection
session_start();

// Generate CSRF token if not exists
if (empty($_SESSION['csrf_token'])) {
	$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Create New Data Object
$do = new MailingList();

// Handle potential delete action with CSRF protection
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
	// Verify CSRF token
	if (!isset($_GET['csrf_token']) || $_GET['csrf_token'] !== $_SESSION['csrf_token']) {
		die('CSRF token validation failed');
	}
	
	// Perform delete operation
	$deleteStatus = $do->delete($pdo);
	
	// Redirect back to the mailing list page with a status message
	if ($deleteStatus) {
		header('Location: mailing_list.php?delete_status=success');
		exit();
	} else {
		header('Location: mailing_list.php?delete_status=failed');
		exit();
	}
}

// List Entries
$dataList = $do->select($pdo);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Mailing List Management</title>
	<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
	<style>
		/* Custom styles to enhance Tailwind */
		.table-striped tbody tr:nth-child(even) {
			background-color: #f9fafb;
		}
	</style>
</head>

<body class="bg-gray-100 min-h-screen p-6">
	<div class="container mx-auto max-w-4xl">
		<!-- Show delete status message if exists -->
		<?php 
		if (isset($_GET['delete_status'])) {
			$messageClass = $_GET['delete_status'] === 'success' 
				? 'bg-green-100 border-green-400 text-green-700' 
				: 'bg-red-100 border-red-400 text-red-700';
			$message = $_GET['delete_status'] === 'success' 
				? 'Subscriber deleted successfully.' 
				: 'Failed to delete subscriber.';
			echo "<div class='$messageClass border px-4 py-3 rounded relative mb-4' role='alert'>
					$message
				  </div>";
		}
		?>

		<div class="grid md:grid-cols-2 gap-6">
			<!-- Mailing List Form -->
			<div class="bg-white shadow-md rounded-lg p-6">
				<h3 class="text-xl font-semibold mb-4 text-gray-800">Add New Subscriber</h3>
				<form method="post" action="../process/mailing_list.php?action=create" class="space-y-4"
					id="mailingListForm" novalidate>
					<!-- CSRF Token -->
					<input type="hidden" name="csrf_token"
						value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

					<div>
						<label for="name" class="block text-sm font-medium text-gray-700 mb-1">
							Full Name
						</label>
						<input type="text" id="name" name="name" required minlength="2" maxlength="100"
							class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
							aria-describedby="name-requirements">
						<p id="name-requirements" class="text-xs text-gray-500 mt-1">
							2-100 characters
						</p>
					</div>

					<div>
						<label for="email" class="block text-sm font-medium text-gray-700 mb-1">
							Email Address
						</label>
						<input type="email" id="email" name="email" required
							class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
							aria-describedby="email-requirements">
						<p id="email-requirements" class="text-xs text-gray-500 mt-1">
							Must be a valid email address
						</p>
					</div>

					<div>
						<button type="submit"
							class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
							Add Subscriber
						</button>
					</div>
				</form>
			</div>

			<!-- Mailing List Table -->
			<div class="bg-white shadow-md rounded-lg p-6">
				<h3 class="text-xl font-semibold mb-4 text-gray-800">Current Subscribers</h3>
				<?php if (empty($dataList)): ?>
					<p class="text-gray-600">No subscribers yet.</p>
				<?php else: ?>
					<div class="overflow-x-auto">
						<table class="w-full table-striped border border-gray-200">
							<thead class="bg-gray-50">
								<tr>
									<th
										class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
										ID</th>
									<th
										class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
										Name</th>
									<th
										class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
										Email</th>
									<th
										class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
										Actions</th>
								</tr>
							</thead>
							<tbody class="bg-white divide-y divide-gray-200">
								<?php foreach ($dataList as $row): ?>
									<tr>
										<td class="px-4 py-2 whitespace-nowrap"><?php echo htmlspecialchars($row['id']); ?></td>
										<td class="px-4 py-2"><?php echo htmlspecialchars($row['person_name']); ?></td>
										<td class="px-4 py-2"><?php echo htmlspecialchars($row['person_email']); ?></td>
										<td class="px-4 py-2 text-center">
											<div class="inline-flex space-x-2">
												<a href="mailing_list_update.php?id=<?php echo urlencode($row['id']); ?>&csrf_token=<?php echo urlencode($_SESSION['csrf_token']); ?>"
													class="text-blue-600 hover:text-blue-900 text-sm">
													Update
												</a>
												<a href="mailing_list.php?action=delete&id=<?php echo urlencode($row['id']); ?>&csrf_token=<?php echo urlencode($_SESSION['csrf_token']); ?>"
													class="text-red-600 hover:text-red-900 text-sm"
													onclick="return confirm('Are you sure you want to delete this subscriber?');">
													Delete
												</a>
											</div>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<script>
		// Basic client-side form validation
		document.getElementById('mailingListForm').addEventListener('submit', function (event) {
			const nameInput = document.getElementById('name');
			const emailInput = document.getElementById('email');
			let isValid = true;

			// Name validation
			if (nameInput.value.trim().length < 2) {
				alert('Name must be at least 2 characters long');
				event.preventDefault();
				isValid = false;
			}

			// Email validation
			const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			if (!emailRegex.test(emailInput.value)) {
				alert('Please enter a valid email address');
				event.preventDefault();
				isValid = false;
			}

			return isValid;
		});
	</script>
</body>

</html>