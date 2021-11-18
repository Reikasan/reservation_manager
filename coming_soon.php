<?php include "includes/header.php"; ?>
<?php 
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'user' ) {
    header("Location: login.php");
    $message = "<p class='warning'>User does not exist. Please check your account.</p>";
} 
?>
<?php include "includes/navigation.php"; ?>

<div class="container">
    <!-- sidebar -->
    <?php include "includes/sidebar.php"; ?>

    <!-- main content -->
    <section class="main">
        <h1 class="coming">Coming Soon!</h1>

<?php include "includes/footer.php" ?>