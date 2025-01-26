<?php
header('Content-Type: application/json');

// Include the database connection
require_once 'connection.php';

// Fetch input data
$input = json_decode(file_get_contents('php://input'), true);

// Validate required inputs
$requiredFields = ['PropertyID', 'RealtorID', 'UnitType', 'UnitName', 'PropertyName', 'RealtorName', 'Price', 'propCondition', 'Vacant', 'PhotoPath'];
foreach ($requiredFields as $field) {
    if (empty($input[$field])) {
        echo json_encode(['error' => "Missing required field: $field"]);
        exit;
    }
}

// Prepare and execute the insert query
try {
    $stmt = $conn->prepare("
        INSERT INTO Unit (PropertyID, RealtorID, UnitType, UnitName, PropertyName, RealtorName, Price, propCondition, Vacant, PhotoPath) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        'iissssisss',
        $input['PropertyID'],
        $input['RealtorID'],
        $input['UnitType'],
        $input['UnitName'],
        $input['PropertyName'],
        $input['RealtorName'],
        $input['Price'],
        $input['propCondition'],
        $input['Vacant'],
        $input['PhotoPath']
    );

    if ($stmt->execute()) {
        // Return the newly created Unit's details
        $unitID = $stmt->insert_id;
        echo json_encode([
            'UnitID' => $unitID,
            'PropertyID' => $input['PropertyID'],
            'RealtorID' => $input['RealtorID'],
            'UnitType' => $input['UnitType'],
            'UnitName' => $input['UnitName'],
            'PropertyName' => $input['PropertyName'],
            'RealtorName' => $input['RealtorName'],
            'Price' => $input['Price'],
            'propCondition' => $input['propCondition'],
            'Vacant' => $input['Vacant'],
            'PhotoPath' => $input['PhotoPath'],
        ]);
    } else {
        echo json_encode(['error' => 'Failed to insert unit into the database.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

// Close the connection
$conn->close();
?>
