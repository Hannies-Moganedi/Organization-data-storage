<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Input</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="includes/teachers.php" method="post">
        <h2>Teacher</h2>
        <p>Insert Teachers records</p>
        <?php
            if (isset($_GET['error'])) {
                if ($_GET['error'] == "invalidemail") {
                     echo '<p style="color: red; text-align: center; margin-bottom: 10px">Invalid email!</p>';
                } elseif ($_GET['error'] == "invalidphone") {
                     echo '<p style="color: red">Invalid Phone number</p>';
                } elseif ($_GET['error'] == "Age < 22") {
                    echo '<p style="color: red">Date of birth must be atleast 22</p>';
                } elseif ($_GET['error'] == "duplicateentry") {
                    echo '<p style="color: red">ID number or email, or phone number already exists</p>';
                } elseif ($_GET['error'] == "invalididno") {
                    echo '<p style="color: red">ID number must be an integer!</p>';
                }
            }
            if (isset($_GET['record'])) {
                if ($_GET['record'] == "success") {
                    echo '<p style="color: green">New Record added!</p>';
                }
            }
        ?>
        <input type="text" name="idno" placeholder="ID Number" required></input><br>
        <input type="text" name="surname" placeholder="Surname" required></input><br>
        <input type="text" name="name" placeholder="Names" required></input><br>
        <input type="date" name="DOB" placeholder="Date of Birth" required></input><br>
        <input type="text" name="gender" placeholder="Gender" required></input><br>
        <input type="text" name="phone" placeholder="Phone number" required></input><br>
        <input type="email" name="mail" placeholder="Email-address" required></input><br>
        <input type="text" name="position" placeholder="Position" required></input><br>
        <input type="text" name="salary" placeholder="Salary" required></input><br>
        <input type="text" name="exp" placeholder="Teacher experience" required></input><br>
        <button name="submit">Submit</button><br><br>
        <a href="classes.php">Classes</a>
        <a href="learners.php">Learners</a>
        <a href="grades.php">Grades</a>
        <a href="facilities.php">Facilities</a>
        <a href="front/teachers.php">Data</a><br>
        </form>

</body>
</html>