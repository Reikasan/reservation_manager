<?php 
    ob_start();
    include "includes/header.php";
    include "includes/navigation.php"; 

    unset($_SESSION['currentPage']);
?>

<div class="container">
    <!-- sidebar -->
    <?php include "includes/sidebar.php"; ?>

    <section class="main">
        <h1>Search result</h1>
        <?php include "includes/searchbox.php"; ?>
       
        <div class="back">
            <a href="reservation">
                <i class="fas fa-chevron-left"></i>
                Back to All reservations
            </a>
        </div>

        <div class="reservationBox">  
    <?php
        // SEARCH AND FILTERS
        include "includes/search/search_filter.php";

        $result = mysqli_query($connection, $query);

        $count = mysqli_num_rows($result);
        $count_pagination = ceil($count/$per_page);

        if($count > 0){
            // user uses SEARCH BAR
            if((isset($_POST['search']) || isset($_SESSION['searchQuery']))) {
                if(isset($_SESSION['searchText'])) {
                    $searchText = $_SESSION['searchText'];
                    $displayName = $_SESSION['displayName'];
                }

                if($count == 1) {
                    echo '<h2 class="result"><span class="bold">"' .$searchText .'"</span> in <span class="bold">' .$displayName .'</span> find ' .$count .' result</h2>';
                    
                } elseif($count > 1) {
                    echo '<h2 class="result"><span class="bold">"' .$searchText .'"</span> in <span class="bold">' .$displayName .'</span> find ' .$count .' results</h2>';
                }

                // check if filter is set
                if(isset($_POST['applyFilter']) || isset($_SESSION['filters'])) {
                    echo "<form class='filterBtnContainer' method='post'>";
                    for($i = 0; $i <= 2; ++$i) {
                        createFilterBtn($filters, $filterValues, $i);
                    }
                    echo "</form>";
                } 
            } else {
                if($count === 1) {
                    echo '<h2 class="result">Find ' .$count .' result</h2>';
                } elseif($count >1) {
                    echo '<h2 class="result">Find ' .$count .' results</h2>';
                }

                echo "<form class='filterBtnContainer' method='post'>";
                for($i = 0; $i <= 2; ++$i) {
                    if(isset($_SESSION['filters'])) {
                        $filters = $_SESSION['filters'];
                    }
                    createFilterBtn($filters, $filterValues, $i);
                }
                echo "</form>";
            }


            // BULK OPTIONS
            include "includes/bulkoptions.php";

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
                            <th class='timeCell'>Time</th>
                            <th>Name</th>
                            <th>Seats</th>
                            <th class='commentCell'>Special Request</th>
                            <th class='detailCell'>Details</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
        <?php
                    $query .= "ORDER BY request_recieved_time DESC ";
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
                        $request_flag = $row['request_flag'];
                        $request_recieved_time = $row['request_recieved_time'];
                        $today = date("Y-m-d");//"2021-09-01"; //date("Y-m-d");

                        // format date and time
                        $formated_request_date = date_create($request_date);
                        $formated_request_date = date_format($formated_request_date, 'D d.m');

                        $formated_request_time = date_create($request_time);
                        $formated_request_time = date_format($formated_request_time, 'H:i');

                        checkPastEvent($request_date, $today);
                        
                        echo "<td><input class='checkbox' type='checkbox' name='checkBoxArray[]' value='$request_id'></td>";
                        
                        echoUnreadSign($request_status);
                        echoFlagInTd($request_flag);

                        echo "<td>$formated_request_date</td>";
                        echo "<td class='timeCell'>$formated_request_time</td>";
                        echo "<td class='name'>$request_name</td>";
                        echo "<td>$request_num_seats</td>";

                        echoSubstringedComment($request_comment);

                        echo "<td class='detailCell'><button class='btn details'><a href='reservation/search_details/$request_id'>Details</a></button></td>";
                        echo "<td><a href='reservation/search_details/$request_id' class='btn status $request_status'>$request_status</a></td>";
                        
                        echo "</tr>";
                    } // while loop
                ?>
                </tbody>
            </table>
        </form> <!-- end of bulkoptions form -->
        <?php
            } else {
                if((isset($_POST['search'])|| isset($_SESSION['searchText']))){
                    if(isset($_SESSION['searchText'])) {
                        $searchText = $_SESSION['searchText'];
                        $displayName = $_SESSION['displayName'];
                    }
                    
                    echo '<h2 class="no-result"><span class="bold">"' .$searchText .'"</span> in <span class="bold">' .$displayName .'</span> find no result</h2>';
                    
                    
                    
                
                } else {
                    echo '<h2 class="no-result">Find no result</h2>';
                }
                
                if(isset($_POST['applyFilter']) || isset($_SESSION['filters'])){
                    echo "<form class='filterBtnContainer' method='post'> ";

                    if(empty($filters)){
                        $filters = $_SESSION['filters'];
                        $filterValues = $_SESSION['filterValues'];
                    }

                    for($i = 0; $i <= 2; ++$i) {
                        createFilterBtn($filters, $filterValues, $i);
                    }
                    echo "</form>";
                }
                
                if(isset($message)) {
                    echo $message;
                }
            }
            
        ?>

        <!-- PAGINATION -->
        <?php include "includes/search/pagination.php"; ?>
        </div> <!-- end of .reservationBox --> 
<?php include "includes/footer.php"; ?>
<?php ob_end_flush(); ?>
