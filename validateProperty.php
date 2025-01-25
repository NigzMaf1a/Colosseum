<?php
// validateProperty.php
require_once '../connection.php'; // Include the database connection file

// Get the PropertyID from the AJAX request
$data = json_decode(file_get_contents('php://input'), true);
$propertyId = $data['PropertyID'] ?? null;

if ($propertyId) {
    // Update the Valid column
    $query = "UPDATE Property SET Valid = 'YES' WHERE PropertyID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $propertyId);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => "Property ID $propertyId has been validated successfully."
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => "Database error: " . $stmt->error
        ]);
    }

    $stmt->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => "Invalid Property ID."
    ]);
}

$conn->close();
?>
