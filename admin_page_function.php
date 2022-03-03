<?php
function sem_credit_maker($kind_year, $creditUP, $creditDN, $hourUP, $hourDN, $hourTUP, $hourTDN){
  if($kind_year=="學期" && $creditUP!=0 && $creditDN==0 && $hourTUP!=0){
    echo "<td>上</td>";
    echo "<td>".$creditUP."</td>";
    echo "<td>".$hourUP."</td>";
    echo "<td>".$hourTUP."</td>";
  }
  elseif($kind_year=="學期" && $creditUP==0 && $creditDN!=0 && $hourTDN!=0){
    echo "<td>下</td>";
    echo "<td>".$creditDN."</td>";
    echo "<td>".$hourDN."</td>";
    echo "<td>".$hourTDN."</td>";
  }
  elseif($kind_year=="學期" && $creditUP!=0 && $creditDN==0 && $hourTUP==0){
    echo "<td>上</td>";
    echo "<td>".$creditUP."</td>";
    echo "<td>".$hourUP."</td>";
    echo "<td></td>";
  }
  elseif($kind_year=="學期" && $creditUP==0 && $creditDN!=0 && $hourTDN==0){
    echo "<td>下</td>";
    echo "<td>".$creditDN."</td>";
    echo "<td>".$hourDN."</td>";
    echo "<td></td>";
  }
  elseif($kind_year=="學年" && $creditUP!=0 && $creditDN!=0 && $hourTUP!=0 && $hourTDN!=0){
    echo "<td></td>";
    echo "<td>".$creditUP."/".$creditDN."</td>";
    echo "<td>".$hourUP."/".$hourDN."</td>";
    echo "<td>".$hourTUP."/".$hourTDN."</td>";
  }
  elseif($kind_year=="學年" && $creditUP!=0 && $creditDN!=0){
    echo "<td></td>";
    echo "<td>".$creditUP."/".$creditDN."</td>";
    echo "<td>".$hourUP."/".$hourDN."</td>";
    echo "<td></td>";
  }

}

function page_maker($pages,$active_page ){
  for($i=1;$i<=$pages;$i++){
    if($active_page == $i) 
        echo "<li class='page-item active'  value=".$i."><a class='page-link' id='page' name='page' >$i</a></li>";
    else
        echo "<li class='page-item'  value=".$i."><a class='page-link' id='page' name='page' >$i</a></li>";;
    }
}

  $kind_sql = "SELECT * FROM kind_info";
  $kind_result = query_sql($conn, $kind_sql);

  if (!empty($_GET["kind"])){
    $class_sql = "SELECT * FROM class_info WHERE kind_ID=".$_GET["kind"];
    $class_result = query_sql($conn, $class_sql);
  }


  
?>