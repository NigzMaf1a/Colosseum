<?php
// Include the database connection
include '../resources/scriptz/connection.php';

// Set the response type to JSON
header('Content-Type: application/json');

try {
    // Get the raw POST data
    $input = json_decode(file_get_contents('php://input'), true);

    // Validate the input
    if (!isset($input['RegID']) || empty($input['RegID'])) {
        echo json_encode(['success' => false, 'error' => 'Invalid or missing RegID']);
        exit;
    }

    $regId = $conn->real_escape_string($input['RegID']);

    // Update the account status to 'Approved'
    $updateQuery = "UPDATE Registration SET accStatus = 'Approved' WHERE RegID = '$regId'";

    if ($conn->query($updateQuery) === TRUE) {
        // Success response
        echo json_encode(['success' => true]);
    } else {
        // Error response
        echo json_encode(['success' => false, 'error' => 'Failed to update the account status']);
    }
} catch (Exception $e) {
    // Exception handling
    echo json_encode(['success' => false, 'error' => 'An error occurred: ' . $e->getMessage()]);
}

// Close the database connection
$conn->close();
?>
