<?php
// Start session for CSRF protection
session_start();

// Check if no GET variable "action"
if (empty($_GET["action"])) {
    // Print Error
    echo "Invalid Action!";

    // Terminate Script
    die;
}

// Import Database Connection, $pdo variable will be from this file
require_once "../dbconnect.php";

// Import Data Object
require_once "../data_object/MailingList.php";

// Create New Data Object
$do = new MailingList();

// Set a boolean flag if the process is successful or not
$processStatus = false;

// Verify CSRF token for all actions
if (!isset($_SESSION['csrf_token']) || 
    !isset($_REQUEST['csrf_token']) || 
    $_REQUEST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo "CSRF token validation failed";
    die;
}

// Call the function based on "action" value
switch ($_GET['action']) {
    case 'create':
        $processStatus = $do->insert($pdo);
        break;
    case 'update':
        $processStatus = $do->update($pdo);
        break;
    case 'delete':
        $processStatus = $do->delete($pdo);
        break;
    default:
        // If none of the above, print error and terminate script
        echo "Invalid Action!";
        die;
}

// Redirect with status message
if ($processStatus) {
    header('Location: ../page/mailing_list.php?process_status=success');
} else {
    header('Location: ../page/mailing_list.php?process_status=failed');
}
exit();
?>