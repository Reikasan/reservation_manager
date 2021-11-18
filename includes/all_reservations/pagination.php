<?php
$num_pagination = 3;
$i = 1;
$maxPage = $num_pagination;

if(isset($_GET['flag'])) {
    $selectedFlag = $_GET['flag'];

    $back = "<li><a href='reservation.php?flag={$selectedFlag}&page=" .($page - 1) ."'><i class='fas fa-angle-left'></i></a></li>";
    $more ="<li><a href='reservation.php?flag={$selectedFlag}&page=" .($page +1 ) ."'><i class='fas fa-angle-right'></i></a></li>";

    if($count_pagination <= $num_pagination) {
        $maxPage = $count_pagination;
        $back = "";
        $more = "";

    } elseif ($count_pagination > $num_pagination && $page <= $num_pagination ) {
        $back = "";
        $more = "<li><a href='reservation.php?flag={$selectedFlag}&page=" .($page +1 ) ."'><i class='fas fa-angle-right'></i></a></li>";

    } elseif ($count_pagination > $num_pagination && $page == $count_pagination ) {
        $i = $page - ($page%$num_pagination);
        $maxPage = $count_pagination;
        $more = "";

    } elseif ($count_pagination > $num_pagination && $page > $num_pagination && $count_pagination > $page ) {
        $i = $page - ($page%$num_pagination);
        $maxPage = $count_pagination;

    } 

    echo "<ul class='pagination'>";
    echo $back;

    for($i; $i <=$maxPage; $i++) {
        if(($page == 1 || $page == "") && $i == 1) {
            echo "<li class='active'><a href='reservation.php?flag={$selectedFlag}&page={$i}'>{$i}</a></li>";
        } elseif($i == $page) {
            echo "<li class='active'><a href='reservation.php?flag={$selectedFlag}&page={$i}'>{$i}</a></li>";
        } else {
            echo "<li><a href='reservation.php?flag={$selectedFlag}&page={$i}'>{$i}</a></li>";
        }
    }

    echo $more;
    echo "</ul>";

} else {
    $back = "<li><a href='reservation/page/" .($page - 1) ."'><i class='fas fa-angle-left'></i></a></li>";
    $more ="<li><a href='reservation/page/" .($page +1 ) ."'><i class='fas fa-angle-right'></i></a></li>";

    if($count_pagination <= $num_pagination) {
        $maxPage = $count_pagination;
        $back = "";
        $more = "";
        
    } elseif ($count_pagination > $num_pagination && $page <= $num_pagination ) {
        $back = "";
        $more = "<li><a href='reservation/page/" .($page +1 ) ."'><i class='fas fa-angle-right'></i></a></li>";
        
    } elseif ($count_pagination > $num_pagination && $page == $count_pagination ) {
        $i = $page - ($page%$num_pagination);
        $maxPage = $count_pagination;
        $more = "";
        
    } elseif ($count_pagination > $num_pagination && $page > $num_pagination && $count_pagination > $page ) {
        $i = $page - ($page%$num_pagination);
        $maxPage = $count_pagination;

    } 

    echo "<ul class='pagination'>";
    echo $back;

    for($i; $i <=$maxPage; $i++) {
        if(($page == 1 || $page == "") && $i == 1) {
            echo "<li class='active'>{$i}</li>";
        } elseif($i == $page) {
            echo "<li class='active'>{$i}</li>";
        } else {
            echo "<li><a href='reservation/page/{$i}'>{$i}</a></li>";
        }
    }

    echo $more;
    echo "</ul>";
}


?>