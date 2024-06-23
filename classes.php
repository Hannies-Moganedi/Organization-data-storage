<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Input</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="includes/classes.php" method="post">
        <h2>Classes</h2>
        <p>Insert Classes records</p>
        <?php
        if (isset($_GET['record'])) {
                if ($_GET['record'] == "success") {
                    echo '<p style="color: green">New Record added!</p>';
                }
            }
        ?>
        <input type="text" name="code" placeholder="Code" required></input><br>
        <input type="text" name="subject" placeholder="Subjects" required></input><br>
        <input type="text" name="teacher" placeholder="Teacher" required></input><br>
        <input type="text" name="location" placeholder="Location" required></input><br>
        <input type="text" name="textbook" placeholder="Textbook" required></input><br>
        <button name="submit-class">Submit</button><br><br>
        <a href="index.php">Teachers</a>
        <a href="learners.php">Learners</a>
        <a href="grades.php">Grades</a>
        <a href="facilities.php">Facilities</a>
        <a href="front/classes.php">Data</a>
    </form>

</body>
</html>