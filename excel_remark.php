<?php
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=teacher_remark.xls");
header("Pragma: no-cache");
header("Expires: 0");

require_once 'dbconnection.php';

$output = "";

$output .= "
		<table>
			<thead>
				<tr>
                    <th>#</th>
                    <th>教師</th>
                    <th>外系課程</th>
                    <th>是否超鐘點</th>
                </tr>
			</thead>
            <tbody>
	";
$result = query_sql($conn, "select T.ID, T.name, O.remark,O.over_class from orderlist_remark O right Join teacher_account T on O.teacher_ID = T.ID");
foreach ($result as $fetch) {

    $output .= "
				<tr>
					<td>" . $fetch['ID'] . "</td>
					<td>" . $fetch['name'] . "</td>
                    <td>" . $fetch['remark'] . "</td>
	            ";
    if ($fetch['over_class'] == 0) {
        $output .= "<td>否</td></tr>";
    } else {
        $output .= "<td>是</td></tr>";
    }
}
$output .= "
			</tbody>
 
		</table>
	";

echo $output;