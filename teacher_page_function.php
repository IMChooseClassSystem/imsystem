<?php
function sem_credit_maker($kind_year, $creditUP, $creditDN, $hourUP, $hourDN, $hourTUP, $hourTDN)
{
  $str = "";
  if ($kind_year == "學期" && $creditUP != 0 && $creditDN == 0) {
    $str .= "<td>" . $kind_year . "（上）</td>";
    $str .= "<td>" . $creditUP . "</td>";
    $str .= "<td>" . $hourUP . "/" . $hourTUP . "</td>";
  } elseif ($kind_year == "學期" && $creditUP == 0 && $creditDN != 0) {
    $str .= "<td>" . $kind_year . "（下）</td>";
    $str .= "<td>" . $creditDN . "</td>";
    $str .= "<td>" . $hourDN . "/" . $hourTDN . "</td>";
  } elseif ($kind_year == "學年" && $creditUP != 0 && $creditDN != 0) {
    $str .= "<td>" . $kind_year . "</td>";
    $str .= "<td>" . $creditUP . "（x2）</td>";
    $str .= "<td>" . $hourUP . "/" . $hourTUP . "（x2）</td>";
  }
  return $str;
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
  $str = "";
  $str .= "<li class='page-item'><a class='page-link'  aria-label='Previous'> <span aria-hidden='true'>&laquo;</span></a></li>";
  for ($i = 1; $i <= $pages; $i++) {
    if ($active_page == $i)
      $str .= "<li class='page-item active'  value=" . $i . "><a class='page-link' onclick='changePage(" . $i . ")' >$i</a></li>";
    else
      $str .= "<li class='page-item'  value=" . $i . "><a class='page-link' onclick='changePage(" . $i . ")' >$i</a></li>";;
  }
  $str .= "<li class='page-item'><a class='page-link'  aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
  return $str;
}
function class_info_maker($result)
{
  $str = "";
  foreach ($result as $row) {
    $str .= "<tr>";
    $str .= "<td><input name='CC_CB' type='checkbox' id=" . $row["ID"] . "></td>";
    $str .= "<td>" . $row["course"] . "</td>";
    $str .= "<td>" . $row["outkind"] . "</td>";
    $str .= "<td>" . $row["kind_name"] . "</td>";
    $str .= "<td>" . $row["class_name"] . "</td>";
    $str .= "<td>" . $row["curriculum"] . "</td>";
    $str .= sem_credit_maker($row["kindyear"], $row["creditUP"], $row["creditDN"], $row["hourUP"], $row["hourDN"], $row["hourTUP"], $row["hourTDN"]);
    $str .= "</tr>";
  }
  return $str;
}
function changeClass($class_result, $classID)
{
  $str = "";
  $str .= "<option value=0>--</option>";
  foreach ($class_result as $row) {
    if ($row["class_ID"] == $classID) {
      $str .= "<option value=" . $row["class_ID"]  . " selected>" . $row["class_name"] . "</option>";
    } else {
      $str .= "<option value=" . $row["class_ID"] . ">" . $row["class_name"] . "</option>";
    }
  }
  return $str;
}