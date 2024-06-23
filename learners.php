<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="includes/learners.php" method="post">
        <h2>Learners</h2>
        <p>Insert Learners records</p>
        <?php
        if (isset($_GET['record'])) {
                if ($_GET['record'] == "success") {
                    echo '<p style="color: green">New Record added!</p>';
                }
            }
        ?>
        <input type="text" name="idno" placeholder="ID Number" required></input><br>
        <input type="text" name="name" placeholder="Names" required></input><br>
        <input type="text" name="surname" placeholder="Surname" required></input><br>
        <input type="date" name="DOB" placeholder="Date of Birth" required></input><br>
        <input type="text" name="gender" placeholder="Gender" required></input><br>
        <input type="text" name="grade" placeholder="Grade" required></input><br>
        <input type="text" name="gurdian" placeholder="Gurdian Name" required></input><br>
        <input type="text" name="rship" placeholder="Relationship" required></input><br>
        <input type="text" name="phone" placeholder="Gurdian Contact" required></input><br>
        <input type="text" name="language" placeholder="Home Language" required></input><br>
        <button name="submit">Submit</button><br><br>
        <a href="index.php">Teachers</a>
        <a href="classes.php">Classes</a>
        <a href="grades.php">Grades</a>
        <a href="facilities.php">Facilities</a>
        <a href="front/learners.php">Data</a>
    </form>

</body>
</html>