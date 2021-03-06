<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">

    <title>SCU Bug Tracker</title>
    <?php
        include '../db/backend.php';

        /*
         * If the IT tester is logged in a current session, they will
         * be taken to their own page and be able to view all bugs assigned
		 * to them. There they can update bugs to either the 'fixing' or 'fixed'
		 * state. Only bugs assigned to them specifically will be seen.
         *
         */
		session_start();
		if ($_SESSION['valid']) { // Checks to see if tester is logged in
            $employeeid = $_SESSION['employeeid'];
        	if (isset($_POST['selectStatus']) && isset($_POST['selectBug'])) {
            	$bug_id = read_until_white_space($_POST['selectBug']);
            	$status = $_POST['selectStatus'];

            	$conn = db_connect(); // Updates bug status
            	update_status($conn, 'Bugs', $bug_id, $status);
            	db_close($conn);
            }
		} else { // If the user is not logged in they are redirected to the login page
			header("Location: ../login/login.php");
		}
    ?>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <p class="navbar-brand">SCU Bug Tracker</p>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto"> </ul>
            <ul class="nav nav-pill
                <li class="nav-item">
                    <a class="nav-link" href="../login/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <h1>Welcome, <?php echo $_SESSION['firstname']; ?>!</h1>
            <hr />
            <div>
                <p>
                    <?php
                        $conn = db_connect(); // Prints out bugs specific to tester
                        print_rows_query($conn, 'Bugs', "SELECT * FROM Bugs WHERE Status IN ('Testing', 'Validating') AND AssignedTester = '$employeeid'");
                        db_close($conn);
                    ?>
                </p>
            </div>

            <form action="tester.php" method="post">
                <div class="form-group">
                    <label for="selectBug">Select a Bug</label>
                    <select class="form-control" id="selectBug" name="selectBug">
                        <?php
                            $conn = db_connect(); // Tester only allowed to choose bugs they are assigned to
                            make_options($conn, 'BugID', 'Subject', 'Bugs', "WHERE Status IN ('Testing', 'Validating') AND AssignedTester = '$employeeid'");
                            db_close($conn);
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="selectStatus">Update Status</label>
                    <select class="form-control" id="selectStatus" name="selectStatus">
                        <option>Fixing</option>
                        <option>Fixed</option>
                    </select>
                </div>
                <input class="btn btn-primary" type="submit" value="Update">
            </form>
        </div>
    </div>

    <!-- Bootstrap JS / jQuery CDN links -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
