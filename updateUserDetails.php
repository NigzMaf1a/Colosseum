<?php
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $userID = $input['userID'];
    $updatedData = $input['updatedData'];

    // Prepare the SQL query dynamically
    $setClauses = [];
    $params = [];
    $types = '';

    foreach ($updatedData as $key => $value) {
        if ($value !== null) { // Only update non-null values
            $setClauses[] = "$key = ?";
            $params[] = $value;
            $types .= 's'; // Assuming all fields are strings; adjust for different data types
        }
    }

    // Add the userID condition
    $params[] = $userID;
    $types .= 'i';

    if (!empty($setClauses)) {
        $query = "UPDATE Registration SET " . implode(', ', $setClauses) . " WHERE userID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'User details updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update user details.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => true, 'message' => 'No fields to update.']);
    }

    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
