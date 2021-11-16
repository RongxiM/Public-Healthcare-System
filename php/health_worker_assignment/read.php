<?php
// Check existence of id parameter before processing further
if (isset($_GET["person_id"]) && !empty(trim($_GET["person_id"])) && isset($_GET["facility_name"]) && !empty(trim($_GET["facility_name"]))) {
    // Include config file
    require_once "../config.php";
    $link = connect();

    // Prepare a select statement
    $sql = "SELECT * FROM healthcare_worker_assignment WHERE person_id = ? AND facility_name=?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "is", $param_id, $param_facility_name);

        // Set parameters
        $param_id = trim($_GET["person_id"]);
        $param_facility_name = trim($_GET["facility_name"]);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                // Retrieve individual field value
                $person_id = $row['person_id'];
                $facility_name = $row["facility_name"];
                $start_date = $row["start_date"];
                $end_date = $row["end_date"];
                $role = $row ["role"];
                $vaccine_name = $row["vaccine_name"];
                $dose = $row["dose_given"];
                $lot = $row['lot'];
            } else {
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($link);
} else {
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Person ID</label>
                        <p><b><?php echo $row["person_id"]; ?></b></p>
                    </div>
                
                    <div class="form-group">
                        <label>Facility Name</label>
                        <p><b><?php echo $row["facility_name"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Start Date</label>
                        <p><b><?php echo $row["start_date"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>End Date</label>
                        <p><b><?php echo $row["end_date"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <p><b><?php echo $row["role"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Vaccine name</label>
                        <p><b><?php echo $row["vaccine_name"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Dose given</label>
                        <p><b><?php echo $row["dose_given"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Lot ID</label>
                        <p><b><?php echo $row["lot"]; ?></b></p>
                    </div>







                    <p><a href="assignment.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>