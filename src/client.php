<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>SCU Bug Tracker</title>
    <?php
        include 'db.php';
    ?>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="../index.html">SCU Bug Tracker</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto"> </ul>
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" href="client.php">Client</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manager.php">Manager</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tester.php">Tester</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="developer.php">Developer</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container col-md-8 col-md-offset-2">
        <h2>Welcome to the</h2>
        <h1>SCU Bug Tracker</h1>

        <hr />
        <p>Please use the form below to report a bug with SCU services.</p>

        <form action="welcome_get.php" method="post">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputFirstName">First Name</label>
                    <input type="text" name="firstName" class="form-control"
                        id="inputFirstName" placeholder="First name" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputLastName">Last Name</label>
                    <input type="text" name="lastName" class="form-control"
                        id="inputLastName" placeholder="Last name" required>
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail">Email address</label>
                <input type="email" class="form-control" name="email"
                    aria-describedby="emailHelp" id="inputEmail" placeholder="Email address" required>
            </div>
            <div class="form-group">
                <label for="inputSubject">Subject</label>
                <input type="text" name="subject" class="form-control"
                    id="inputSubject" placeholder="Bug Subject/Title" required>
            </div>
            <div class="form-group">
                <label for="inputDescription">Description</label>
                <textarea class="form-control" name="description" rows="5" cols="40"
                    id="inputDescription" placeholder="Describe what happened..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <br />
        <hr />
        <br />
        <p>Want to check the status of a submitted bug? Enter the bug ID below.</p>

        <form action="client.php" method="get">
            <div class="form-group">
                <label for="inputBugID">Bug ID</label>
                <input type="text" name="bugID" class="form-control"
                    id="inputBugID" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <br />

        <?php
            if (isset($_GET['bugID'])) {
                $bugid = $_GET['bugID'];

                $conn = db_connect();
                print_bug_report($conn, $bugid);
                db_close($conn);
            }
        ?>
    </div>

    <!-- Bootstrap JS / jQuery CDN links -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>