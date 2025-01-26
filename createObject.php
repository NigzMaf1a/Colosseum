<?php
header('Content-Type: application/json');

// Include the database connection
require_once 'connection.php';

// Check if the database connection is successful
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Fetch and decode the input data
$input = json_decode(file_get_contents('php://input'), true);

// Validate required inputs
$requiredFields = ['LandlordID', 'RealtorID', 'RealtorName', 'PropertyName', 'Valid', 'PhotoPath'];
foreach ($requiredFields as $field) {
    if (empty($input[$field])) {
        echo json_encode(['error' => "Missing required field: $field"]);
        exit;
    }
}

// Prepare and execute the insert query
try {
    $stmt = $conn->prepare("
        INSERT INTO Property (RealtorID, PropertyName, Valid, PhotoPath, LandlordID) 
        VALUES (?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        throw new Exception('Failed to prepare statement: ' . $conn->error);
    }

    // Bind parameters to the query
    $stmt->bind_param(
        'isssi', // 'i' for integer, 's' for string
        $input['RealtorID'],
        $input['PropertyName'],
        $input['Valid'],
        $input['PhotoPath'],
        $input['LandlordID']
    );

    // Execute the query
    if ($stmt->execute()) {
        // Fetch the newly created property ID
        $propertyID = $stmt->insert_id;

        // Respond with success
        echo json_encode([
            'PropertyID' => $propertyID,
            'RealtorID' => $input['RealtorID'],
            'RealtorName' => $input['RealtorName'],
            'PropertyName' => $input['PropertyName'],
            'Valid' => $input['Valid'],
            'PhotoPath' => $input['PhotoPath'],
        ]);
    } else {
        echo json_encode(['error' => 'Failed to insert property into the database: ' . $stmt->error]);
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

// Close the database connection
$conn->close();
?>
