<?php
    $id=$_POST["id"];
    $pwd1=$_POST["pwd1"];
    $pwd2=$_POST["pwd2"];
    $names=$_POST["names"];
    $sex=$_POST["sex"];
 
    trim($id);
    trim($pwd1);
    trim($pwd2);
    trim($names);
    trim($sex);
   

    $msg="";

    if(strlen($id)<8)
        $msg="此帳號長度小於8<br>";
    /*elseif(substr_count($id,"$") >= 1 || substr_count($id,"@") >= 1)
         $msg=$msg."此帳號不能包含\$或\@";*/

    if(strlen($pwd1)<6 || strlen($pwd2)<6)
        $msg=$msg."此帳號長度小於6<br>";

    if(strcmp($pwd1,$pwd2) != 0)
        $msg=$msg."二次密碼輸入不一致";

    if(preg_match("/^[0-9]{4}[0-9]{6}$/",$id))
        {}
    else
        $msg=$msg."電話輸入有誤<br>";

    include("dbconnection.php");
    if(strcmp($msg,"") == 0)
       {
           $data=array($id,$names,$pwd1,$sex);
           $sql_query = "INSERT INTO member
                        (m_username,m_name,m_passwd,m_sex)
                        VALUES (?,?,?,?)";
        $db_link -> setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        $stmt = $db_link -> prepare($sql_query);
        $stmt -> execute($data);
        $db_link -> db=null;
        echo "會員資料新增成功";
        $url  = "localhost:8080/yo/test.html" ;  
       }
       else
        echo $msg;
?>

<html>   
<head>   
<meta http-equiv = “refresh”   content ="1"  url = "<?php echo $url;?>" >   
</head>   
<body>   
頁面只停留一秒……  
</body > 
</html >
