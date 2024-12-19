<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header('Location: login.php');
    exit();
}

include('config.php'); // Include database connection

// Handle adding a new course
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $course_name = $_POST['course_name'];
    $add_course_sql = "INSERT INTO courses (name) VALUES (?)";
    $stmt = $conn->prepare($add_course_sql);
    $stmt->bind_param("s", $course_name);
    $stmt->execute();
}

// Handle editing a course
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $course_id = $_POST['course_id'];
    $course_name = $_POST['course_name'];
    $update_sql = "UPDATE courses SET name = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $course_name, $course_id);
    $stmt->execute();
}

// Handle deleting a course
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $course_id = $_GET['id'];
    $delete_sql = "DELETE FROM courses WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    header('Location: manage_courses.php');
    exit();
}

// Fetch all courses
$sql = "SELECT * FROM courses";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
</head>
<body>
    <h1>Manage Courses</h1>

    <!-- Add New Course -->
    <h2>Add Course</h2>
    <form method="POST">
        <input type="hidden" name="action" value="add">
        <input type="text" name="course_name" placeholder="Enter Course Name" required>
        <button type="submit">Add Course</button>
    </form>

    <!-- List of Courses -->
    <h2>Courses</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="course_id" value="<?php echo $row['id']; ?>">
                        <input type="text" name="course_name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                        <button type="submit">Edit</button>
                    </form>
                    <a href="manage_courses.php?action=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this course?');">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
