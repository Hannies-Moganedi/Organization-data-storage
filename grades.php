<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Input</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="includes/grades.php" method="post">
        <h2>Grades</h2>
        <p>Insert Grades records</p>
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "invalidgrade") {
                 echo '<p style="color: red; text-align: center; margin-bottom: 10px">Grade must be between 8 and 12!</p>';
            }
        }
        if (isset($_GET['record'])) {
                if ($_GET['record'] == "success") {
                    echo '<p style="color: green">New Record added!</p>';
                }
            }
        ?>
        <input type="text" name="grade" placeholder="Grade" required></input><br>
        <input type="text" name="teacher" placeholder="Teacher" required></input><br>
        <input type="text" name="subject" placeholder="Subjects" required></input><br>
        <button name="submit">Submit</button><br><br>
        <a href="index.php">Teachers</a>
        <a href="classes.php">Classes</a>
        <a href="learners.php">learners</a>
        <a href="facilities.php">Facilities</a>
        <a href="front/grades.php">Data</a>
    </form>

</body>
</html>