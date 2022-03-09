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
                    <th>修別</th>
                    <th>系所</th>
                    <th>學制</th>
                    <th>班級</th>
                    <th>課程名稱</th>
                    <th>學年 / 學期（上/下)</th>
                    <th>學分</th>
                    <th>上課</th>
                    <th>實習</th>
                    <th> 教師列表</th>
                </tr>
			</thead>
            <tbody>
	";
	$result = query_sql($conn, "SELECT distinct C.*, K.kind_name, CI.class_name, 
        stuff((
        SELECT ',' + Convert(varchar,T.name) + '(' + Convert(varchar,OA.sequence) + ') '
        FROM orderlist OA,teacher_account T
        WHERE OA.curriculum_ID = O.curriculum_ID and T.ID = OA.teacher_ID and OA.curriculum_ID = C.ID ORDER BY OA.sequence
        FOR XML PATH('')),1,1,'') AS teacherList
        FROM curriculum C 
		LEFT JOIN orderlist O on C.ID = O.curriculum_ID 
        LEFT JOIN kind_info K ON C.kind= K.kind_ID 
        LEFT JOIN class_info CI ON C.getyear= CI.class_ID and C.kind=CI.kind_ID");
	foreach ($result as $fetch){
 
	$output .= "
				<tr>
					<td>".$fetch['ID']."</td>
					<td>".$fetch['course']."</td>
                    <td>".$fetch['outkind']."</td>
                    <td>".$fetch['kind_name']."</td>
					<td>".$fetch['class_name']."</td>
					<td>".$fetch['curriculum']."</td>
	            ";
    if($fetch['kindyear']=="學期" && $fetch['creditUP']!=0 && $fetch['creditDN']==0){
        $output.= "<td>".$fetch['kindyear']."（上）</td>
                   <td>".$fetch['creditUP']."</td>
                   <td>".$fetch['hourUP']."</td>
                   <td>".$fetch['hourTUP']."</td>";
      }
    elseif($fetch['kindyear']=="學期" && $fetch['creditUP']==0 && $fetch['creditDN']!=0){
        $output.= "<td>".$fetch['kindyear']."（下）</td>
                   <td>".$fetch['creditDN']."</td>
                   <td>".$fetch['hourDN']."</td>
                   <td>".$fetch['hourTDN']."</td>";
    
      }
    elseif($fetch['kindyear']=="學年" && $fetch['creditUP']!=0 && $fetch['creditDN']!=0){
        $output.= "<td>".$fetch['kindyear']."（下）</td>
                   <td>".$fetch['creditDN']."</td>
                   <td>".$fetch['hourDN']."</td>
                   <td>".$fetch['hourTDN']."</td>";
      }
    $output.="
                   <td>".$fetch['teacherList']."</td>
                </tr>";
	}
 
	$output .="
			</tbody>
 
		</table>
	";
 
	echo $output;
 
 
?>