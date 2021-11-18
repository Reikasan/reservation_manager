<?php 

// ESCAPE SQL INJECTION
function escape($string) {
    global $connection;
    $escapedString = mysqli_real_escape_string($connection, trim($string));
    return $escapedString;
}

// REDIRECT
function redirect($location) {
    header("Location: " .$location);
    exit;
}

// CHECK UNREAD REQUEST
function checkUnreadRequest() {
    global $connection;
    $query = "SELECT * FROM reservation_request WHERE request_status = 'unread'";
    $result = mysqli_query($connection, $query);

    $num_rows = mysqli_num_rows($result);
}

// CONFIRM
function confirm($result) {
    global $connection;
    if(!$result) {
        die("Query Failed ".mysqli_error($connection));
    }
}



// ECHO FLAG
function echoFlag($flag){
    if($flag === "" || empty($flag) || $flag === "deactive") {
        echo "<i class='far fa-flag'></i>";
    } else {
        echo "<i class='fas fa-flag active'></i>";
    }
}

//  ECHO COMMENT SIGN
function echoCommentSign($another_request_comment) {
    if($another_request_comment !== "" || !empty($another_request_comment)) {
        echo "<p title='Special Request'><i class='fas fa-exclamation'></i></p>";
    } 
}

// CHECK PAST EVENT
function checkPastEvent($request_date, $today) {
    if($request_date > $today) {
        echo "<tr>";
    } else {
        echo "<tr class='done'>";
    }
}

// ECHO FLAG IN TD
function echoFlagInTd($flag){
    if($flag === "" || empty($flag) || $flag === "deactive") {
        echo "<td><i class='far fa-flag'></i></td>";
    } else {
        echo "<td><i class='fas fa-flag active'></i></td>";
    }
}

// ECHO UNREAD SIGN
function echoUnreadSign($request_status) {
    if($request_status === "unread") {
        echo "<td><i class='fas fa-circle' title='unread'></i></td>";
    } else {
        echo "<td></td>";
    }
}

// ECHO SUBSTRINGED COMMENT 
function echoSubstringedComment($request_comment) {
    if(strlen($request_comment) >= 20) {
        $request_comment = substr($request_comment, 0, 20);
        echo "<td class='commentCell'>$request_comment ...</td>";
    } elseif(strlen($request_comment) > 0) {
        echo "<td class='commentCell'>$request_comment</td>";
    } else {
        echo "<td class='commentCell'> - </td>";
    }
}


// SEARCH_FILTER.PHP
function chengeFilterQuery($selectedFilter, $selectedFilterValue, $selectedFilterQueries, $filters, $filterValues, $filterQueries) {
    global $filters;
    global $filterValues;
    global $filterQueries;
    
    if($selectedFilter == "Flag") {
        $columnName = 'request_flag';
    } elseif ($selectedFilter == "Event date") {
        $columnName = 'request_date';
    } elseif ($selectedFilter == "Status") {
        $columnName = 'request_status';
    }

    if((isset($_POST['search']) || isset($_SESSION['searchText'])) || count($filters) > 0) {
        if($selectedFilterValue == "upcoming") {
            $selectedFilterQueries = "AND {$columnName} >= now() ";
        } elseif($selectedFilterValue == "past") {
            $selectedFilterQueries = "AND {$columnName} < now() ";
        } else {
        $selectedFilterQueries = "AND {$columnName} = '{$selectedFilterValue}' ";
        }
    } else {
        if($selectedFilterValue == "upcoming") {
            $selectedFilterQueries = "WHERE {$columnName} >= now() ";
        } elseif($selectedFilterValue == "past") {
            $selectedFilterQueries = "WHERE {$columnName} < now() ";
        } else {
        $selectedFilterQueries = "WHERE {$columnName} = '{$selectedFilterValue}' ";
        }
    }

    array_push($filters, $selectedFilter);
    array_push($filterValues, $selectedFilterValue);
    array_push($filterQueries, $selectedFilterQueries);
}

function createFilterQuery($filters, $filterQueries, $query, $filterLength) {
    if($filterLength > 0) {
        foreach($filterQueries as $filterQuery) {
            $filterQuery;
            $query .= $filterQuery;
        }

        return $query;
    } else {
        return $query;
    }
}

function createFilterBtn($filters, $filterValues, $i) {
    if(array_key_exists($i, $filters)) {
        $filter = ucfirst($filters[$i]);
        $filterValue = ucfirst($filterValues[$i]);
        echo $filterBtn = "<button class='filterBtn'>{$filter}: <span class='bold'>'{$filterValue}'</span><input type='submit' class='cancelFilterInput' name='cancelFilter' value='{$filterValue}'><i class='fas fa-times'></i></button>";
    } 
}

function replaceQueryString($filterQueries, $arrayIndex) {
    $changeQuery = $filterQueries[$arrayIndex];
    $filterQueries[$arrayIndex] = str_replace('AND', 'WHERE', $changeQuery);
    return $filterQueries[$arrayIndex];
}

/* BULKOPTIONS */
function checkQuery() {
    if(isset($_SESSION['searchQuery'])) {
        $query = $_SESSION['searchQuery'];
    } elseif(isset($_SESSION['query'])) {
        $query = $_SESSION['query'];
    } else {
        $query = "SELECT * FROM reservation_request ";
    }

    return $query;
}

function bulkoptionMessage($length, $bulkoption) {
    if($bulkoption === "flag") {
        $option = "<span class='bold'>Flag added</span>";
    } elseif($bulkoption === "removeFlag") {
        $option = "<span class='bold'>Flag removed</span>";
    } elseif($bulkoption === "delete") {
        $option = "<span class='bold'>deleted</span>";
    } else {
        $option = "change status to <span class='bold'>" .ucfirst($bulkoption) ."</span>";
    }

    if($length === 1) {
        $message = "<h2 class='success'><span class='bold'>1 item</span> selected and $option<i class='fas fa-times closeBtn'></i></h2>";
    } elseif($length > 1) {
        $message = "<h2 class='success'><span class='bold'>$length items</span> selected and $option<i class='fas fa-times closeBtn'></i></h2>";
    }

    return $message;
}

/* DETAILS.PHP */
function checkSelected($value, $selected_value) {
    if($selected_value === $value) {
        echo "selected";
    }
}

function checkChecked($value, $selected_value) {
    if($selected_value === $value) {
        echo "checked";
    }
}

/* EDIT_RESERVATION.PHP */
function echoValue($variable) {
    if($variable !== null) {
        echo $variable;
    }
}

?>