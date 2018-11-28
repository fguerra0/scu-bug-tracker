<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <title>SCU Bug Tracker</title>
    <?php

    include 'db.php';

	session_start();
	if($_SESSION['valid'])
	{
        if (isset($_POST['selectDeveloper']) && isset($_POST['selectTester'])){
        	$bug_selected = read_until_white_space($_POST['selectBug']);
            $developer_selected = read_until_white_space($_POST['selectDeveloper']);
            $tester_selected = read_until_white_space($_POST['selectTester']);

        	$conn = db_connect();
            assign_task($conn, 'Bugs', $bug_selected, $developer_selected, $tester_selected);
            update_status($conn, 'Bugs', $bug_selected, 'Testing');
            db_close($conn);
	}
	}
	else
	{
		header("Location: login.php");
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
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
            <hr />
            <br />
            <h2>Active Bug Tickets</h2>
            <div>
                <?php
                    $conn = db_connect();
                    print_rows_query($conn, 'Bugs', "SELECT * FROM Bugs WHERE Status != 'Fixed'");
                    db_close($conn);
                ?>
            </div>
            <div>
                <?php
                    $conn = db_connect();
                    print_rows_query($conn, 'Employees', "SELECT EmployeeID, Email, LastName, FirstName
                                                          FROM Employees WHERE EmployeeType = 'Tester'");
                    db_close($conn);
                ?>
            </div>
            <div>
                <?php
                    $conn = db_connect();
                    print_rows_query($conn, 'Employees', "SELECT EmployeeID, Email, LastName, FirstName
                                                          FROM Employees WHERE EmployeeType = 'Developer'");
                    db_close($conn);
                ?>
            </div>
            <p>Use the form below to assign a bug to a developer:</p>

            <form action="manager.php" method="post">
                <div class="form-group">
                    <label for="selectBug">Select a Bug</label>
                    <select class="form-control" id="selectBug" name="selectBug">
                        <?php
							$conn = db_connect();
							make_options($conn, 'BugID', 'Subject', 'Bugs', '');
							db_close($conn);
						?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="selectTester">Assign a Tester</label>
                    <select class="form-control" id="selectTester" name="selectTester">
                        <?php
                            $conn = db_connect();
                            make_options($conn, 'EmployeeID', 'LastName', 'Employees', "WHERE EmployeeType = 'Tester'");
                            db_close($conn);
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="selectDeveloper">Assign a Developer</label>
                    <select class="form-control" id="selectDeveloper" name="selectDeveloper">
                        <?php
                            $conn = db_connect();
                            make_options($conn, 'EmployeeID', 'LastName', 'Employees', "WHERE EmployeeType = 'Developer'");
                            db_close($conn);
                        ?>
                    </select>
                </div>
                <input class="btn btn-primary" type="submit" value="Assign">
            </form>

            <br />
            <hr />
            <br />
            <br />

            <h2>History of Completed Bug Tickets</h2>
            <div>
                <?php
                    $conn = db_connect();
                    print_rows_query($conn, 'Bugs', "SELECT * FROM Bugs WHERE Status = 'Fixed'");
                    db_close($conn);
                ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS / jQuery CDN links -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
