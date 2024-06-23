<?php
// Function to sanitize data
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $grade = sanitizeInput($_POST['grade']);
    $teacher = sanitizeInput($_POST['teacher']);
    $subject = sanitizeInput($_POST['subject']);

    // Validate form data
    if (empty($grade) || empty($teacher) || empty($subject)) {
        echo "All fields are required";
    } else {
        // Validate grade field to be between 8 and 12
        $grade = intval($grade);
        if ($grade < 8 || $grade > 12) {
            header("Location: ../grades.php?error=invalidgrade");
            exit();
        } else {
            require '../dbh.inc.php';

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "INSERT INTO grades (GRADE, TEACHER, SUBJECTS) VALUES ('$grade', '$teacher', '$subject')";
            
            if ($conn->query($sql) === TRUE) {
                header("Location: ../grades.php?record=success");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            // Close database connection
            $conn->close(); 
        }
    }
}
