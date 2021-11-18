<?php

$searchText;
$searchCategory;
$displayName;
$filters = array();
$filterValues = array();
$filterQueries = array();
$filterLength = 0;

$initialQuery = "SELECT * FROM reservation_request ";   

// PAGINATION
$per_page = 5;

if(isset($_GET['page'])) {
    $page = $_GET['page'];   
    if(isset($_SESSION['query']) && !empty($_SESSION['query']) && !empty($_SESSION['filters'])){
        $query = $_SESSION['query'];
        $filters = $_SESSION['filters'];        
        $filterValues = $_SESSION['filterValues'];        
        $filterQueries = $_SESSION['filterQueries'];        

 
    } elseif((isset($_POST['search']) || isset($_SESSION['searchQuery'])) && !empty($_SESSION['searchQuery'])){
        $query = $_SESSION['searchQuery'];
    } 
    
} else {
    $page = 1;   
    $query = "SELECT * FROM reservation_request ";        
}

// store current page no to back from details page
$_SESSION['currentPage'] = $page;

if($page == 1 || $page == 1) {
    $start_show_request = 0; 
} else {
    $start_show_request = ($page * $per_page) - $per_page;
}

// SEARCH
if(isset($_POST['search'])) {
    $searchText = escape($_POST['searchText']);
    $searchCategory = escape($_POST['searchCategories']);

    $query .= "WHERE $searchCategory LIKE '%$searchText%' ";

    // search category name 
    $categoryQuery = "SELECT display_name FROM search_category WHERE table_name = '{$searchCategory}' ";
    $categoryName = mysqli_query($connection, $categoryQuery);

    $row = mysqli_fetch_assoc($categoryName);
    $displayName = $row['display_name'];

    // store search data for back from search details
    $_SESSION['searchText'] = $searchText;
    $_SESSION['searchCategory'] = $searchCategory;
    $_SESSION['query'] = $query;
    $_SESSION['searchQuery'] = $query;
    $_SESSION['displayName'] = $displayName;    
}

// BACK FROM SEARCH_DETAILS.PHP
if(isset($_POST['returnSearch'])) {
    // set variable when back from search_details.php
    if(isset($_SESSION['searchQuery']) && isset($_SESSION['filterValues'])) {
        $query = $_SESSION['searchQuery'];
        $searchText = $_SESSION['searchText'];
        $searchCategory = $_SESSION['searchCategory'];
        $displayName = $_SESSION['displayName'];
        $filters = $_SESSION['filters'];
        $filterValues = $_SESSION['filterValues'];
        $filterQueries = $_SESSION['filterQueries'];

        $filterLength = count($filters);
        $query = createFilterQuery($filters, $filterQueries, $query, $filterLength);

    } elseif(isset($_SESSION['searchQuery'])) {
        $query = $_SESSION['searchQuery'];
        $searchText = $_SESSION['searchText'];
        $searchCategory = $_SESSION['searchCategory'];
        $displayName = $_SESSION['displayName'];

    } elseif(isset($_SESSION['filterValues'])) {
        $query = $initialQuery;
        $filters = $_SESSION['filters'];
        $filterValues = $_SESSION['filterValues'];

        if($query === "SELECT * FROM reservation_request ") {
            $filterLength = count($filters);
            $query = createFilterQuery($filters, $filterQueries, $query, $filterLength);
        }
    }
}


// APPLY FILTERS
if(isset($_POST['applyFilter'])) {  
    if(isset($_SESSION['searchQuery'])) {
        $query =  $_SESSION['searchQuery'];
    } 

    if(isset($_POST['flag'])) {
        $flagFilter = "Flag";
        $flagFilterValue = $_POST['flag'];
        $flagFilterQuery = "";

        chengeFilterQuery($flagFilter, $flagFilterValue, $flagFilterQuery, $filters, $filterValues, $filterQueries);
    }
    
    if(isset($_POST['upcoming'])) {
        $upcomingFilter = "Event date";
        $upcomingFilterValue = $_POST['upcoming'];
        $upcomingFilterQuery = "";

        chengeFilterQuery($upcomingFilter, $upcomingFilterValue, $upcomingFilterQuery, $filters, $filterValues, $filterQueries);
    }

    if(isset($_POST['status'])) {
        $statusFilter = "Status";
        $statusFilterValue = $_POST['status'];
        $statusFilterQuery = "";

        chengeFilterQuery($statusFilter, $statusFilterValue, $statusFilterQuery, $filters, $filterValues, $filterQueries);   
    }

    $filterLength = count($filters);
    $query = createFilterQuery($filters, $filterQueries, $query, $filterLength);

    $_SESSION['query'] = $query;
    $_SESSION['filters'] = $filters;
    $_SESSION['filterValues'] = $filterValues;
    $_SESSION['filterQueries'] = $filterQueries;

}   //$_POST['applyFilter']


// FILTER CANCELED
if(isset($_POST['cancelFilter'])) {
    $canceledFilter = $_POST['cancelFilter'];
    $canceledFilter = strtolower($canceledFilter);

    $filters = $_SESSION['filters'];
    $filterValues = $_SESSION['filterValues'];
    $filterQueries = $_SESSION['filterQueries'];

    $selectedIndex = array_search($canceledFilter, $filterValues);

    if($selectedIndex == 0) {
        unset($filters[0]);
        unset($filterValues[0]);
        unset($filterQueries[0]);
    } elseif($selectedIndex == 1) {
        unset($filters[1]);
        unset($filterValues[1]);
        unset($filterQueries[1]);
    } elseif($selectedIndex == 2) {
        unset($filters[2]);
        unset($filterValues[2]);
        unset($filterQueries[2]);
    }


    // if user used search bar 
    if(isset($_SESSION['searchQuery'])) {
        $query = $_SESSION['searchQuery'];

        $filterLength = count($filters);

        // if filter still exists
        $query = createFilterQuery($filters, $filterQueries, $query, $filterLength);
        
    // if user doesnt use search bar
    } else {
        $firstKey = array_key_first($filterQueries);
        $filterLength = count($filters);

        if($filterLength == 2 && $firstKey == 1) {
            $filterQueries[1] = replaceQueryString($filterQueries, 1);
            
        } elseif ($filterLength == 1) {
            if($firstKey == 1) {
                $filterQueries[1] = replaceQueryString($filterQueries, 1);
                
            } elseif ($firstKey == 2) {
                $filterQueries[2] = replaceQueryString($filterQueries, 2);
                
            }
        }

        $query = $initialQuery;

        if($filterLength > 0) {
            foreach($filterQueries as $filterQuery) {
                $query .= $filterQuery;
            }
        } else {
            redirect("reservation.php");
        } 
    } 
}    // end of $_POST['cancelFilter'])

$_SESSION['query'] = $query;
$_SESSION['filters'] = $filters;
$_SESSION['filterValues'] = $filterValues;   
$_SESSION['filterQueries'] = $filterQueries;   

?>