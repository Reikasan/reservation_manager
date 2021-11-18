<?php include "includes/header.php"; ?>
<?php 
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'user' ) {
    header("Location: login");
    $message = "<p class='warning'>User does not exist. Please check your account.</p>";
} 
?>
<?php include "includes/navigation.php"; ?>

<div class="container">
    <!-- sidebar -->
    <?php include "includes/sidebar.php"; ?>

    <!-- main content -->
    <section class="main">
        <div class="today">
            <h1>Today's Reservation</h1>
            <div class="reservationBox index-page">
            <?php
                // SELECT TODAY'S RESERVATION DATA 
                $today = date("Y-m-d");
                $stmt = mysqli_prepare($connection, "SELECT request_id, request_name, request_date, request_time, request_num_seats, request_comment, request_status, request_flag FROM reservation_request WHERE request_date = ?");
                mysqli_stmt_bind_param($stmt, "s", $today);
                mysqli_execute($stmt);
                mysqli_stmt_bind_result($stmt, $request_id, $request_name, $request_date, $request_time, $request_num_seats, $request_comment, $request_status, $flag);
                mysqli_stmt_store_result($stmt);
                $num_row = mysqli_stmt_num_rows($stmt);

                if($num_row >= 1 ) {
                ?>
                    <table>
                        <thead>
                            <tr>
                                <th><i class='far fa-flag'></i></th>
                                <th>Time</th>
                                <th>Name</th>
                                <th>Seats</th>
                                <th class='commentCell'>Special Request</th>
                                <th class='detailCell'>Details</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                <?php
                    while(mysqli_stmt_fetch($stmt)){
                        // format date and time
                        $formated_request_time = date_create($request_time);
                        $formated_request_time = date_format($formated_request_time, 'H:i');

                        echo "<tr>";
                        echoFlagInTd($flag);
                        echo "<td>$formated_request_time</td>";
                        echo "<td class='name'>$request_name</td>";
                        echo "<td>$request_num_seats</td>";
                        echoSubstringedComment($request_comment);
                        
                        echo "<td class='detailCell'><a href='reservation/details/$request_id' class='btn details'>Details</a></td>";
                        echo "<td title='go to details'><a href='reservation/details/$request_id' class='btn status $request_status'>$request_status</a></td>";
                        echo "</tr>";
                    }
                    echo "</tbody> </table>";
                } else {
                    echo "<h1 class='no-data'>No Reservation</h1>";
                }
        
            ?>
            </div>
        </div>
        <?php
            // CHECK UNREAD REQUEST
            $query = "SELECT request_id FROM reservation_request WHERE request_status = 'unread'";
            $result = mysqli_query($connection, $query);
        
            $num_unread_request = mysqli_num_rows($result);
        ?>
        <div class="reservation">
            <div class="icon">
                <a href="reservation">
                    <i class="far fa-envelope"></i>
                    <h2>Reservation Request</h2>
                    <?php
                    if($num_unread_request > 0){
                        echo "<div class='new'>$num_unread_request</div>";
                    } 
                    ?>
                    
                </a>
            </div>
            <div class="icon">
                <a href="coming_soon">
                    <i class="far fa-calendar"></i>
                    <h2>Calendar</h2>
                </a>
            </div>
        </div>
        <?php include "includes/footer.php" ?>

