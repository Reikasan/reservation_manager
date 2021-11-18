<?php
$num_pagination = 3;
$i = 1;
$maxPage = $num_pagination;

$back = "<li><a href='search/page/" .($page - 1) ."'><i class='fas fa-angle-left'></i></a></li>";
$more ="<li><a href='search/page/" .($page +1 ) ."'><i class='fas fa-angle-right'></i></a></li>";


if($count_pagination <= $num_pagination) {
    $maxPage = $count_pagination;
    $back = "";
    $more = "";
    
} elseif ($count_pagination > $num_pagination && $page <= $num_pagination ) {
    $back = "";
    $more = "<li><a href='search/page/" .($page +1 ) ."'><i class='fas fa-angle-right'></i></a></li>";
    
} elseif ($count_pagination > $num_pagination && $page == $count_pagination ) {
    $i = $page - 2;
    $maxPage = $count_pagination;
    $more = "";
    
} elseif ($count_pagination > $num_pagination && $page > $num_pagination && $count_pagination > $page ) {
    $i = $page - floor($page % $num_pagination);
    $maxPage = $i + 2;
}

echo "<ul class='pagination'>";


if(isset($_session['query'])) {
    $query = $_SESSION['query'];
} elseif(isset($_session['searchQuery'])) {
    $query = $_SESSION['searchQuery'];
}

echo $back;

for($i; $i <=$maxPage; $i++) {
    if(($page == 1 || $page == "") && $i == 1) {
        echo "<li class='active'>{$i}</li>";
    } elseif($i == $page) {
        echo "<li class='active'>{$i}</li>";
    } else {
        echo "<li><a href='search/page/$i'>$i</a></li>";
    }
}

echo $more;
echo "</ul>";

?>