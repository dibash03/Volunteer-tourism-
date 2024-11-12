<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $birth_date = $_POST['birth_date'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $region = $_POST['region'];
    $postal_code = $_POST['postal_code'];
    $program = $_POST['program'];
    $time_from = $_POST['time_from'];
    $time_to = $_POST['time_to'];

    // Validate form data (basic example)
    if (empty($full_name) || empty($email) || empty($phone) || empty($birth_date) || empty($country) ||
        empty($city) || empty($region) || empty($postal_code) || empty($program) || empty($time_from) || empty($time_to)) {
        echo "Please fill in all required fields.";
    } else {
        // Connect to the database
        $conn = new mysqli('localhost', 'root', '', 'volunteer_booking');

        // Check connection
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO bookings (full_name, email, phone, birth_date, country, city, region, postal_code, program, time_from, time_to) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }
        $stmt->bind_param("sssssssssss", $full_name, $email, $phone, $birth_date, $country, $city, $region, $postal_code, $program, $time_from, $time_to);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Booking successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close connections
        $stmt->close();
        $conn->close();
    }
} else {
    echo "Invalid request method.";
}
?>
