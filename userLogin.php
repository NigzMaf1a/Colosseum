<?php
// Start the session to manage user login status
session_start();

// Include the database connection
include_once 'connection.php';  // Include connection.php to establish database connection

// Get the POST data from the JavaScript fetch request
$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'];
$password = $data['password'];

// Query to check if the email exists and fetch associated data
$sql = "SELECT id, name1, regType, accStatus FROM Registration WHERE email = ? AND password = ? LIMIT 1";

// Prepare the SQL statement to avoid SQL injection
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists and fetch the details
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // Check if the account is approved
    if ($user['accStatus'] == "Approved") {
        // Set session variables for the logged-in user
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $email;
        $_SESSION['regType'] = $user['regType'];
        
        // Send success response with user data
        echo json_encode([
            'status' => 'success',
            'accStatus' => 'Approved',
            'regType' => $user['regType'],
            'userData' => $user
        ]);
    } else {
        // Account not approved
        echo json_encode([
            'status' => 'error',
            'error' => 'Your account is not approved yet.'
        ]);
    }
} else {
    // Invalid credentials
    echo json_encode([
        'status' => 'error',
        'error' => 'Invalid email or password.'
    ]);
}

// Close the prepared statement and connection
$stmt->close();
$conn->close();
?>
