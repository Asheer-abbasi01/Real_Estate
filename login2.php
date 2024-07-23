<?php
$servername = "localhost";
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "demo"; // your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Hash the password before storing it in the database
$admin_username = 'admin';
$admin_password = password_hash('password123', PASSWORD_DEFAULT);
$sql = "INSERT INTO admin_login (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $admin_username, $admin_password);

if ($stmt->execute()) {
    echo "Admin user created successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>
