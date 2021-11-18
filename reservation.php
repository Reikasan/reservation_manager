<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>

<div class="container">
    <!-- sidebar -->
    <?php include "includes/sidebar.php"; ?>

    <!-- main content -->
    <?php
        if(isset($_GET['source'])) {
            $source = $_GET['source'];
        } else {
            $source = "";
        }

        switch($source) {
            case "details":
                include "includes/details.php";
                break;

            case "add":
                include "includes/add_reservation.php";
                break;
            
            case "search_details":
                include "includes/search/search_details.php";
                break;

            default:
                include "includes/all_reservations/all_reservations.php";
                break;
        }
    ?>
<?php include "includes/footer.php" ?>

