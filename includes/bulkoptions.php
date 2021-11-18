<?php 
    if(isset($_POST['bulkoptionApply'])) {
        $checkBoxArray = $_POST['checkBoxArray'];
        $length = count($checkBoxArray);

        if($length > 0) {
            foreach($checkBoxArray as $selectedRequestId) {
                $bulk_options = $_POST['bulk_options'];
    
                switch($bulk_options) {
                    case 'flag':
                        $flag_status = "active";
                        $bulkoptionQuery = "UPDATE reservation_request SET request_flag = ? WHERE request_id = ?";
                        $stmt = mysqli_prepare($connection, $bulkoptionQuery);
                        mysqli_stmt_bind_param($stmt, "si", $flag_status, $selectedRequestId);
                        $result = mysqli_execute($stmt);

                        $query = checkQuery();

                        if(isset($_SESSION['filters'])) {
                            $filters = $_SESSION['filters'];
                            $filterValues = $_SESSION['filterValues'];
                            $filterQueries = $_SESSION['filterQueries'];
                            createFilterQuery($filters, $filterQueries, $query, $filterLength);
                        }
                        
                        $message = bulkoptionMessage($length, $bulk_options);
                        break;

                    case 'removeFlag':
                        $flag_status = "deactive";
                        $bulkoptionQuery = "UPDATE reservation_request SET request_flag = ? WHERE request_id = ?";
                        $stmt = mysqli_prepare($connection, $bulkoptionQuery);
                        mysqli_stmt_bind_param($stmt, "si", $flag_status, $selectedRequestId);
                        $result = mysqli_execute($stmt);

                        $query = checkQuery();

                        $message = bulkoptionMessage($length, $bulk_options);
                        break;

                    case 'delete':
                        $bulkoptionQuery = "DELETE FROM reservation_request WHERE request_id = ?";
                        $stmt = mysqli_prepare($connection, $bulkoptionQuery);
                        mysqli_stmt_bind_param($stmt, "i", $selectedRequestId);
                        $result = mysqli_execute($stmt);

                        $query = checkQuery();

                        $message = bulkoptionMessage($length, $bulk_options);
                        break;
    
                    default:
                        $bulkoptionQuery = "UPDATE reservation_request SET request_status = ? WHERE request_id = ?";
                        $stmt = mysqli_prepare($connection, $bulkoptionQuery);
                        mysqli_stmt_bind_param($stmt, "si", $bulk_options, $selectedRequestId);
                        mysqli_execute($stmt);

                        $query = checkQuery();

                        $message = bulkoptionMessage($length, $bulk_options);
                        break;
                }
            }
        }

        
    }

?>
<form id="bulkOptions" method="post">
    <div id="bulkOptionsContainer">
        <select name="bulk_options" id="">
            <option value="" disabled selected>Options for selected Items</option>
            <option value="pending">Status change to Pending</option>
            <option value="confirmed">Status change to Confirm</option>
            <option value="canceled">Status change to Cancel</option>
            <option value="unread">Status change to Unread</option>
            <option value="flag">Add Flag</option>
            <option value="removeFlag">Remove Flag</option>
            <option value="delete">Delete Reservation</option>
        </select>
        <input type="submit" name="bulkoptionApply" value="Apply">
    </div>