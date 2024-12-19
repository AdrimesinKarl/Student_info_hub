<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header('Location: login.php');
    exit();
}

include('config.php'); // Include the database connection

// Check if the student ID is provided
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Delete the student record from the database
    $sql = "DELETE FROM users WHERE id = ? AND user_type = 'student'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);

    if ($stmt->execute()) {
        header('Location: manage_students.php?success=deleted'); // Redirect to the manage students page
        exit();
    } else {
        echo "Error deleting student."; // Display an error message if the deletion fails
    }
} else {
    echo "Invalid student ID."; // Display an error message if no student ID is provided
}
?>
