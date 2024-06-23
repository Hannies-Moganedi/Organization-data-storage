<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="includes/facility.php" method="post">
        <h2>Facilities</h2>
        <p>Insert Facilities records</p>
        <?php
        if (isset($_GET['record'])) {
                if ($_GET['record'] == "success") {
                    echo '<p style="color: green">New Record added!</p>';
                }
            }
        ?>
        <input type="text" name="name" placeholder="Name" required></input><br>
        <input type="text" name="location" placeholder="Location" required></input><br>
        <input type="text" name="capacity" placeholder="Capacity" required></input><br>
        <input type="text" name="availability" placeholder="Availability" required></input><br>
        <button name="submit">Submit</button><br><br>
        <a href="index.php">Teachers</a>
        <a href="classes.php">Classes</a>
        <a href="grades.php">Grades</a>
        <a href="learners.php">Learners</a>
        <a href="font/facility.php">Data</a>
    </form>

</body>
</html>