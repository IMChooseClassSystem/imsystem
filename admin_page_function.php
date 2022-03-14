<?php
function sem_credit_maker($kind_year, $creditUP, $creditDN, $hourUP, $hourDN, $hourTUP, $hourTDN)
{
  if ($kind_year == "學期" && ($creditUP != 0 || $hourUP !=0 || $hourTUP !=0)) {
    echo "<td>" . $kind_year . "（上）</td>";
    echo "<td>" . $creditUP . "</td>";
    echo "<td>" . $hourUP . "/" . $hourTUP . "</td>";
  } elseif ($kind_year == "學期" && ($creditDN != 0 || $hourDN !=0 || $hourTDN !=0) ) {
    echo "<td>" . $kind_year . "（下）</td>";
    echo "<td>" . $creditDN . "</td>";
    echo "<td>" . $hourDN . "/" . $hourTDN . "</td>";
  } elseif ($kind_year == "學年") {
    echo "<td>" . $kind_year . "</td>";
    echo "<td>" . $creditUP . "（x2）</td>";
    echo "<td>" . $hourUP . "/" . $hourTUP . "（x2）</td>";
  } else {
    echo "<td>" . $kind_year . "</td>";
    echo "<td>" . $creditUP . "</td>";
    echo "<td>" . $hourUP . "/" . $hourTUP . "</td>";
  }
}

function page_maker($pages, $active_page)
{
  for ($i = 1; $i <= $pages; $i++) {
    if ($active_page == $i)
      echo "<li class='page-item active'  value=" . $i . "><a class='page-link' id='page' name='page' >$i</a></li>";
    else
      echo "<li class='page-item'  value=" . $i . "><a class='page-link' id='page' name='page' >$i</a></li>";;
  }
}
function page_makerByAjax($pages, $active_page)
{
  echo "<li class='page-item'><a class='page-link'  aria-label='Previous'> <span aria-hidden='true'>&laquo;</span></a></li>";
  for ($i = 1; $i <= $pages; $i++) {
    if ($active_page == $i)
      echo "<li class='page-item active'  value=" . $i . "><a class='page-link' onclick='changePage(" . $i . ")' >$i</a></li>";
    else
      echo "<li class='page-item'  value=" . $i . "><a class='page-link' onclick='changePage(" . $i . ")' >$i</a></li>";;
  }
  echo "<li class='page-item'><a class='page-link'  aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
}
function class_info_maker($result)
{
  foreach ($result as $row) {
    echo "<tr>";
    echo "<td><input name='CC_CB' type='checkbox' id=" . $row["ID"] . "></td>";
    echo "<td>" . $row["course"] . "</td>";
    echo "<td>" . $row["outkind"] . "</td>";
    echo "<td>" . $row["kind_name"] . "</td>";
    echo "<td>" . $row["class_name"] . "</td>";
    echo "<td>" . $row["curriculum"] . "</td>";
    sem_credit_maker($row["kindyear"], $row["creditUP"], $row["creditDN"], $row["hourUP"], $row["hourDN"], $row["hourTUP"], $row["hourTDN"]);
    echo "</tr>";
  }
}