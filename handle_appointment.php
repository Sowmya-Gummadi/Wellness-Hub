<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "Satwika@21";
$dbname = "tbp";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve POST data
$doctorId = $_POST['doctor_id'];
$hospitalId = $_POST['hospital_id'];
$appointmentDate = $_POST['appointment_date'];
$timeSlot = $_POST['time_slot'];
$status = 'booked';  // Set status to 'booked'

// Prepare and execute SQL query to insert into appointment table
$sql = "INSERT INTO appointment (doctor_id, hospital_id, appointment_date, time_slot, status) 
        VALUES ('$doctorId', '$hospitalId', '$appointmentDate', '$timeSlot', '$status')";

if ($conn->query($sql) === TRUE) {
    $response = array('success' => true, 'message' => 'Appointment booked successfully.');
} else {
    if ($conn->errno == 1062) {  // Duplicate entry error code
        $response = array('success' => false, 'message' => 'This appointment slot is already booked.');
    } else {
        $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
    }
}
$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
