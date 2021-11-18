<?php include "includes/header.php"; ?>
<?php
    if(isset($_GET['r_id'])) {
        $request_id = $_GET['r_id'];

        // SELECT ALL DATA FROM REQUEST_ID
        $stmt = mysqli_prepare($connection, "SELECT request_id, request_name, request_email, request_tel, request_date, DATE_FORMAT(request_time, '%H:%i'), request_num_seats, request_comment, request_status, request_recieved_time, request_via FROM reservation_request WHERE request_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $request_id);
        mysqli_execute($stmt);
        mysqli_stmt_bind_result($stmt, $request_id, $request_name, $request_email, $request_tel, $request_date, $request_time, $request_num_seats, $request_comment, $request_status, $request_recieved_time, $request_via );
        mysqli_stmt_store_result($stmt);

        mysqli_stmt_fetch($stmt);

        // SAVE EDITED RESERVATION DATA
        if(isset($_POST['editReservation'])) {
            $new_request_name = escape($_POST['name']);
            $new_request_email = escape($_POST['email']);
            $new_request_tel = escape($_POST['tel']);
            $new_request_date = escape($_POST['date']);
            $new_request_time = escape($_POST['time']);
            $new_request_num_seats = escape($_POST['seats']);
            $new_request_comment = escape($_POST['comments']);
            $new_request_via = escape($_POST['via']);
            $new_request_status = escape($_POST['status']);

            $new_request_time = date_create($new_request_time);
            $new_request_time = date_format($new_request_time, 'H:i:s');

            //CHECK REQUEIRED FIELDS ARE FILED
            if(!empty($new_request_name) && !empty($new_request_date) && !empty($new_request_time) && !empty($new_request_num_seats) && !empty($new_request_status)) {
                if(empty($new_request_email) && empty($new_request_tel) ) {
                    $message = "not enough infos";
                }
            }

            $editStmt= mysqli_prepare($connection, "UPDATE reservation_request SET request_name = ?, request_email = ?, request_tel = ?, request_date = ?, request_time = ?, request_num_seats = ?, request_comment = ?, request_status = ?, request_edited_time = NOW(), request_via = ? WHERE request_id = ? ");
            mysqli_stmt_bind_param($editStmt, "sssssisssi", $new_request_name, $new_request_email, $new_request_tel, $new_request_date, $new_request_time, $new_request_num_seats, $new_request_comment, $new_request_status, $new_request_via, $request_id );
            $result = mysqli_execute($editStmt);

            if(!$result) {
                die('Query Failed ' .mysqli_error($connection));
            }

            redirect("edit_reservation.php?r_id={$request_id}&edited");  
        } // end of $_POST['editReservation']

        // EDITED MESSAGE
        if(isset($_GET['edited'])) {
            $message = "<h2 class='success'> 1 Reservation Edited <a class='check' href='reservation/details/{$request_id}'>check</a><i class='fas fa-times closeBtn'></i></h2>"; 
        }
    }
    
?>
<?php include "includes/navigation.php"; ?>

<div class="container">
    <!-- sidebar -->
    <?php include "includes/sidebar.php"; ?>

    <section class="main">
        <h1>Edit Reservation</h1>

        <div class="back">
        <?php
            if(isset($_GET['search'])) {
                echo "<a href='reservation.php?source=search_details&r_id={$request_id}'>";
            } else {
                echo "<a href='reservation/details/{$request_id}'>";
            }
        ?>
                <i class="fas fa-chevron-left"></i>
                Back to Details
            </a>
        </div>

        <div class="reservationBox">
            <div class="message hide"></div>
            <?php
                if(isset($message)){
                    echo $message; 
                }
            ?>
            <form id="add" method="post">
                <div class="form-group">
                    <label for="name" class="short">Name*</label>
                    <input type="text" name="name" id="name" value="<?php echoValue($request_name); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email" class="short">Email</label>
                    <input type="email" name="email" id="email" value="<?php echoValue($request_email); ?>">
                </div>
                <div class="form-group">
                    <label for="tel" class="short">Phone</label>
                    <input type="tel" name="tel" id="tel" value="<?php echoValue($request_tel); ?>">
                </div>
                <div class="form-group">
                    <label class="long" for="">Date & Time*</label>
                    <div class="row">
                        <input class="short" type="date" name="date" id="date" value="<?php echoValue($request_date); ?>" required>
                        <select class="short" name="time" id="time" required>
                            <option value="" disabled selected> - Select -</option>
                            <option value="18:00" <?php checkSelected("18:00", $request_time); ?>>18:00</option>
                            <option value="18:30" <?php checkSelected("18:30", $request_time); ?>>18:30</option>
                            <option value="19:00" <?php checkSelected("19:00", $request_time); ?>>19:00</option>
                            <option value="19:30" <?php checkSelected("19:30", $request_time); ?>>19:30</option>
                            <option value="20:00" <?php checkSelected("20:00", $request_time); ?>>20:00</option>
                            <option value="20:30" <?php checkSelected("20:30", $request_time); ?>>20:30</option>
                            <option value="21:00" <?php checkSelected("21:00", $request_time); ?>>21:00</option>
                            <option value="21:30" <?php checkSelected("21:30", $request_time); ?>>21:30</option>
                            <option value="22:00" <?php checkSelected("22:00", $request_time); ?>>22:00</option>
                            <option value="22:30" <?php checkSelected("22:30", $request_time); ?>>22:30</option>
                            <option value="23:00" <?php checkSelected("23:00", $request_time); ?>>23:00</option>
                            <option value="23:30" <?php checkSelected("23:30", $request_time); ?>>23:30</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="seats" class="long">Number of Seats*</label>
                    <select name="seats" id="seats"  class="short" requered>
                        <option value="" disabled selected> - Select -</option>
                        <option value="1" <?php checkSelected(1, $request_num_seats); ?>>1</option>
                        <option value="2" <?php checkSelected(2, $request_num_seats); ?>>2</option>
                        <option value="3" <?php checkSelected(3, $request_num_seats); ?>>3</option>
                        <option value="4" <?php checkSelected(4, $request_num_seats); ?>>4</option>
                        <option value="5" <?php checkSelected(5, $request_num_seats); ?>>5</option>
                        <option value="6" <?php checkSelected(6, $request_num_seats); ?>>6</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="comments" class="long">Special Request</label>
                    <textarea name="comments" id="comments" cols="30" rows="10"><?php echoValue($request_comment); ?></textarea>
                </div>
                <div class="form-group checkbox-container">
                    <label for="" class="long">Reservation via</label>
                        <div class="radioBtnContainer">
                            <label for="website" class="checkboxlabel">Website</label>
                            <input type="radio" name="via" value="website"  <?php checkChecked("website", $request_via); ?>>
                        </div>
                        <div class="radioBtnContainer">
                            <label for="phone" class="checkboxlabel">Phone</label>
                            <input type="radio" name="via" value="phone"  <?php checkChecked("phone", $request_via); ?>>
                        </div>
                        <div class="radioBtnContainer">
                            <label for="facebook" class="checkboxlabel">Facebook</label>
                            <input type="radio" name="via" value="facebook" <?php checkChecked("facebook", $request_via); ?>>
                        </div>
                        <div class="radioBtnContainer">
                            <label for="twitter" class="checkboxlabel">Twitter</label>
                            <input type="radio" name="via" value="twitter" <?php checkChecked("twitter", $request_via); ?>>
                        </div>
                        <div class="radioBtnContainer">
                            <label for="others" class="checkboxlabel">Other</label>
                            <input type="radio" name="via" value="others" <?php checkChecked("other", $request_via); ?>>
                        </div>
                <div class="form-group">
                    <label for="status" class="long">Reservation Status*</label>
                    <select name="status" id="status"  class="short" requered>
                        <option value="" disabled> - Select -</option>
                        <option value="confirmed" <?php checkSelected("confirmed", $request_status); ?>>Confirmed</option>
                        <option value="canceled" <?php checkSelected("canceled", $request_status); ?>>Canceled</option>
                        <option value="pending" <?php checkSelected("pending", $request_status); ?>>Pending</option>
                    </select>
                </div>
                <div class="form-group btn-container">
                    <input type="submit" name="editReservation" value="Edit Reservation" class="btn" id="send">
                </div>
                
            </form>
        </div> <!-- end of .reservationBox -->
        <?php include "includes/footer.php"; ?>
