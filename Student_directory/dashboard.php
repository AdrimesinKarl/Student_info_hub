<?php
session_start();
include("db.php");

// Check if the user is logged in as admin
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Fetch students from the database
try {
    $sql = "SELECT id, first_name, last_name, course_id FROM users WHERE user_type = 'student'";
    $stmt = $pdo->query($sql);

    // Check if there are any rows returned
    if ($stmt->rowCount() > 0) {
        echo "Query returned results.<br>";
    } else {
        echo "No students found.<br>";
    }
} catch (PDOException $e) {
    die("Error fetching students: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e9f7ef;  /* Light green background */
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            padding: 20px;
            background-color: #28a745;  /* Green header */
            color: #fff;
            margin: 0;
            font-size: 24px;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #28a745;  /* Green header for table */
            color: white;
            font-weight: normal;
        }

        tr:nth-child(even) {
            background-color: #f2f8f1;  /* Light green for even rows */
        }

        tr:hover {
            background-color: #d1e7d7;  /* Slightly darker green on hover */
        }

        a {
            text-decoration: none;
            color: #28a745;  /* Green links */
            padding: 5px 10px;
            border: 1px solid #28a745;
            border-radius: 3px;
            transition: background-color 0.3s, color 0.3s;
        }

        a:hover {
            background-color: #28a745;
            color: white;
        }

        .logout-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #dc3545;  /* Red logout button */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #c82333;  /* Darker red on hover */
        }
    </style>
</head>
<body>
    <h1>Manage Students</h1>

    <div class="container">
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Course</th>
                <th>Actions</th>
            </tr>
            <?php
            // Loop through the result set using fetch()
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Check if the row is valid and contains the expected keys
                if (isset($row['id'], $row['first_name'], $row['last_name'], $row['course_id'])) {
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['course_id']); ?></td>
                    <td>
                        <a href="edit_student.php?id=<?php echo htmlspecialchars($row['id']); ?>">Edit</a> |
                        <a href="delete_student.php?id=<?php echo htmlspecialchars($row['id']); ?>" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                    </td>
                </tr>
            <?php
                } else {
                    echo "<tr><td colspan='4'>Data format is incorrect or missing required fields.</td></tr>";
                }
            }
            ?>
        </table>

        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>
