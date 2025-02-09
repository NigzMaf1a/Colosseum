<?php
// Include the connection script
require_once "C:/xampp/htdocs/Coloseum/resources/scriptz/connection.php";

// Set response headers
header("Content-Type: application/json");

try {
    // Get the JSON input from the fetch request
    $inputData = json_decode(file_get_contents("php://input"), true);

    if (!$inputData) {
        throw new Exception("Invalid input data.");
    }

    // Sanitize input data
    $name1 = $conn->real_escape_string($inputData['Name1']);
    $name2 = $conn->real_escape_string($inputData['Name2']);
    $phoneNo = $conn->real_escape_string($inputData['PhoneNo']);
    $email = $conn->real_escape_string($inputData['Email']);
    $natID = $conn->real_escape_string($inputData['NatID']);
    $regType = $conn->real_escape_string($inputData['RegType']);

    // Add other fields as necessary with validation

    // Insert data into Registration table
    $sql = "INSERT INTO Registration (Name1, Name2, PhoneNo, Email, NatID, RegType, RegDate, accStatus) 
            VALUES ('$name1', '$name2', '$phoneNo', '$email', '$natID', '$regType', CURDATE(), 'Pending')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Registration successful.", "RegID" => $conn->insert_id]);
    } else {
        throw new Exception("Error inserting data: " . $conn->error);
    }
} catch (Exception $e) {
    http_response_code(400); // Bad request
    echo json_encode(["error" => $e->getMessage()]);
} finally {
    $conn->close();
}
?>
