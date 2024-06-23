<?php
// Function to sanitize data
function sanitizeInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate ID number
    $idno = sanitizeInput($_POST['idno']);
    if (!ctype_digit($idno)) {
        header("Location: ../index.php?error=invalididno");
        exit();
    } 
    $idno = (int)$idno; // Explicitly cast to integer

    // Sanitize other inputs
    $surname = sanitizeInput($_POST['surname']);
    $name = sanitizeInput($_POST['name']);
    $dob = $_POST['DOB'];
    $gender = sanitizeInput($_POST['gender']);
    $phone = sanitizeInput($_POST['phone']);
    $email = sanitizeInput($_POST['mail']);
    $position = sanitizeInput($_POST['position']);
    $salary = sanitizeInput($_POST['salary']);
    $exp = sanitizeInput($_POST['exp']);
    
    // Validate form data
    if (empty($surname) || empty($name) || empty($dob) || empty($gender) || empty($gender) || empty($phone) || empty($email) || empty($position) || empty($salary) || empty($exp)) {
        echo "All fields are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../index.php?error=invalidemail" .$email);
        exit();
    } elseif (!is_numeric($phone)) {
        header("Location: ../index.php?error=invalidphone" .$phone);
        exit();
    } else {
        // Check if dob is at least 22 years ago
        $today = new DateTime();
        $birthdate = new DateTime($dob);
        $age = $birthdate->diff($today)->y;

        $phone1 = "0" .$phone;
        $salary1 = "R " .$salary;
        $expe = $exp . " year(s)";

        if ($age < 22) {
            header("Location: ../index.php?error=Age < 22");
            exit();
        } else {
            require '../dbh.inc.php';

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare and execute SQL statement to check uniqueness
            $sql_check_unique = "SELECT * FROM Teachers WHERE ID_NUMBER = ? OR EMAIL = ? OR PHONE = ?";
            $stmt = $conn->prepare($sql_check_unique);

            if (!$stmt) {
                die("Error preparing statement: " . $conn->error);
            }
            $stmt->bind_param("iss", $idno, $email, $phone);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                header("Location: ../index.php?error=duplicateentry");
                exit();
            } else {
                $sql = "INSERT INTO Teachers (ID_NUMBER, SURNAME, NAMES, DOB, GENDER, PHONE, EMAIL, POSITION, SALARY, T_EXPERIENCE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);

                if (!$stmt) {
                    die("Error preparing statement: " . $conn->error);
                }
                $stmt->bind_param("sssssissss", $idno, $surname, $name, $dob, $gender, $phone1, $email, $position, $salary1, $expe);
            
                if ($stmt->execute()) {
                    header("Location: ../index.php?record=success");
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }

            // Close database connection
            $stmt->close();
            $conn->close(); 
        }
    }
}
