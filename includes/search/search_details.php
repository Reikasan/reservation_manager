<section class="main">
    <h1>Reservation Details</h1>

<?php
    if(isset($_SESSION['currentPage'])) {
        $page = $_SESSION['currentPage'];
        echo "<form id='backToSearch' action='search.php?page={$page}' method='post'>";
    } else {
        echo "<form id='backToSearch' action='search.php' method='post'>";
    }
?>
    <form id="backToSearch" action="search.php" method="post">
        <div class="back">
            <i class="fas fa-chevron-left"></i>
            <input type="submit" name="returnSearch" value="Back to Search result">
        </div>
    </form>
    
    <div class="reservationDetails">
        
    <?php
    // STATUS CHANGE
    if(isset($_POST['newStatus'])){
        $request_id = escape($_POST['request_id']);
        $new_status = escape($_POST['newStatus']);

        $changeStatusStmt = mysqli_prepare($connection, "UPDATE reservation_request SET request_status = ? WHERE request_id = ?");
        mysqli_stmt_bind_param($changeStatusStmt, "si", $new_status, $request_id);
        mysqli_execute($changeStatusStmt);

        header ("Location: reservation/details/$request_id");
    }
    
    // SHOW DATA FROM REQUEST_ID
    if(isset($_GET['r_id'])){
        $request_id = $_GET['r_id'];
    ?>
        <div class="anotherReservation">
            <ul>
    <?php
        // SELECT ALL DATA FROM REQUEST_ID
        $stmt = mysqli_prepare($connection, "SELECT request_id, request_name, request_email, request_tel, request_date, DATE_FORMAT(request_time, '%H:%i'), request_num_seats, request_comment, request_status, request_recieved_time, request_flag, request_edited_time FROM reservation_request WHERE request_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $request_id);
        mysqli_execute($stmt);
        mysqli_stmt_bind_result($stmt, $request_id, $request_name, $request_email, $request_tel, $request_date, $request_time, $request_num_seats, $request_comment, $request_status, $request_recieved_time, $flag, $request_edited_time );
        mysqli_stmt_store_result($stmt);

        mysqli_stmt_fetch($stmt);

        // change request status 'unread' to 'pending"
        if($request_status === 'unread') {
            $stmt1 = mysqli_prepare($connection, "UPDATE reservation_request SET request_status = 'pending' WHERE request_id = ?");
            mysqli_stmt_bind_param($stmt1, "i", $request_id);
            mysqli_execute($stmt1);
        } 

        // SELECT ALL DATA FROM SAME REQUEST_DATE
        $stmt2= mysqli_prepare($connection, "SELECT request_id, request_date, DATE_FORMAT(request_time, '%H:%i'), request_num_seats, request_comment, request_status, request_recieved_time, request_flag FROM reservation_request WHERE request_date = ? ORDER BY request_time ASC");
        mysqli_stmt_bind_param($stmt2, "s", $request_date);
        mysqli_execute($stmt2);
        mysqli_stmt_bind_result($stmt2, $another_request_id, $another_request_date, $another_request_time, $another_request_num_seats, $another_request_comment, $another_request_status, $another_request_recieved_time, $another_request_flag );
        mysqli_stmt_store_result($stmt2);
        $num_another_reservations = mysqli_stmt_num_rows($stmt2)-1;
        
        // format date and time
        $formated_request_date = date_create($request_date);
        $formated_request_date = date_format($formated_request_date, 'D d.m.Y');

        $formated_request_recieved_time = date_create($request_recieved_time);
        $formated_request_recieved_time = date_format($formated_request_recieved_time, 'D d.m.Y H:i');

        if(isset($request_edited_time)) {
            $formated_request_edited_time = date_create($request_edited_time);
            $formated_request_edited_time = date_format($formated_request_edited_time, 'D d.m.Y H:i');
        }

        if($num_another_reservations > 0) {
            echo "<li class='date'><i class='fas fa-exclamation'></i> $num_another_reservations more Requests on $formated_request_date<i class='fas fa-caret-down dropdown2'></i></li>";

            while(mysqli_stmt_fetch($stmt2)) {
                $another_request_recieved_time = date_create($another_request_recieved_time);
    ?>
                <li <?php if($request_id === $another_request_id){ echo 'class="selected"'; } ?> >
                    <a href="reservation/details/<?php echo $another_request_id; ?>">
                        <div class="list-container">
                            <div class="details">
                                <p class="small"><?php echo DATE_FORMAT($another_request_recieved_time,'d-m-Y H:i'); ?></p>
                                <div>
                                    <p><?php echoFlag($another_request_flag); ?></p>
                                    <p><?php echo $another_request_time; ?></p>
                                    <p><?php echo $another_request_num_seats; ?> Seats</p>
                                    <?php echoCommentSign($another_request_comment); ?>
                                </div>
                            </div>
                            <div class="status <?php echo $another_request_status; ?>">
                                <p><?php echo $another_request_status; ?></p>
                            </div>
                        </div>
                    </a>
                </li>
    <?php
            } // end of while loop
        } else {
            echo "<li class='date'>No other reservation on $formated_request_date</li>";
        } 
    ?>
            </ul>
        </div>
        <div class="mail">

            <div class="mail-header">
                <div class="status <?php echo $request_status; ?>"><?php echo $request_status; ?></div>
                <div class="row">
                    <?php echoFlag($flag); ?>
                    <table class="small">
                        <tbody>
                            <tr>
                                <td>Recieved </td>
                                <td>: <?php echo $formated_request_recieved_time; ?></td>
                            </tr>
                            <?php
                            if(isset($formated_request_edited_time)) {
                            ?>
                            <tr>
                                <td>Edited </td>
                                <td>: <?php echo $formated_request_edited_time; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>               
                </div>
                
            </div> <!-- end of mail-header -->
            <table class="mail-contents">
                <tbody>
                    <tr>
                        <td class="label">Name :</td>
                        <td class="contents"><?php echo $request_name; ?></td>
                    </tr>
                    <tr>
                        <td class="label">Email :</td>
                        <td class="contents"><?php echo $request_email; ?></td>
                    </tr>
                    <tr>
                        <td class="label">Phone :</td>
                        <td class="contents"><?php if($request_tel == "") { echo " - "; } else { echo $request_tel; }?></td>
                    </tr>
                    <tr>
                        <td class="label">Reservation Time :</td>
                        <td class="contents"><?php echo $request_time; ?></td>
                    </tr>
                    <tr>
                        <td class="label">Seats :</td>
                        <td class="contents"><?php echo $request_num_seats; ?></td>
                    </tr>
                    <tr>
                        <td class="label">Special Request :</td>
                        <td class="contents comment"><?php echo $request_comment; ?></td>
                    </tr>
                </tbody>
            </table> <!-- end of mail-contents -->
            <form class="editBtnContainer" action="edit_reservation.php?r_id=<?php echo $request_id; ?>&search" method="post">
                <input type="submit" value="Edit" class="btn">
            </form>
            <div class="down hide">
                <i class="fas fa-angle-down"></i>
            </div>
<?php }  ?> 
        </div> <!-- end of mail -->
    </div> <!-- end of .reservationBox -->