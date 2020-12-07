<?php

//登入控制頁面
$display = "none";
$errorMsg = "";
$logText = "Log in";

if (isset($_POST["lg_btn"])) {
    $display = "block";
}
if (isset($_POST["ck_btn"])) {

    for ($i = 0; $i < count($userName); $i++) {
        if ($_POST["userName"] == $userName[$i] && $_POST["passWord"] == $passWord[$i]) {
            $_SESSION["playerName"]=$_POST["userName"];
            $display = "none";
            $errorMsg = "";
            $logText = "Log out";
            
            break;
        } elseif ($_POST["userName"] != $userName[$i] && $_POST["passWord"] != $passWord[$i]) {
            $display = "block";
            $errorMsg = "請確認帳號密碼";
        }
    }
}

//提取id做跳轉頁面資訊及跳轉到會員專屬頁面
$playerId ="Guest";
if (isset($_POST["ck_btn"])){
        $signupList2 = <<<signupText2
        SELECT playerId
        FROM member
        WHERE userName='{$_POST["userName"]}' AND passWord ='{$_POST["passWord"]}'
        signupText2;
        $result2= mysqli_query($link, $signupList2);
        $row2 = mysqli_fetch_assoc($result2);
        @$playerId=$row2["playerId"];
        $_SESSION["playerID"]=$playerId;
        
}


   
//註冊控制頁面

$display1="none";
$errorMsg1 = "";
if(isset($_POST["signUp_btn"])){
    $signUpdata=<<<signUpdata1
    SELECT * FROM member WHERE userName = '{$_POST["userName1"]}'
    signUpdata1;
    $result3=mysqli_query($link, $signUpdata);
    $row3=mysqli_fetch_assoc($result3);
    // var_dump($row3);
    if($row3!=null){
        $display1="block";
        $errorMsg1 = "帳號已被使用請更換";
    }

    if($row3==null){
        $signupList = <<<signupText
         insert into member(userName,passWord,eMail) 
         values('{$_POST["userName1"]}',
         '{$_POST["passWord1"]}',
          '{$_POST["eMail1"]}');

    signupText;
    mysqli_query($link, $signupList);
    

    }
    if($row3==null){
        $signupList1 = <<<signupText1
        insert into gamescore(userName) 
        values('{$_POST["userName1"]}');
    
    signupText1;
        mysqli_query($link, $signupList1);
    }
   
   
}




?>