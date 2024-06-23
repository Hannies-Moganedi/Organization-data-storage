<?php
//function to sanitize data
function sanitizeInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idno = sanitizeInput($_POST['idno']);
    $name = sanitizeInput($_POST['name']);
    $surname = sanitizeInput($_POST['surname']);
    $dob = $_POST['DOB'];
    $gender = sanitizeInput($_POST['gender']);
    $grade = sanitizeInput($_POST['grade']);
    $gurdian = sanitizeInput($_POST['gurdian']);
    $rship = sanitizeInput($_POST['rship']);
    $phone = sanitizeInput($_POST['phone']);
    $language = sanitizeInput($_POST['language']);
    
    // Validate form data
    if (empty($idno) || empty($name) || empty($surname) || empty($dob) || empty($gender) || empty($grade)|| empty($gurdian)  || empty($rship) || empty($phone) || empty($language)) {
        echo "All fields are required";
    } elseif (!is_numeric($phone)) {
        header("Location: ../learners.php?error=invalidphone" .$phone);
        exit();
    } else {
        // check if dob is atleast 22 years ago
        $today = new DateTime();
        $birthdate = new DateTime($dob);
        $age = $birthdate->diff($today)->y;

        if ($age < 10) {
            header("Location: ../learners.php?error=Age < 10");
            exit();
        } else {
            require '../dbh.inc.php';

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            //Prepare and execute SQL statement statement to check uniqueness
            $sql_check_unique = "SELECT * FROM learners WHERE ID_NUMBER = ? OR PARENT_CONTACT = ?";
            $stmt = $conn->prepare($sql_check_unique);

            if (!$stmt) {
                die("Error preparing statement: " . $conn->error);
            }
            $stmt->bind_param("ii", $idno, $phone);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                header("Location: ../learners.php?error=duplicateentry");
                exit();
            } else {
                $sql = "INSERT INTO learners (ID_NUMBER, NAMES, SURNAME, DOB, GENDER, GRADE, GURDIAN_NAME, RELATIONSHIP, PARENT_CONTACT, HOME_LANGUAGE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);

                if (!$stmt) {
                    die("Error preparing statement: " . $conn->error);
                }
                $stmt->bind_param("ssssssssis", $idno, $name, $surname, $dob, $gender, $grade, $gurdian, $rship, $phone, $language);
            
                if ($stmt->execute()) {
                    header("Location: ../learners.php?record=success");
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

            //Close database connection
            $stmt->close();
            $conn->close(); 
        }
    }
}
?>

