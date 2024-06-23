<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Class Interface</title>
<style>
    body {
        font-family: Arial, sans-serif;
    }
    .container {
        margin: 20px auto;
        max-width: 800px;
    }

    h1 {
        text-align: center;
    }

    h2 {
        margin-top: 20px;
    }

    form {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"] {
        width: 60%;
        padding: 8px;
        margin-bottom: 10px;
    }

    button {
        padding: 8px 20px;
        background-color: blue;
        color: #fff;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }
    button:hover{
        color: #000;
        background-color: aquamarine;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table, th, td {
        border: 1px solid #ddd;
        padding: 8px;
    }
    th {
        background-color: #f2f2f2;
    }
    tr:hover {
        background-color: #f5f5f5;
    }

    a {
        display: block;
        margin-bottom: 10px;
        color: #007bff;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>
    <div class="container">
        <h1>Class Interface</h1>
        <a href="../classes.php">Back</a>
        
        <h2>Select All Classes</h2>
        <a href="?action=select_all">Select All Classes</a>

        <h2>Search Classes by Teacher</h2>
        <form action="" method="GET">
            <label for="teacher">Teacher Name:</label>
            <input type="text" id="teacher" name="teacher"><br>
            <button type="submit" name="action" value="select_by_teacher">Submit</button>
        </form>

        <h2>Search Class by Code</h2>
        <form action="" method="GET">
            <label for="code">Code:</label>
            <input type="text" id="code" name="code"><br>
            <button type="submit" name="action" value="select_by_code">Submit</button>
        </form>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <h2>Indepth Data Retrieval</h2>
            <label for="sql_query">What are you looking for:</label>
            <?php 
                if (isset($_GET['error'])) {
                    if ($_GET['error'] == "noresults") {
                        echo '<p style="color: red">Error executing query</p>'; 
                    } elseif ($_GET['error'] == "notallowed") {
                        echo '<p style="color: red">Sorry, you are not allowed to delete the database or tables.</p>'; 
                    }
                }
            ?>
            <textarea id="sql_query" name="sql_query" rows="5" cols="50"></textarea><br><br>
            <button type="submit" name="submit">Get Results</button><br><br>    
        </form>

        <?php
        // Database connection
        require '../dbh.inc.php';

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Handle actions
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'select_all':
                    // Query to select all teachers
                    $sql = "SELECT * FROM classes";
                    $result = $conn->query($sql);
                    displayResults($result);
                    break;

                case 'select_by_teacher':
                    // Query to select class by teacher name
                    if (isset($_GET['teacher'])) {
                        $teacher = $_GET['teacher'];
                        $sql = "SELECT * FROM classes WHERE TEACHER = '$teacher'";
                        $result = $conn->query($sql);
                        displayResults($result);
                    }
                    break;

                    case 'select_by_code':
                        // Query to select facility by facility location
                        if (isset($_GET['code'])) {
                            $code = $_GET['code'];
                            $sql = "SELECT * FROM classes WHERE CODE = '$code'";
                            $result = $conn->query($sql);
                            displayResults($result);
                        }
                        break;

                default:
                    echo "<p>Invalid action.</p>";
                    break;
            }
        }
        
        // Function to display query results
        function displayResults($result) {
            if ($result->num_rows > 0) {
                echo "<h2>Results:</h2>";
                echo "<table>";
                echo "<tr><td>CODE</td><td>SUBJECT</td><td>TEACHER</td><td>LOCATION</td><td>TEXTBOOK</td></tr>";
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["CODE"] . "</td><td>" . $row["SUBJECT"] . "</td><td>" . $row["TEACHER"] . "</td><td>" . $row["LOCATION"] . "</td><td>" . $row["TEXTBOOK"]  . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
        }

        $conn->close();

        //run queries
        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve the SQL query from the form
            $sql_query = $_POST['sql_query'];
            if (stripos($sql_query, 'DROP DATABASE') !==false || stripos($sql_query, 'DROP TABLE') !== false) {
                header("Location: classes.php?error=notallowed");
                exit();
            } else {
                // Connect to the database
                require '../dbh.inc.php';

                // Execute the SQL query
                $result = $conn->query($sql_query);

                if ($result) {
                    // Display the result
                    if ($result->num_rows > 0) {
                        echo "<h2>Results:</h2>";
                        echo "<table border='1'>";
                        // Output column headers
                        $fieldinfo = $result->fetch_fields();
                        echo "<tr>";
                        foreach ($fieldinfo as $field) {
                            echo "<th>" . $field->name . "</th>";
                        }
                        echo "</tr>";
                        // Output data rows
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            foreach ($row as $value) {
                                echo "<td>" . $value . "</td>";
                            }
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                    echo "No results found.";
                }
            } else {
                header("Location: ../classes.php?error=noresults");
                exit();
            }

            // Close database connection
            $conn->close();
        }
        }
        ?>

    </div>
</body>
</html>
