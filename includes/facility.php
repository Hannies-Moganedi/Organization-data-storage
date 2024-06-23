<?php
//Classes form

//function to sanitize data
function sanitizeInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitizeInput($_POST['name']);
    $location = sanitizeInput($_POST['location']);
    $capacity = sanitizeInput($_POST['capacity']);
    $avai = sanitizeInput($_POST['availability']);
    // Validate form data
    if (empty($name) || empty($location) || empty($capacity) || empty($avai)) {
        echo "All fields are required";
    } else {
        require '../dbh.inc.php';

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO facility (NAME, LOCATION, CAPACITY, AVAILABILITY) VALUES ('$name', '$location', '$capacity', '$avai')";
            
        if ($conn->query($sql) === TRUE) {
            header("Location: ../facilities.php?record=success");
            exit();
        } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            //Close database connection
            $conn->close(); 
    }
}
?>