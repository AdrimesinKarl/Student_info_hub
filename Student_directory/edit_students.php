<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header('Location: login.php');
    exit();
}

include('config.php'); // Include the database connection

// Check if a student ID is provided in the URL
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Fetch the student data from the database
    $sql = "SELECT * FROM users WHERE id = ? AND user_type = 'student'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "Student not found.";
        exit();
    }
} else {
    echo "Invalid student ID.";
    exit();
}

// Update logic for editing student (if form is submitted)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $course_id = $_POST['course_id'];

    // Update student data in the database
    $update_sql = "UPDATE users SET first_name = ?, last_name = ?, course_id = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssii", $first_name, $last_name, $course_id, $student_id);
    if ($stmt->execute()) {
        header('Location: manage_students.php?success=updated'); // Redirect back to manage students
        exit();
    } else {
        echo "Error updating student.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
