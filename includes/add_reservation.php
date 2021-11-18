<?php
    if(isset($_POST['addNewReservation'])) {
        $new_request_name = escape($_POST['name']);
        $new_request_email = escape($_POST['email']);
        $new_request_tel = escape($_POST['tel']);
        $new_request_date = escape($_POST['date']);
        $new_request_time = escape($_POST['time']);
        $new_request_num_seats = escape($_POST['seats']);
        $new_request_comment = escape($_POST['comments']);
        $new_request_via = escape($_POST['via']);
        $new_request_status = escape($_POST['status']);
        $new_request_recieved_time = date("Y-m-d H:i:s");

        $new_request_time = date_create($new_request_time);
        $new_request_time = date_format($new_request_time, 'H:i:s');

        //CHECK REQUEIRED FIELDS ARE FILED
        if(!empty($request_name) && !empty($request_date) && !empty($request_time) && !empty($request_num_seats) && !empty($request_status)) {
            if(empty($request_email) && empty($request_tel) ) {
                $message = "not enough infos";
            }
        }

        $addNewStmt= mysqli_prepare($connection, "INSERT INTO reservation_request (request_name, request_email, request_tel, request_date, request_time, request_num_seats, request_comment, request_status, request_recieved_time, request_via) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($addNewStmt, "sssssissss", $new_request_name, $new_request_email, $new_request_tel, $new_request_date, $new_request_time, $new_request_num_seats, $new_request_comment, $new_request_status, $new_request_recieved_time, $new_request_via );
        mysqli_execute($addNewStmt);

        $query = "SELECT request_id FROM reservation_request ORDER BY request_id DESC LIMIT 1";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $request_id = $row['request_id'];
        
        $message = "<h2 class='success'> 1 Reservation saved <a class='check' href='reservation.php?source=details&r_id={$request_id}'>check</a><i class='fas fa-times closeBtn'></i></h2>";   
        
    }
?>

<section class="main">
    <h1>Add Reservation</h1>

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
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="email" class="short">Email</label>
                <input type="email" name="email" id="email">
            </div>
            <div class="form-group">
                <label for="tel" class="short">Phone</label>
                <input type="tel" name="tel" id="tel">
            </div>
            <div class="form-group">
                <label class="long" for="">Date & Time*</label>
                <div class="row">
                    <input class="short" type="date" name="date" id="date" required>
                    <select class="short" name="time" id="time" required>
                        <option value="" disabled selected> - Select -</option>
                        <option value="18:00">18:00</option>
                        <option value="18:30">18:30</option>
                        <option value="19:00">19:00</option>
                        <option value="19:30">19:30</option>
                        <option value="20:00">20:00</option>
                        <option value="20:30">20:30</option>
                        <option value="21:00">21:00</option>
                        <option value="21:30">21:30</option>
                        <option value="22:00">22:00</option>
                        <option value="22:30">22:30</option>
                        <option value="23:00">23:00</option>
                        <option value="23:30">23:30</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="seats" class="long">Number of Seats*</label>
                <select name="seats" id="seats"  class="short" requered>
                    <option value="" disabled selected> - Select -</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
            </div>
            <div class="form-group">
                <label for="comments" class="long">Special Request</label>
                <textarea name="comments" id="comments" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group checkbox-container">
                <label for="" class="long">Reservation via</label>
                    <div class="radioBtnContainer">
                        <label for="phone" class="checkboxlabel">Phone</label>
                        <input type="radio" name="via" value="phone" checked>
                    </div>
                    <div class="radioBtnContainer">
                        <label for="facebook" class="checkboxlabel">Facebook</label>
                        <input type="radio" name="via" value="facebook">
                    </div>
                    <div class="radioBtnContainer">
                        <label for="twitter" class="checkboxlabel">Twitter</label>
                        <input type="radio" name="via" value="twitter">
                    </div>
                    <div class="radioBtnContainer">
                        <label for="others" class="checkboxlabel">Other</label>
                        <input type="radio" name="via" value="others">
                    </div>
            <div class="form-group">
                <label for="status" class="long">Reservation Status*</label>
                <select name="status" id="status"  class="short" requered>
                    <option value="" disabled selected> - Select -</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="canceled">Canceled</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
            <div class="form-group btn-container">
                <input type="submit" name="addNewReservation" value="Add Reservation" class="btn" id="send">
            </div>
            
        </form>
    </div> <!-- end of .reservationBox -->
