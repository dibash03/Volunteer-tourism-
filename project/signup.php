<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['firstName'], $_POST['email'], $_POST['password'], $_POST['confirmation']) &&
        !empty($_POST['firstName']) &&
        !empty($_POST['email']) &&
        !empty($_POST['password']) &&
        !empty($_POST['confirmation'])) {

        $firstName = $_POST['firstName'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmation = $_POST['confirmation'];

        if ($password !== $confirmation) {
            die("Passwords do not match.");
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Debugging output
        echo "Hashed Password: " . htmlspecialchars($hashedPassword) . "<br>";

        $conn = new mysqli('localhost', 'root', '', 'test');

        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO project (firstName, email, 'password') VALUES (?, ?, ?)");
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }
        $stmt->bind_param("sss", $firstName, $email, $hashedPassword);

        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Please fill in all required fields.";
    }
} else {
    echo "Invalid request method.";
}
?>