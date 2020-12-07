<?php
require_once("dbconnect.php");
session_start();
$result = mysqli_query($link, "select * from member");
// $row = mysqli_fetch_assoc($result);

while ($row = mysqli_fetch_assoc($result)) {
    $userName[] = $row["userName"];
    $passWord[] = $row["passWord"];
    $userPic[] = $row["userPic"];   
    $eMail[] = $row["eMail"];   
  
}

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
         insert into member(userName,passWord,eMail,userPic) 
         values('{$_POST["userName1"]}',
         '{$_POST["passWord1"]}',
          '{$_POST["eMail1"]}',
          'pffcocn.png');

    signupText;
    mysqli_query($link, $signupList);
    

    }
    
}

//更改帳密

if(isset($_POST["mdf_btn1"])){
    @$mdfList = <<< mdfText
    UPDATE member 
    SET userName = '{$_POST["userName3"]}', 
    passWord ='{$_POST["passWord3"]}' 
    WHERE playerId ='{$_SESSION["playerID"]}';
    mdfText;
    mysqli_query($link, $mdfList);

}


// 照片上傳

if (isset ( $_POST ["up_btn"] )) {
    processFile ( $_FILES ["imgFile"] );
  
}
function processFile($imgFile) {
	if ($imgFile ["error"] != 0) {
		echo "Upload Fail! ";
		return;
	}
    
	$imgload = move_uploaded_file ($imgFile ["tmp_name"], "img/" . $imgFile["name"] );
	if (!$imgload) {
		die ( "move_uploaded_file() faile" );
		
    }
    $_SESSION["userPic"]=$imgFile["name"];
	// exit ();
}

//上傳圖片時加入資料庫
if (isset ($_POST["up_btn"])){
    $mdpicList = <<<mdpic
        UPDATE member 
        SET userPic = '{$_SESSION["userPic"]}' 
        WHERE playerId ='{$_SESSION["playerID"]}';
    mdpic;
        mysqli_query($link, $mdpicList);

}





if (isset($_POST["lg_btn"])){
    if($logText ="Log out")
    {
    $logText ="Log in";
    session_destroy();
        }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/final_fantasy_legends_logo_by_eldi13.png" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/Final.css">
    <title>Final_Fantasy</title>
    <style>
        /* 由PHP控制log in 視窗 */
        .member {
            display: <?= $display ?>;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            padding: 60px;
            font-family: 'Berkshire Swash';
            font-size: 1.3rem;
        }
        /* 會員註冊表單 */
        .signup_form {
        display: <?=$display1?>;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        padding: 60px;
        font-family: 'Berkshire Swash';
        font-size: 1.3rem;
        z-index: 2;
    }
    </style>
 
</head>

<body data-spy="scroll" data-target="#mynavbar" data-offset="0">

    <div class="container-fluid">
        <!-- 跑跑路行鳥 -->
        <a href="#"><img id="FF_Chocobo" onclick="moveTop()" src="img/FF Chocobo.gif" alt="" class="FF_Chocobo "></a>

        <!-- icon-bar -->
        <div class="icon-bar">
            <a href="Fantasy_fb.html" target="_blank"><img src="img/fb-icon.png" alt=""></a>
            <a href="Fantasy_ig.html" target="_blank"><img src="img/ig-icon.png" alt=""></a>
        </div>




        <!-- navbar -->
        </a>

        <nav class="navbar navbar-expand-lg navbar-light sticky-top">
            <a class="navbar-brand d-flex align-items-center" href="Fantasyopening.html"><img s src="img/final_fantasy_legends_logo_by_eldi13.png" alt="">Final Fantasy</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mynavbar" aria-controls="mynavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse " id="mynavbar">
                <ul class="navbar-nav m-auto ">
                    <li class="nav-item ">
                        <a class="nav-link " href="#origin_title">Origin</a>
                    </li>
                    <li class="nav-item">
                        <a href="#timeline_title" class="nav-link ">Timeline</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="#character_title">Character</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="#news" >News</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="little_game/littleGame.php?id=<?=$playerId?>"target="_blank" >Games</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="store.php?id=<?=$playerId?>" target="_blank">Store</a>
                    </li>
                    <?php for ($i = 0; $i < count($userName); $i++) { ?>
                        <?php if (@$_POST["userName"] == $userName[$i] && $_POST["passWord"] == $passWord[$i]) { ?>
                    <li id="mbupdate" >
                    <img onclick="show_mb()" src="img/<?=$userPic[$i]?>" alt="">
                    <div class="mbcontant">
                    <img src="img/<?=$userPic[$i]?>" alt="">
                    <h4>偶的名子:<span id="mbName"><?=$userName[$i]?></span></h4>
                    <h5>偶的信箱:<span id="mbMail"><?=$eMail[$i]?></span></h5>
                    <h5 id="modify">修改會員資料</h5>
                    <button class="mb_modify" onclick="modify_content()" >modify</button>
                    </div> 
                    </li>
                            <li id="welText">welcome  <?= $_SESSION["playerName"] ?></li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>

          
            <!-- member-login-content  -->

     
            <form method="post" action="">
                <button type="submit" onclick="showBox()" name="lg_btn" id="lg_btn"><?= $logText ?></button>
            </form>
         
            <div class="member" id="mbid">
                <form class="member-content animate" method="post" action="">
                    <div class="imgcontainer">
                        <span onclick="closeBox()" class="close">&times;</span>
                        <img src="img/ff7-tifa.jpg.png" alt="">
                    </div>
                    <div class="mbcontainer">
                        <label for="uname">UserName</label>
                        <input type="text" id="uname" name="userName" placeholder="Enter Username" required>
                        <label for="psw">Password</label>
                        <input type="password" id="psw" name="passWord" placeholder="Enter Password" required>
                        <p id="errormsg"><?= $errorMsg ?></p>
                        <button type="submit" name="ck_btn" id="ck_btn">Login</button>
                        <label>
                            <input type="checkbox" checked="checked" name="remeber" id="remeber_btn">Remeber
                        </label>
                    </div>
                    <div class="mbcontainer" id="mbcontainer_bottom">
                        <button type="button" onclick="showLgbox()" class="signupbtn ">Sign
                            Up</button>
                        <p class="fgword">Forgot
                            <u onclick="showpswBox()">Password?</u></p>

                    </div>
                </form>
            </div>
        </nav>


        <!-- modify member content -->
<div id="mdfcontent"> 
<div class="wrap_mdfcontent"> 
<span onclick="closeBox()" class="close">&times;</span>
        <div class="wrap_L">
            <form method="post">
            <label for="mdfname">Modify_UserName</label>
            <input type="text" id="mdfname" name="userName3" value="<?= $_SESSION["playerName"]?>">
            <label for="mdfpsw">Modify_Password</label>
            <input type="text" id="mdfpsw" name="passWord3">
            <button type="submit" name="mdf_btn1" id="mdf_btn" onclick="ckMsg()">Check</button>
            </form>
        </div>      
                    
        <div class="wrap_R">
            <form method="post" enctype="multipart/form-data" action="">
             <h3>更換頭貼</h3>
             <input type="file" id="choiceimg" name="imgFile">
             <br>
             <input type="submit" name="up_btn" id="up_btn" value="上傳頭貼" onclick="upMsg()">
            </form>
        </div>
</div>  
</div> 



        <!-- signup_form -->

        <div id="sup" class="signup_form">

            <form class="sup-content an_play" method="post" action="">
                <div class="signup_container">
                    <span onclick="closeBox()" class="close_btn">&times;</span>
                    <h1>Sign Up</h1>
                    <p>Please fill in this form to create an account.</p>
                    <hr>
                    <label for="userName"><b>Username</b><b id= "eroMsg"><?=$errorMsg1?></b></label>
                    <input id="signupbox1" type="text" placeholder="Enter userName" name="userName1" required>

                    <label for="passWord"><b>Password</b></label>
                    <input id="signupbox2" type="text" placeholder="Enter passWord" name="passWord1" required>

                    <label for="eMail"><b>Email</b></label>
                    <input id="signupbox3" type="email" placeholder="Enter Email" name="eMail1" required>

                    <label>
                        <input type="checkbox" checked="checked" name="remember" id="remeber_btn1" style="margin-bottom:15px"> Remember me
                    </label>



                    <div class="form_bottom">
                        <button type="submit" class="signupbtn1 btn-success" name="signUp_btn" onclick="showMsg()">Sign Up</button>
                        <button type="button" onclick="closeBox()" class="cancelbtn">Cancel</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- 按忘記密碼跳出 -->

        <div id="fgpsw" class="fgpsw_contanier an_play">
            <form>
                <div class="item_psw">
                    <h5>輸入E-mail 找回密碼</h5>
                    <span onclick="closeBox()">&times;</span>
                </div>

                <label for="email2"><b>Email</b></label>
                <input id="emailbox" type="email" placeholder="Enter Email" name="email2" required>
                <div class="item_psw2">
                    <input type="submit" value="send" id="send_btn" onclick="send(event)"></div>
            </form>
        </div>

        <!-- slider -->

        <div id="carouselFade" class="carousel slide carousel-fade" data-ride="carousel" data-interval="3800">
            <div class="carousel-inner">
                <ol class="carousel-indicators">
                    <li data-target="carouselFade" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselFade" data-slide-to="1"></li>
                    <li data-target="#carouselFade" data-slide-to="2"></li>
                    <li data-target="#carouselFade" data-slide-to="3"></li>
                </ol>
                <div class="carousel-item active ">
                    <img src="img/FF7-remake.jpg.png">
                </div>
                <div class="carousel-item">
                    <img src="img/FF7-remak-group.png">
                </div>
                <div class="carousel-item">
                    <img src="img/dissidia-ff-1.png">
                </div>
                <div class="carousel-item">
                    <img src="img/FFXV-SP.jpg.png">
                </div>
            </div>
        </div>

        <!-- Jumbotron -->

        <div class="row d-flex justify-content-center" id="Jbcontent">
            <div class="col-xl-6">
                <h1 class="text-warning" id="about_titleup">Final</h1>
                <h1 class="text-warning" id="about_title"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fantasy</h1>
                <p id="main_txt">連上你的份一起活下去</p>
                <p id="main_txtt">我曾是這麼下過決心的</p>
            </div>
            <div class="col-xl-6" id="main_photo">
                <img src="img/cloud-1.png" alt="">
            </div>
        </div>
        <span id="origin_title"></span>
        <br>
        <br>


        <!-- ORIGIN -->

        <div class="row" id="origin">
            <div class="col-xl-5 " id="author_photo">
                <img src="img/author-photo.png" alt="" id="author">
                <img src="img/ff-cuteguys.png" alt="" id="cuteguys">
            </div>

            <div class="col-xl-7 " id="origin_content">
                <h1>Origin</h1>
                <p>當年的小遊戲公司史克威爾（SE社前身）已經在遊戲市場接連虧損，開發許多遊戲都無法得到明確盈利回收，已面臨危機存亡的最後一戰。在這情況，坂口博信便把遊戲取名<strong>「Final
                        Fantasy」《最終幻想》</strong>，意思就是<mark>「最後的夢想」</mark>，當年的RPG大作《勇者鬥惡龍3》甚至預計和《最終幻想》同一個月（1987年12月）發售，可說是個絕望至極的狀態，沒想到後來勇鬥3延期，並且在遊戲發售之後，《最終幻想》在玩家之間獲得了相當不錯的評價。
                </p>
            </div>
        </div>
        <span id="timeline_title"></span>
        <br>
        <br>


        <!-- Timeline of release years -->

        <div class="row" id="timeline">

            <div class="col-5" id="timeline_table">
                <div id="years" class="list-group">
                    <a class="list-group-item list-group-item-action" href="#list-item-1">Final Fantasy</a>
                    <a class="list-group-item list-group-item-action" href="#list-item-2">Final Fantasy II</a>
                    <a class="list-group-item list-group-item-action" href="#list-item-3">Final Fantasy III</a>
                    <a class="list-group-item list-group-item-action" href="#list-item-4">Final Fantasy IIII</a>
                    <a class="list-group-item list-group-item-action" href="#list-item-5">Final Fantasy IV</a>
                    <a class="list-group-item list-group-item-action" href="#list-item-6">Final Fantasy VI</a>
                    <a class="list-group-item list-group-item-action" href="#list-item-7">Final Fantasy VII</a>
                    <a class="list-group-item list-group-item-action" href="#list-item-8">Final Fantasy VIII</a>
                    <a class="list-group-item list-group-item-action" href="#list-item-9">Final Fantasy IX</a>
                    <a class="list-group-item list-group-item-action" href="#list-item-10">Final Fantasy X</a>
                    <a class="list-group-item list-group-item-action" href="#list-item-11">Final Fantasy XI</a>
                    <a class="list-group-item list-group-item-action" href="#list-item-12">Final Fantasy XII</a>
                    <a class="list-group-item list-group-item-action" href="#list-item-13">Final Fantasy XIII</a>
                    <a class="list-group-item list-group-item-action" href="#list-item-14">Final Fantasy XIV</a>
                    <a class="list-group-item list-group-item-action" href="#list-item-15">Final Fantasy XV</a>
                </div>
            </div>

            <!-- scrollspy of  release years -->

            <div class="col-7 text-center">
                <div data-spy="scroll" data-target="#years" data-offset="0" class="scrollspy text-center text-white">
                    <h1>Timeline of release years</h1>
                    <h4 id="list-item-1">1987/12/8</h4>
                    <img src="img/FF1.JPG.png">

                    <h4 id="list-item-2">1988/12/17</h4>
                    <img src="img/FF2.JPG.png">

                    <h4 id="list-item-3">1990/4/27</h4>
                    <img src="img/FF3.JPG.png">

                    <h4 id="list-item-4">1991/7/19</h4>
                    <img src="img/FF4.JPG.png">

                    <h4 id="list-item-5">1992/12/6</h4>
                    <img src="img/FF5.JPG.png">

                    <h4 id="list-item-6">1994/4/2</h4>
                    <img src="img/FF6.JPG.png">

                    <h4 id="list-item-7">1997/1/31</h4>
                    <img src="img/FF7.JPG.png">

                    <h4 id="list-item-8">1999/2/21</h4>
                    <img src="img/FF8.JPG.png">

                    <h4 id="list-item-9">2000/7/22</h4>
                    <img src="img/FF9.JPG.png">

                    <h4 id="list-item-10">2001/7/19</h4>
                    <img src="img/FF10.JPG.png">

                    <h4 id="list-item-11">2002/11/17</h4>
                    <img src="img/FF11.JPG.png">

                    <h4 id="list-item-12">2006/3/16</h4>
                    <img src="img/FF12.JPG.png">

                    <h4 id="list-item-13">2009/12/17</h4>
                    <img src="img/FF13.JPG.png">

                    <h4 id="list-item-14">2010/9/30</h4>
                    <img src="img/FF14.JPG.png">

                    <h4 id="list-item-15">2016/9/30</h4>
                    <img src="img/FF15.JPG.png">
                </div>
            </div>
        </div>
        <span id="character_title"></span>
        <br>
        <br>
        <!-- Character -->
        <div class="row" id="character">
            <div class="col-sm-6" id="Character_L">
                <img src="img/actor_bg.png">
            </div>
            <div class="col-sm-6" id="actor_photo">
                <h1>Main Actor</h1>
                <div class="item">
                    <input type="radio" id="FF_actor1_btn" name="actorimg">
                    <label for="FF_actor1_btn">
                        <img src="img/FF1_actor.JPG.png" id="FF_actor1"></label>
                    <div class="card" id="main_actor1">
                        <img src="img/FF1bigphoto.png" class="card-img-top1" alt="...">
                        <div class="card-body">
                            <p class="card-text">
                                <strong>光之戰士</strong> 高貴的戰士，無所畏懼，直面任何強敵。光之戰士揮舞長劍，舉起盾牌黑暗無所遁形。擅長中距離戰鬥。在曾經的戰鬥中，作為女神忠實的騎士而戰鬥活躍，終將重拾光芒，拯救世界。劍技是他的特長。配合著盾使用的攻防一體攻擊也很擅長。擁有很多實用的技能，在攻防兩方面都很優秀。實力也很強，正所謂是英雄一般的人物。但他也是嚴以律己、嚴以待人的頑固人物，可以說是真正的主角，是個讓人覺得可以把世界交付給他的勇者。在遊戲中以調和之神方的中心人物身份活躍。在原作中，為救助被奪走的科尼利亞王國的公主塞拉，同時也是為了拯救這個被黑暗籠罩的世界而踏上了旅途。不僅能使用劍，連盾牌也可以當武器使用。是個在各方面都很均衡的角色。
                            </p>
                        </div>
                    </div>
                    <input type="radio" id="FF_actor2_btn" name="actorimg">
                    <label for="FF_actor2_btn">
                        <img src="img/FF2_actor.JPG.png" id="FF_actor2"></label>
                    <div class="card" id="main_actor2">
                        <img src="img/FF2bigphoto.png" class="card-img-top1" alt="...">
                        <div class="card-body">
                            <p class="card-text">
                                <strong>菲力歐尼爾</strong> 留著白色長髮尾，灰色眼睛，穿著披風和輕便的盔甲的冷靜青年，有著很強的正義感。為了將戰爭和暴政驅逐建立自由的時間而奮鬥，武器種類奇多，可以使用諸多武器組合技。 劍、槍、弓、小刀、杖之類的武器統統都能熟練使用的年輕人。是富有正義感，鬥志昂揚的少年。相對於空戰而言，更擅長陸地戰鬥。在陸戰中可以使用各種各樣的武器。目標專一而且很認真。劇情跟提達有所關聯。“如果在空中也能將他運用自如，才可以說是真正的菲力歐尼爾的使用者。”在原作中，出生于菲因王國，在自己王國遭受巴拉麥齊亞王國襲擊時，養父母都被殺害，自己也差點死亡。從那以後，下定了決心和夥伴們一起加入了反叛軍的行列。
                            </p>
                        </div>
                    </div>
                    <input type="radio" id="FF_actor3_btn" name="actorimg">
                    <label for="FF_actor3_btn">
                        <img src="img/FF3_actor.JPG.png" id="FF_actor3"></label>
                    <div class="card" id="main_actor3">
                        <img src="img/FF3bigphoto.png" class="card-img-top1" alt="...">
                        <div class="card-body">
                            <p class="card-text">
                                <strong>洋蔥劍士</strong> 被稱為“洋蔥劍士”的少年。體型雖小，但是行動起來卻非常迅速。能夠自由操縱魔法和劍技。是個容易使用的角色。在劇情方面，有著相當具衝擊性的事件，性格上是有一些耍嘴皮子的部分，但是卻不會讓人討厭。“在大部分都是大人的登場角色中，可以從這位少年洋蔥劍士的身上看見成長的故事。”在原作中，跑到因大地震而沉入地底的水晶遺跡去遊玩，陷入了水晶的祭壇，被風之水晶選中，從此背負上光之戰士的使命。如風一樣的神速，能迅速回避敵人的攻擊。並追加絲毫不給敵人喘息機會的攻擊。
                            </p>
                        </div>
                    </div>
                    <input type="radio" id="FF_actor4_btn" name="actorimg">
                    <label for="FF_actor4_btn">
                        <img src="img/FF4_actor.JPG.png" id="FF_actor4"></label>
                    <div class="card" id="main_actor4">
                        <img src="img/FF4bigphoto.png" class="card-img-top1" alt="...">
                        <div class="card-body">
                            <p class="card-text">
                                <strong>塞西爾•哈威</strong> 可以同時運用黑暗和光明的力量，不論是劍術還是空中打擊都非常擅長。無論是近距離還是遠端作戰，空中的戰鬥同樣不在話下。巴倫國王培養的擁有強大暗黑力量的暗黑騎士，赤翼空軍的指揮官。全身暗黑裝備，雖不會使用魔法，但其武器暗黑劍中，死亡啟示劍的即死追加效果非常強悍。當他得知自身的暗黑力量無法戰勝現存的邪惡，不顧生命危險，踏著無數追求聖騎士職業的先烈的骸骨，毅然登上試練之山，努力轉職為聖騎士。塞西爾擅長空中作戰，能夠以快速的行動釋放出華麗的劍技。在原作中，為了與被詛咒的暗黑之力訣別，登上了試煉之山，通過試煉後被授予了聖騎士身份的稱號。得到了暗黑之力，變身為暗黑騎士的塞西爾。擅長陸地戰，擁有很高的攻擊力。在原作中，指揮巴倫的飛空艇團“赤翼”，雖然很苦惱但卻遵從著國王不合理的命令。為了告別被詛咒的黑暗之力，塞西爾向著試煉之山進發。雖然在原作中無法從聖騎士變回暗黑騎士，但本作讓兩個角色可以往復變化，從而顯出特色。在調和之神方，他算是比較有特色的人物。暗黑騎士擅長陸地戰，而聖騎士拿手的是空中戰。
                            </p>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <input type="radio" id="FF_actor5_btn" name="actorimg">
                    <label for="FF_actor5_btn">
                        <img src="img/FF5_actor.JPG.png" id="FF_actor5"></label>
                    <div class="card" id="main_actor5">
                        <img src="img/FF5bigphoto.png" class="card-img-top1" alt="...">
                        <div class="card-body">
                            <p class="card-text">
                                <strong>巴茲•克勞薩</strong> 維護正義的鬥士，同樣也是一位勇敢的年輕人，使用的技能次數越多，攻擊力越強。原作中是一個騎著陸行鳥四處冒險的流浪者，繼承了父親一身好武藝，四處打抱不平，有著很強的正義感，在旅行的途中，偶爾遇到了法裡斯、蕾娜，古露露等其他幾位主角，從此開始了命運中註定的旅程。是光之四戰士之一。正義感很強，並且擁有著勇敢之心的少年。有著能把秩序一方所有戰士的劍技結合起來作戰的能力。在原作中，遵守父親的遺言，在和夥伴“波古”一起旅行世界的時候，在偶然發現的隕石落下現場遇到了公主蕾娜，從此他的旅行便和水晶聯繫到了一起。能使用各種武器的全才角色，也可以使用魔法。
                        </div>
                    </div>
                    <input type="radio" id="FF_actor6_btn" name="actorimg">
                    <label for="FF_actor6_btn">
                        <img src="img/FF6_actor.JPG.png" id="FF_actor6"></label>
                    <div class="card" id="main_actor6">
                        <img src="img/FF6bigphoto.png" class="card-img-top1" alt="...">
                        <div class="card-body">
                            <p class="card-text">
                                <strong>蒂娜</strong> 能夠操縱魔導之力的少女。擁有強大的魔法之力和幻獸之力。攻擊方式雖然以魔法為主，同時也有著能進行遠距離和近距離攻擊的可能。在原作中，生來就具有魔導之力，因此被敵對的葛斯特拉帝國所利用。在煤礦都市奈爾謝與幻獸進行心靈溝通時逃離了帝國的支配，和偶然遇到的洛克一起加入了反帝國組織，從此終於為決定世界存亡與否而戰鬥。使用近距離或遠距離的魔法來進行攻擊。
                        </div>
                    </div>
                    <input type="radio" id="FF_actor7_btn" name="actorimg">
                    <label for="FF_actor7_btn">
                        <img src="img/FF7_actor.JPG.png" id="FF_actor7"></label>
                    <div class="card" id="main_actor7">
                        <img src="img/FF7bigphoto.png" class="card-img-top1" alt="...">
                        <div class="card-body">
                            <p class="card-text">
                                <strong>克勞德</strong> 是個有著藍色雙瞳，目光鎮靜銳利的劍士。使用著一把幾乎與他的身高相同的大劍，其威力甚至能把對手震飛。在原作中，和反神羅組織“雪崩”一起工作，最終與同伴一起走上了守護星的旅程。他一直憧憬著的傳說中的戰士，薩菲羅斯，竟燒毀了他的故鄉。因此，他把薩菲羅斯當成了宿命的對手一直在追尋他。可使用一擊具有超強威力的劍技，可以用他來實現Brave Break。
                            </p>
                        </div>
                    </div>
                    <input type="radio" id="FF_actor8_btn" name="actorimg">
                    <label for="FF_actor8_btn">
                        <img src="img/FF8_actor.JPG.png" id="FF_actor8"></label>
                    <div class="card" id="main_actor8">
                        <img src="img/FF8bigphoto.png" class="card-img-top1" alt="...">
                        <div class="card-body">
                            <p class="card-text">
                                <strong>斯考爾</strong> 使用難以操縱的槍刃，有著出類拔萃的戰鬥資質。雖然被認為是最有資格的候補及格者，但是由於他那種若即若離的態度，以及不愛說話、冷漠、不善交際的性格，使他被當成學園問題學生之一。雖然他對別人漠不關心且排斥，但是在學園裡卻吸引了不少人的目光。斯考爾使用一種名為“槍刃”的特殊武器，感情很冷漠，對其他人的事漠不關心，是個沉默的青年。在原作中，屬於士兵培育學校“巴藍姆學園”的特殊部隊SEED的一員。在慶功舞會上認識了莉諾雅，受她雇傭而加入了“森林貓頭鷹”組織。因為和她在一起，所以斯考爾的命運發生了很大的轉折。很容易得到連擊點數，用他可以與敵人進行近距離作戰。
                            </p>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <input type="radio" id="FF_actor9_btn" name="actorimg">
                    <label for="FF_actor9_btn">
                        <img src="img/FF9_actor.JPG.png" id="FF_actor9"></label>
                    <div class="card" id="main_actor9">
                        <img src="img/FF9bigphoto.png" class="card-img-top1" alt="...">
                        <div class="card-body">
                            <p class="card-text">
                                <strong>吉坦</strong> 少年的美貌和魅力使他獲得了相當可觀的成就，對待朋友總是有求必應，寬宏大量。他的精力、優雅和敏銳的機智在戰鬥中尤其是在半空中戰鬥幫助非常大。行動力和判斷力都很優越，正義感十足但是只要看見漂亮女孩就走不動路的16歲少年。在原作中，作為旅行演出，同時暗地裡是盜賊團的組織“坦特拉斯”的一員。在演出中綁架了公主嘉妮特，並被她強烈吸引，從而決定要幫助她。在旅行過程中吉坦一行人陷入了保衛自己生活的星球—蓋亞的紛爭中。在調和之神方，他總是扮演著讓大家輕鬆下來的角色。行動迅速，戰鬥時身手很靈活。包括空戰在內的所有戰鬥都很擅長。
                            </p>
                        </div>
                    </div>
                    <input type="radio" id="FF_actor10_btn" name="actorimg">
                    <label for="FF_actor10_btn">
                        <img src="img/FF10_actor.JPG.png" id="FF_actor10"></label>
                    <div class="card" id="main_actor10">
                        <img src="img/FF10bigphoto.png" class="card-img-top1" alt="...">
                        <div class="card-body">
                            <p class="card-text">
                                <strong>提達</strong> 出生于紮那魯甘多的開朗活潑的少年。是閃電球選手，有著“紮那魯甘多之帝”之稱的明星。在原作中，受到魔物“辛”的攻擊來到了異世界斯派拉，在那裡遇到了召喚士少女尤娜並和她一起行動。攻擊力和速度都在平均水準之上的全能角色。非常容易操作！
                            </p>
                        </div>
                    </div>
                    <input type="radio" id="FF_actor11_btn" name="actorimg">
                    <label for="FF_actor11_btn">
                        <img src="img/FF11_actor.JPG.png" id="FF_actor11"></label>
                    <div class="card" id="main_actor11">
                        <img src="img/FF11bigphoto.png" class="card-img-top1" alt="...">
                        <div class="card-body">
                            <p class="card-text">
                                <strong>夏托托</strong> 夏托托有著可愛少女的外貌，但實際上是個天才魔導士。性格極為任性。在原作FFXI裡，夏托托是從溫塔斯來的著名魔導士，代表著魔法國家溫塔斯的“三博士”中的一人。在大戰爭中立下了豐功偉績，被稱為英雄。作為紛爭•最終幻想的嘉賓，她在遊戲開始時是無法使用的，只有達成了嚴格的條件之後，她才會出現！難不成和宇宙有什麼關係嗎？因為是和調和之神COSMOS同行的，難道其出現的條件是和光之戰士有關？在這次的紛爭中，她會有什麼實力展現呢？能夠輕鬆使用強力魔法！高級魔法發動，與畫面下的“勇氣指數”的量對應，魔法的威力也會相應地提升！
                            </p>
                        </div>
                    </div>
                    <input type="radio" id="FF_actor12_btn" name="actorimg">
                    <label for="FF_actor12_btn">
                        <img src="img/FF12_actor.JPG.png" id="FF_actor12"></label>
                    <div class="card" id="main_actor12">
                        <img src="img/FF12bigphoto.png" class="card-img-top1" alt="...">
                        <div class="card-body">
                            <p class="card-text">
                                <strong>梵</strong> 渴望自由，憧憬天空的少年。因為帝國的侵略，Vaan失去了唯一的親人—年長他兩歲的兄長Reks。Vaan現在生活在帝國佔領下的Dalmasca王國的Downtown中。以開朗積極的性格，夢想成為自由翱翔於天空的空賊。計畫驚嚇Archadia軍新執政官Vayne和盜取寶物而侵入居城的Vaan，雖然盜取了寶物魔石卻遭遇了打算搶奪寶物的Balflear和Fran。在知道他們是空賊之後，Vaan成為了他們的同伴。與此同時，反抗帝國的舊Dalmasca王國的抵抗運動攻入城中，在水路中Vaan遇到了下落不明的王女Ashe，將其救下並與Ashe等人一起逃脫了。從此，厭倦了平凡的生活，憧憬冒險的少年，以這意想不到的事情為契機，與各種各樣的人相遇，開始了在世界上的冒險。與這些人的相遇，他的命運也開始發生重大的改變。夢想雖然遠大，但他擁有足夠實現夢想的實力、才智和行動力，表情中雖然還留有天真，但他的眼睛一直嚮往著未來。以與Ashe的相遇為契機，Vaan被捲入了左右國家命運的洪流之中。與各種各樣的人相遇，逐漸成長。
                            </p>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <input type="radio" id="FF_actor13_btn" name="actorimg">
                    <label for="FF_actor13_btn">
                        <img src="img/FF13_actor.JPG.png" id="FF_actor13"></label>
                    <div class="card" id="main_actor13">
                        <img src="img/FF13bigphoto.png" class="card-img-top1" alt="...">
                        <div class="card-body">
                            <p class="card-text">
                                <strong>雷霆</strong> “雷霆”並非是她的真名，而是代號。年少時，因為雙親過世，她與妹妹塞拉相依為命。為了依靠自己的力量守護塞拉，自視為“成年人”的她捨棄了原名，雷霆成為了她新的名字。原本是聖府軍中有一定地位的軍人，但為了保護被水晶選中成為路西的塞拉，與聖府為敵，同時自己也變成了路西。雷霆是個嚴厲的人，也許這也跟她曾經的軍人身份有關，待人嚴格，對對手從不姑息仁慈。同樣，雷霆對自己也要求十分嚴格。不過，雷霆內心也存在著堅韌與溫柔，只是誰也沒能見過她嚴厲之外的另一面。雷霆使用的武器，是具有變形能力的劍與銃的組合，這套裝備本來是聖府軍方的量產品，但她所使用是有著特別銘記的產品。除了劍術與射擊術外，雷霆還會使用魔法操縱重力，但這個技能不是什麼時候都可以使用的。雷霆是一名擅長于戰鬥的專家。
                            </p>
                        </div>
                    </div>
                    <input type="radio" id="FF_actor14_btn" name="actorimg">
                    <label for="FF_actor14_btn">
                        <img src="img/FF14_actor.JPG.png" id="FF_actor14"></label>
                    <div class="card" id="main_actor14">
                        <img src="img/FF14bigphoto.png" class="card-img-top1" alt="...">
                        <div class="card-body">
                            <p class="card-text">
                                <strong>shtola</strong> 遠距離攻擊的王者。
                            </p>
                        </div>
                    </div>
                    <input type="radio" id="FF_actor15_btn" name="actorimg">
                    <label for="FF_actor15_btn">
                        <img src="img/FF15_actor.JPG.png" id="FF_actor15"></label>
                    <div class="card" id="main_actor15">
                        <img src="img/FF15bigphoto.png" class="card-img-top1" alt="...">
                        <div class="card-body">
                            <p class="card-text">
                                <strong>諾克提斯•路西斯•伽拉姆</strong> 在遊戲中路西斯王國的下一任國王，也是最後一位君王。外表個性冷靜，內在也有著熱血的一面，因感情的變化可召喚六神，眼睛的顏色也會有所改變（瞳孔從藍色變為紅色）。右手戴著的戒指是唯一的裝飾品。基本戰鬥力高，根據水晶的力量操縱多種武器，但都以劍為主要武器。
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- RWD女孩兒照片 -->

        <div class="col-12" id="actress_title">
            <h1>Actress</h1>
        </div>
        <div class="col" id="actress_photo">
            <div class="item">
                <img src="img/FF1little-girl.png">
                <img src="img/FF2little-girl.png">
                <img src="img/FF3little-girl.png">
                <img src="img/FF4little-girl.png">

            </div>
            <div class="item">
                <img src="img/FF6little-girl.png">
                <img src="img/FF7littleAerith.png">
                <img src="img/FF7little-tifa.png">
                <img src="img/FF8little-girl.png">

            </div>
            <div class="item">
                <img src="img/FF9little-girl.png">
                <img src="img/FF10little-girl.png">
                <img src="img/FF11little-girl.png">
                <img src="img/FF12little-girl.png">

            </div>
            <div class="item">
                <img src="img/FF13little-girl.png">
                <img src="img/FF14little-girl.png">
                <img src="img/FF15little-girl.png">

            </div>
        </div>

        <!-- girlcard -->

        <div class="col-12">
            <div class="main_actress">
                <div class="cardgirl" style="width:20rem;" id="content1">
                    <img src="img/ff1-girl.JPG.png" class="cardgirl-img-top" alt="...">
                    <div class="cardgirl-body">
                        <p class="cardgirl-text text-center">Ai Lei</p>
                    </div>
                </div>
                <div class="cardgirl" style="width:20rem;" id="content2">
                    <img src="img/ff2-girl.JPG.png" class="cardgirl-img-top" alt="...">
                    <div class="cardgirl-body">
                        <p class="cardgirl-text text-center">Maria</p>
                    </div>
                </div>
                <div class="cardgirl" style="width:20rem;" id="content3">
                    <img src="img/ff3-girl.JPG.png" class="cardgirl-img-top" alt="...">
                    <div class="cardgirl-body">
                        <p class="cardgirl-text text-center">Lefiya</p>
                    </div>
                </div>
                <div class="cardgirl" style="width:20rem;" id="content4">
                    <img src="img/ff4-girl.JPG.png" class="cardgirl-img-top" alt="...">
                    <div class="cardgirl-body">
                        <p class="cardgirl-text text-center">Rosa Farrell</p>
                    </div>
                </div>
                <div class="cardgirl" style="width:20rem;" id="content5">
                    <img src="img/ff6-girl.JPG.png" class="cardgirl-img-top" alt="...">
                    <div class="cardgirl-body">
                        <p class="cardgirl-text text-center">Tina</p>
                    </div>
                </div>
                <div class="cardgirl" style="width:20rem;" id="content6">
                    <img src="img/ff7-Aerith.JPG.png" class="cardgirl-img-top" alt="...">
                    <div class="cardgirl-body">
                        <p class="cardgirl-text text-center">Aeris</p>
                    </div>
                </div>
                <div class="cardgirl" style="width:20rem;" id="content7">
                    <img src="img/ff7-tifa.jpg.png" class="cardgirl-img-top" alt="...">
                    <div class="cardgirl-body">
                        <p class="cardgirl-text text-center">Tifa</p>
                    </div>
                </div>
                <div class="cardgirl" style="width:20rem;" id="content8">
                    <img src="img/ff8-girl.JPG.png" class="cardgirl-img-top" alt="...">
                    <div class="cardgirl-body">
                        <p class="cardgirl-text text-center">Rinoa</p>
                    </div>
                </div>
                <div class="cardgirl" style="width:20rem;" id="content9">
                    <img src="img/ff9-girl.JPG.png" class="cardgirl-img-top" alt="...">
                    <div class="cardgirl-body">
                        <p class="cardgirl-text text-center">Garnet</p>
                    </div>
                </div>
                <div class="cardgirl" style="width:20rem;" id="content10">
                    <img src="img/ff10-girl.JPG.png" class="cardgirl-img-top" alt="...">
                    <div class="cardgirl-body">
                        <p class="cardgirl-text text-center">Yuna</p>
                    </div>
                </div>
                <div class="cardgirl" style="width:20rem;" id="content11">
                    <img src="img/ff11-girl.JPG.png" class="cardgirl-img-top" alt="...">
                    <div class="cardgirl-body">
                        <p class="cardgirl-text text-center">Shantotto</p>
                    </div>
                </div>
                <div class="cardgirl" style="width:20rem;" id="content12">
                    <img src="img/ff12-girl.JPG.png" class="cardgirl-img-top" alt="...">
                    <div class="cardgirl-body">
                        <p class="cardgirl-text text-center">Ashe</p>
                    </div>
                </div>
                <div class="cardgirl" style="width:20rem;" id="content13">
                    <img src="img/ff13-girl.JPG.png" class="cardgirl-img-top" alt="...">
                    <div class="cardgirl-body">
                        <p class="cardgirl-text text-center">Lightning</p>
                    </div>
                </div>
                <div class="cardgirl" style="width:20rem;" id="content14">
                    <img src="img/ff14-girl.JPG.png" class="cardgirl-img-top" alt="...">
                    <div class="cardgirl-body">
                        <p class="cardgirl-text text-center">Miffelia</p>
                    </div>
                </div>
                <div class="cardgirl" style="width:20rem;" id="content15">
                    <img src="img/ff15-girl.JPG.png" class="cardgirl-img-top" alt="...">
                    <div class="cardgirl-body">
                        <p class="cardgirl-text text-center">Stella</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- News -->
        <div class="row" id="news">
            <div class="col-xl-6" id="news_photo">
                <img src="img/news-Buster Sword.JPG.png" alt="">
                <img src="img/news-ff7remake.JPG.png" alt="">
                <img src="img/news-ffcrystal.JPG.png" alt="">
                <img src="img/news-ffdissidia.jpg.png" alt="">
                <img src="img/news-girlgp.JPG.png" alt="">
                <img src="img/news-tifa.JPG.png" alt="">
            </div>
            <div class="col-xl-6" id="news_content">
                <h1>News</h1>
                <table>
                    <tr>
                        <td><b>2023-12-25</b> Final Fanrasy XXXV Remake 將釋出最新中文版預告...
                            <button type="button" class="btn btn-outline-secondary text-white" data-toggle="collapse" data-target="#contant1">view more</button>
                            <div id="contant1" class="collapse text-warning">
                                由日本 Square Enix 預定於 2023 年 12 月推出，身為目前發售中人氣 RPG《Final Fantasy XXXV Remake》最新大型 DLC，以遊戲中登場的帝國宰相為主的前日譚「艾汀篇」（Episode Ardyn／エピソード アーデン），官方特地公開最新宣傳影片讓玩家們搶先確認！
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><b>2023-12-22</b> 歷代女主最美排行，誰是你心目中的最美女神...
                            <button type="button" class="btn btn-outline-secondary text-white" data-toggle="collapse" data-target="#contant2">view more</button>
                            <div id="contant2" class="collapse text-warning">
                                最終幻想15將會在本月29日發行，說到最終幻想這部系列遊戲，可以說年代也是很久了，裡面也出現了很多那些讓人記憶猶新的女性角色，今天我們就來各個的說一下，你最鍾情哪一個呢？
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><b>2021-7-7</b> 破壞劍3主人，背後的感人故事...
                            <button type="button" class="btn btn-outline-secondary text-white" data-toggle="collapse" data-target="#contant3">view more</button>
                            <div id="contant3" class="collapse text-warning">
                                你知道破壞大劍背後隱藏的感人故事嗎?克勞德+札克斯+安吉爾深度解析
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><b>2020-7-23</b>《Final Fantasy XIV》更新 5.3「水晶的殘光」預告片公開...
                            <button type="button" class="btn btn-outline-secondary text-white" data-toggle="collapse" data-target="#contant4">view more</button>
                            <div id="contant4" class="collapse text-warning">
                                SQUARE ENIX 在公開 PlayStation 4 / Windows / Mac 平台 MMORPG《Final Fantasy XIV》最新更新的「第 59 回 FFXIV Producer Letter LIVE」節目中，釋出了更新 5.3「水晶的殘光」預告片。
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><b>2020-2-7</b> 《Final Fantasy VII 重製版》釋出最新主視覺插畫...
                            <button type="button" class="btn btn-outline-secondary text-white" data-toggle="collapse" data-target="#contant6">view more</button>
                            <div id="contant6" class="collapse text-warning">
                                SQUARE ENIX 旗下《Final Fantasy VII 重製版》將於4月10正式發行，由於之前發售日延期的關係，PS4版的獨佔日期也確定跟著延到隔年的4月10日，所以想玩PC版的朋友可能也要再等待一下了。官方在今日釋出了最新的主視覺插畫，以及由植松伸夫作曲、野島一成作詞之主題曲「Hollow」的中文版幕後花絮。
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><b>2019-6-25</b> 《Dissidia Final Fantasy》人氣女主「蒂法」以犀利拳腳制裁黑暗勢力
                            <button type="button" class="btn btn-outline-secondary text-white" data-toggle="collapse" data-target="#contant5">view more</button>
                            <div id="contant5" class="collapse text-warning">
                                SQUARE ENIX 今（25）日在大型電玩線上團隊對戰動作遊戲《Dissidia Final Fantasy》6 月更新情報直播節目中，宣布來自《Final Fantasy VII》的人氣格鬥少女「蒂法‧洛克哈特（Tifa Lockhart）」將於 6 月 27 日正式參戰的消息，PS4 / PC 家用版則預定於 7 月 3 日更新
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Games -->









    </div>

    <script src="js/Fantasy.js"></script>

</body>

</html>