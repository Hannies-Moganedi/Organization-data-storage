<?php
//function to sanitize data
function sanitizeInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = sanitizeInput($_POST['code']);
    $subject = sanitizeInput($_POST['subject']);
    $teacher = sanitizeInput($_POST['teacher']);
    $location = sanitizeInput($_POST['location']);
    $textbook = sanitizeInput($_POST['textbook']);
    // Validate form data
    if (empty($code) || empty($subject) || empty($teacher) || empty($location) || empty($textbook)) {
        echo "All fields are required";
    } else {
        require '../dbh.inc.php';

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO classes (CODE, SUBJECT, TEACHER, LOCATION, TEXTBOOK) VALUES ('$code', '$subject', '$teacher', '$location', '$textbook')";
            
        if ($conn->query($sql) === TRUE) {
            header("Location: ../classes.php?record=success");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        //Close database connection
        $conn->close(); 
    }
}
?>
