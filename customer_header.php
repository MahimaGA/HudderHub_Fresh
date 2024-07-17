<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("session.php");
include("connection.php");

if (!empty($_SESSION["user_role"])) {
    if ($_SESSION["user_role"] == "T") {
        header('location: login.php');
        die;
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HudderHub Fresh</title>
    <link rel="stylesheet" href="./stylesheet/style.css">
    <link rel="stylesheet" href="./stylesheet/style1.css">
    <link rel="stylesheet" href="./stylesheet/style2.css">
    <link rel="stylesheet" href="./stylesheet/style3.css">
    <link rel="stylesheet" href="./stylesheet/style4.css">
    <link rel="stylesheet" href="./stylesheet/style5.css">
    <link rel="stylesheet" href="./stylesheet/style6.css">
    <link rel="stylesheet" href="./stylesheet/style7.css">
    <link rel="stylesheet" href="./stylesheet/rating.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@200&family=Merriweather&family=Montserrat&family=Sacramento&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-logo" href="index.php">
                    <img src="images/finallogo.png" style="margin-left:30px; max-width:40px;" alt="HudderHub Logo">
                    <a style="font-family: Josefin Sans; font-weight: 600; color: black; text-decoration: none;" href="index.php">&nbsp;HudderHub Fresh</a>

                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </ul>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="navbar-nav mx-auto" style="font-weight: 600;">
                        <a class="nav-item nav-link me-3" href="index.php" id="second-nav-items">Home </a>
                        <a class="nav-item nav-link me-3" href="aboutus.php" id="second-nav-items">About Us</a>
                        <a class="nav-item nav-link me-3" href="shop.php" id="second-nav-items">Shop </a>
                        <a class="nav-item nav-link me-3" href="contactus.php" id="second-nav-items">Contact Us</a>
                    </div>
                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="font-size: 17px;">
                    <li class="nav-item dropdown me-3">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        All Category &nbsp; &nbsp; &nbsp;
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php
                        $query = "SELECT * FROM PRODUCT_CATEGORY";
                        $result = oci_parse($connection, $query);

                        if (oci_execute($result)) {
                            while ($row = oci_fetch_assoc($result)) {
                                $category_id = $row["PRODUCT_CATEGORY_ID"];
                                $category_name = $row["CATEGORY_TYPE"];
                                $active_class = isset($_GET['category']) && in_array($category_id, $_GET['category']) ? 'active' : '';
                        ?>
                                <li><a class="dropdown-item <?php echo $active_class; ?>" href="shop.php?category[]=<?php echo $category_id; ?>"><?php echo $category_name; ?></a></li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </li>




                        <li class="nav-item">
                            <form method="get" action="search.php" class="d-flex">
                                <input class="form-control- me-3" style="width: 350px; border: 1px solid #ced4da; border-radius:3px" type="search" value="<?php if (isset($_GET["search"])) {
                                                                                                                                                                echo trim($_GET["search"], " ");
                                                                                                                                                            } ?>" placeholder="Search Products..." name="search" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit" name="filter">Search </button>
                            </form>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item me-3">
                            <?php
                            if (!empty($_SESSION["name"])) {
                                echo "<a href='./customer-dashboard/customerdash1.php' style='text-decoration: none;color: green; '>" . $_SESSION["name"] . "</a>";
                            }
                            ?>
                            <div class="logindrop">
                                <img src="images/icon/user.png" style="max-width:30px;" alt="user icon">
                                <div class="loginc">
                                    <div class="logincontent">
                                        <?php
                                        if (!empty($_SESSION["user_role"])) { ?>
                                            <a href="logout.php" class="loginlinks">Logout</a>
                                            <hr>
                                            <a href="./customer-dashboard/customerdash1.php" class="loginlinks">Dashboard</a>
                                        <?php } else { ?>
                                            <a href="login.php" class="loginlinks"> Login </a>
                                            <hr>
                                            <a href="newregister.php" class="loginlinks"> Register </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item me-3">
                            <a href="wishlist.php" class="navbar-logo" id="smicons"> <img src="images/icon/heart.png" style="max-width:30px;" alt="wishlist icon"> </a>
                        </li>
                        <li class="nav-item me-3">
                            <a href="shopcart.php" class="navbar-logo" id="smicons"> <img src="images/icon/shopping-bag.png" style="max-width:30px;" alt="shopping-bag icon"> </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <br>
    <br>

</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

</html>