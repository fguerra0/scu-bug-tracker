<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCU Bug Tracker</title>
</head>
<body>
    <h1>Welcome, Manager!</h1>
    <hr />
    <div>
        <p>
            <?php
                include 'db.php';

                $conn = db_connect();

                print_rows($conn, 'Bugs');

                db_close($conn);
            ?>
        </p>
    </div>
    <div>
        <p>
            <?php
                include 'db.php';

                $conn = db_connect();

                print_rows($conn, 'Testers');

                db_close($conn);
            ?>
        </p>
    </div>
    <div>
        <p>
            <?php
                include 'db.php';

                $conn = db_connect();

                print_rows($conn, 'Devs');

                db_close($conn);
            ?>
        </p>
    </div>
</body>
</html>
