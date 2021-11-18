<?php
// clear previous search data
unset($_SESSION['searchText']);
unset($_SESSION['searchCategory']);
unset($_SESSION['query']);
unset($_SESSION['searchQuery']);
unset($_SESSION['displayName']);
unset($_SESSION['filters']);
unset($_SESSION['filterValues']);
unset($_SESSION['filterQueries']);
unset($_SESSION['currentPage']);


?>
<section class="main">
    <h1>Reservation Request</h1>
    <?php include "includes/searchbox.php"; ?>
    <div class="reservationBox">
        <!-- BULK OPTIONS -->
        <?php include "includes/bulkoptions.php"; ?>

        <?php 
            if(isset($message)) {
                echo $message;
            }
        ?>

        <table>
            <thead>
                <tr>
                    <th><input type="checkbox" name="" id="selectAllBoxes"></th>
                    <th><i class="fas fa-circle"></i></th>
                    <th><i class="far fa-flag"></i></th>
                    <th>Date</th>
                    <th class="timeCell">Time</th>
                    <th>Name</th>
                    <th>Seats</th>
                    <th class='commentCell'>Special Request</th>
                    <th class='detailCell'>Details</th>
                    <th>Status</th>
                </tr>
            </thead> 
            <tbody>
            <?php
                
                // PAGINATION
                $per_page = 10;

                $query = "SELECT * FROM reservation_request ORDER BY request_recieved_time DESC ";
                $result = mysqli_query($connection, $query);
                $count = mysqli_num_rows($result);
                $count_pagination = ceil($count/$per_page);
                
                if(isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    if(isset($_SESSION['currentPage'])) {
                        $page = $_SESSION['currentPage'];
                    } else {
                        $page = 1;
                    }
                }

                $_SESSION['currentPage'] = $page;

                if($page == 1 || $page == 1) {
                    $start_show_request = 0; 
                } else {
                    $start_show_request = ($page * $per_page) - $per_page;
                }
                
                if($count > 0) {
                    $query .= "LIMIT $start_show_request, $per_page";
                    
                    $select_all_request_query = mysqli_query($connection, $query);
                    while($row= mysqli_fetch_assoc($select_all_request_query)) {
                    
                        $request_id = $row['request_id'];
                        $request_name = $row['request_name'];
                        $request_date = $row['request_date'];
                        $request_time = $row['request_time'];
                        $request_num_seats = $row['request_num_seats'];
                        $request_comment = $row['request_comment'];
                        $request_status = $row['request_status'];
                        $request_recieved_time = $row['request_recieved_time'];
                        $flag = $row['request_flag'];
                        $today = date("Y-m-d");//"2021-09-01"; //date("Y-m-d");

                        // format date and time
                        $formated_request_date = date_create($request_date);
                        $formated_request_date = date_format($formated_request_date, 'D d.m');

                        $formated_request_time = date_create($request_time);
                        $formated_request_time = date_format($formated_request_time, 'H:i');

                        checkPastEvent($request_date, $today);
                        
                        echo "<td><input class='checkbox' type='checkbox' name='checkBoxArray[]' value='$request_id'></td>";
                        
                        echoUnreadSign($request_status);
                        echoFlagInTd($flag);

                        echo "<td>$formated_request_date</td>";
                        echo "<td class='timeCell'>$formated_request_time</td>";
                        echo "<td class='name'>$request_name</td>";
                        echo "<td>$request_num_seats</td>";

                        echoSubstringedComment($request_comment);

                        echo "<td class='detailCell'><button class='btn details'><a href='reservation/details/$request_id'>Details</a></button></td>";
                        echo "<td title='go to details'><a href='reservation/details/$request_id' class='btn status $request_status' title='$request_status'>$request_status</a></td>";
                        
                        echo "</tr>";
                    }
                } else {
                    echo '<h2 class="no-result filtered"><span class="bold">"';
                } 
                ?>
                </tbody>
            </table>
        </form>
        <!-- PAGINATION -->
        <?php include "includes/all_reservations/pagination.php"; ?>
        
    </div>
