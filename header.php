<?php
    // $path="http://".$_SERVER['SERVER_NAME']."/pranavkolharkar";
    // $path = realpath( dirname(__FILE__).'/..' );
    // echo $path;
    function getPageName() {
        return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
    }

    $current_page=getPageName();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="title" content="<?php echo $metaTitle;?>">
        <meta name="keywords" content="<?php echo $metaKeywords;?>">
        <meta name="description" content="<?php echo $metaDescription;?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/css/restaurant.css">
        <link rel="stylesheet" href="/bootstrap/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.css"/>
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.js"></script>
        <script src="/bootstrap/bootstrap.min.js"></script>
        <title><?php echo $pageTitle; ?></title>
    </head>
    <body>
        <div class="container-fluid">
            <!-- Defining Nav Links -->
            <section id="nav-links">
                <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
                    <div class="container">
                        <a href="index.php" class="navbar-brand text-danger">Have a Delicious Food</a>
                        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarResponsive">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarResponsive">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-items"><a href="MenuListing.php" class="nav-link <?php echo $current_page=='MenuListing.php' ? 'active':NULL ?>">Menu</a></li>
                                <li class="nav-items"><a href="contact_us.php" class="nav-link <?php echo $current_page=='contact_us.php' ? 'active':NULL ?>">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </section>
