<?php
	header("Content-Type: application/xls");    
	header("Content-Disposition: attachment; filename=course_list.xls");  
	header("Pragma: no-cache"); 
	header("Expires: 0");
 
	require_once 'dbconnection.php';
 
	$output = "";
 
	$output .="
		<table>
			<thead>
				<tr>
                    <th>#</th>
                    <th>帳號</th>
                    <th>密碼</th>
                    <th>姓名</th>
                    <th>權限</th>
                </tr>
			</thead>
            <tbody>
	";
	$result = query_sql($conn, "SELECT * FROM teacher_account");
	foreach ($result as $fetch){
 
	$output .= "
				<tr>
					<td>".$fetch['ID']."</td>
					<td>".$fetch['account']."</td>
                    <td>".$fetch['password']."</td>
                    <td>".$fetch['name']."</td>
	            ";
    if($fetch['permission']==1)
        $output.= "<td>教師</td> ";
    else if($fetch['permission']==0)
        $output.= "<td>管理員</td> ";
    }
	$output .="
             </tr>
			</tbody>
 
		</table>
	";
 
	echo $output;
 
 
?>