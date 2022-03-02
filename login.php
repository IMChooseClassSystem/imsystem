<?php
phpinfo();
require_once("dbconnection.php");
$msg="";
if(isset($_POST["username"]) && isset($_POST["passwd"])){
    $query_RecLogin = "SELECT m_username, m_passwd FROM member WHERE m_username=:username";
    $stmt=$db_link->prepare($query_RecLogin);
    $stmt->bindparam(":username", $_POST["username"]);
    $stmt->execute();

    $result=$stmt->fetch(PDO::FETCH_ASSOC);
    $username=$result["m_username"];
    $passwd=$result["m_passwd"];
    $stmt->db=null;
    //echo "test1"+$_POST["passwd"];
    //echo "test2"+$passwd;

    if($username =='' || $username == null){
        $msg='查無此帳號，兩秒後自動導回登入畫面...';
        header("Refresh:2;url=test.html");
       
    }elseif( $_POST["passwd"] == '' || $passwd != $_POST["passwd"]){
        $msg='密碼不正確，兩秒後自動導回登入畫面...';
        header("Refresh:2;url=test.html");
        
    }else{
        $msg='帳密正確，兩秒後自動導向首頁...';
        header("Refresh:2;url=home.html");
    }
}
echo $msg; 

?>

