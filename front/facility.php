<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facility Interface</title>
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
    <a href="../facilities.php">Back</a>
        <h1>Facility Interface</h1>
        
        <h2>Select All Facilities</h2>
        <a href="?action=select_all">Select All Facilities</a>

        <h2>Search Facility by Name</h2>
        <form action="" method="GET">
            <label for="facility_name">Facility Name:</label>
            <input type="text" id="facility_name" name="facility_name"><br>
            <button type="submit" name="action" value="select_by_facility_name">Submit</button>
        </form>

        <h2>Search Facility by Location</h2>
        <form action="" method="GET">
            <label for="facility_location">Facility Location:</label>
            <input type="text" id="facility_location" name="facility_location"><br>
            <button type="submit" name="action" value="select_by_facility_location">Submit</button>
        </form>

        <h2>Check Facility Availability</h2>
        <form action="" method="GET">
            <label for="availability">Availability:</label>
            <input type="text" id="availability" name="availability"><br>
            <button type="submit" name="action" value="select_by_availability">Submit</button>
        </form>

        <h2>Update Facility Availability</h2>
        <form action="" method="POST">
            <label for="facility_name_update">Facility Name:</label>
            <input type="text" id="facility_name_update" name="facility_name_update" required><br>
            <label for="availability_update">New Availability:</label>
            <input type="text" id="availability_update" name="availability_update" required><br>
            <button type="submit" name="action" value="update_availability">Update Availability</button>
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
                    // Query to select all facility
                    $sql = "SELECT * FROM facility";
                    $result = $conn->query($sql);
                    displayResults($result);
                    break;

                case 'select_by_facility_name':
                    // Query to select facility by facility name
                    if (isset($_GET['facility_name'])) {
                        $facility_name = $_GET['facility_name'];
                        $sql = "SELECT * FROM facility WHERE NAME = '$facility_name'";
                        $result = $conn->query($sql);
                        displayResults($result);
                    }
                    break;

                    case 'select_by_facility_location':
                        // Query to select facility by facility location
                        if (isset($_GET['facility_location'])) {
                            $facility_location = $_GET['facility_location'];
                            $sql = "SELECT * FROM facility WHERE LOCATION = '$facility_location'";
                            $result = $conn->query($sql);
                            displayResults($result);
                        }
                        break;

                case 'select_by_availability':
                    // Query to select availability status
                    if (isset($_GET['availability'])) {
                        $availability = $_GET['availability'];
                        $sql = "SELECT * FROM facility WHERE AVAILABILITY = '$availability'";
                        $result = $conn->query($sql);
                        displayResults($result);
                    }
                    break;

                default:
                    echo "<p>Invalid action.</p>";
                    break;
            }
        }

        // Updating availability
        if (isset($_POST['action']) && $_POST['action'] == 'update_availability') {
            // Check if form inputs are set
            if (isset($_POST['facility_name_update'], $_POST['availability_update'])) {
                // Sanitize inputs to prevent SQL injection
                $facility_name_update = $conn->real_escape_string($_POST['facility_name_update']);
                $availability_update = $conn->real_escape_string($_POST['availability_update']);
        
                // Check if facility exists
                $check_facility_sql = "SELECT * FROM facility WHERE NAME = '$facility_name_update'";
                $check_facility_result = $conn->query($check_facility_sql);
                
                if ($check_facility_result->num_rows > 0) {
                    // Check if availability is valid
                    if ($availability_update === "yes" || $availability_update === "Yes" || $availability_update === "no" || $availability_update === "No") {
                        // Update availability in the database
                        $sql = "UPDATE facility SET AVAILABILITY = '$availability_update' WHERE NAME = '$facility_name_update'";
                        if ($conn->query($sql) === TRUE) {
                            echo "<p>Availability updated successfully.</p>";
                        } else {
                            echo "<p>Error updating availability: " . $conn->error . "</p>";
                        }
                    } else {
                        echo "<p>Error: New availability must be either 'yes' or 'no'.</p>";
                    }
                } else {
                    echo "<p>Error: Facility with the given name does not exist.</p>";
                }
            } else {
                echo "<p>Please fill in all fields.</p>";
            }
        }
        
        // Function to display query results
        function displayResults($result) {
            if ($result->num_rows > 0) {
                echo "<h2>Results:</h2>";
                echo "<table>";
                echo "<tr><td>NAME</td><td>LOCATION</td><td>CAPACITY</td><td>AVAILABILITY</td></tr>";
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["NAME"] . "</td><td>" . $row["LOCATION"] . "</td><td>" . $row["CAPACITY"] . "</td><td>" . $row["AVAILABILITY"] . "</td></tr>";
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
                header("Location: facility.php?error=notallowed");
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
                header("Location: facility.php?error=noresults");
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
