<?php
 function sem_credit_maker($kind_year, $creditUP, $creditDN, $hourUP, $hourDN, $hourTUP, $hourTDN){
  if($kind_year=="學期" && $creditUP!=0 && $creditDN==0){
    echo "<td>".$kind_year."（上）</td>";
    echo "<td>".$creditUP."</td>";
    echo "<td>".$hourUP."/".$hourTUP."</td>";
  }
  elseif($kind_year=="學期" && $creditUP==0 && $creditDN!=0){
    echo "<td>".$kind_year."（下）</td>";
    echo "<td>".$creditDN."</td>";
    echo "<td>".$hourDN."/".$hourTDN."</td>";

  }
  elseif($kind_year=="學年" && $creditUP!=0 && $creditDN!=0){
    echo "<td>".$kind_year."</td>";
    echo "<td>".$creditUP."（x2）</td>";
    echo "<td>".$hourUP."/".$hourTUP."（x2）</td>";
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
function class_info_maker($result){
  foreach ($result as $row) { 
    echo "<tr>";
    echo "<td scope=\"col\">".$row["ROW_ID"]."</td>";
    echo "<td scope=\"col\">".$row["course"]."</td>";
    echo "<td scope=\"col\">".$row["outkind"]."</td>";
    echo "<td scope=\"col\">".$row["kind_name"]."</td>";
    echo "<td scope=\"col\">".$row["class_name"]."</td>";
    echo "<td scope=\"col\">".$row["curriculum"]."</td>";
    sem_credit_maker($row["kindyear"], $row["creditUP"], $row["creditDN"], $row["hourUP"], $row["hourDN"], $row["hourTUP"], $row["hourTDN"]);
    echo "</tr>";
  } 
}



  
?>