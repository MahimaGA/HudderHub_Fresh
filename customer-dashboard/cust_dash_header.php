<?php
include('session.php');
include('connection.php');
if (!isset($_SESSION["username"])) {
    header('location:../login.php');
}
$userID = $_SESSION["user_id"];
$query = "select USER_PHOTO from HHF_USER where USER_ID = $userID";
$result = oci_parse($connection, $query);
if (oci_execute($result)) {
    while (($row = oci_fetch_array($result)) != false) {
        $image = $row["USER_PHOTO"];
    }
}
include('../functions.php');
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HudderHub Fresh</title>
    <link rel="stylesheet" href="style7.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@200&family=Merriweather&family=Montserrat&family=Sacramento&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous">
    </script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
            <a href="../index.php">
                <img src="../images/finallogo.png" style="max-width:60px;" alt="HudderHub Logo">
            </a>
                <a style="font-family: Josefin Sans; font-weight: 600; font-size: 18px; color: black; text-decoration: none;" href="../index.php">HudderHub Fresh</a>
            </div>
            <ul class="list-unstyled components">

                <div class="trader-name">
                    <p class="text-center" id="text2" style="color: black;">Welcome, <?php echo $_SESSION["name"]; ?></p>
                </div>

                <li>
                    <a href="customerdash1.php" class="traderui"> Account </a>
                    <hr>
                </li>

                <li>
                    <a href="../shopcart.php" class="traderui">View Cart </a>
                    <hr>
                </li>

                <li>
                    <a href="../wishlist.php" class="traderui">My Saved Items </a>
                    <hr>
                </li>
                <li>
                    <a href="customerdash2.php" class="traderui">Order History</a>
                    <hr>
                </li>

                <li>
                    <a href="customerdash5.php" class="traderui">Account Setting </a>
                    <hr>
                </li>

                <li>
                    <a href="customerdash6.php" class="traderui">Reset Password </a>
                    <hr>
                </li>

            </ul>



        </nav>
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                    </button>

                    <div class="navitems">

                        <a href="../index.php" class="navitems" style="text-decoration: none;"> Back to Home</a>


                    </div>
                </div>
            </nav>