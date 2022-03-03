<?php
function select_maker($op_result,$id_name, $value_name, $option_name){
    echo "<select class=\"form-control\" name=\"".$id_name."\" id=\"".$id_name."\">";
    foreach ($op_result as $row) {
      echo "<option value='" . $row[$value_name] . "'>" . $row[$option_name] . "</option>";
    }
    echo "</select>";

}

?>