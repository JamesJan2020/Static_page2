<?php
require_once("dbconnect.php");
session_start();
$playerId ="Guest";
@$result = mysqli_query($link, "select * from member
where playerId ='{$_SESSION["playerID"]}'");
$row = mysqli_fetch_assoc($result);
@$playerId=$row["playerId"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/final_fantasy_legends_logo_by_eldi13.png" type="image/gif" sizes="16x16">
    <title>Little Game</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/lg.css">
    <link rel="stylesheet" href="css/Final.css">

</head>

<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light sticky-top">
            <a class="navbar-brand d-flex align-items-center" href="../Fantasy.php"><img s src="img/final_fantasy_legends_logo_by_eldi13.png" alt="">Final Fantasy</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mynavbar" aria-controls="mynavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse " id="mynavbar">
                <ul class="navbar-nav m-auto ">
                    <li class="nav-item ">
                        <a class="nav-link " href="../Fantasy.php#origin_title">Origin</a>
                    </li>
                    <li class="nav-item">
                        <a href="../Fantasy.php#timeline_title" class="nav-link ">Timeline</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="../Fantasy.php#character_title">Character</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="../Fantasy.php#news">News</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Games</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../store.php?id=<?=$playerId?>" target="_blank">Store</a>
                    </li>
                    
                    <?php if($playerId!=NULL){ ?>
                    <li id="welText">welcome【<?= @$row["userName"] ?>】</li>
                    <?php }?>
        </nav>


        <div id="msgitem1"><img src="img/cry.PNG" alt="">
            <span id="close_btn">&times;</span>
            <h3>'Σ(￣□￣ 不是你的錯 都是滑鼠壞壞'</h3>
        </div>
        <div id="msgitem2"><img src="img/good.PNG" alt="">
            <span id="close_btn">&times;</span>
            <h3>'酷哦! 可以哦!★‧\(￣▽￣)/‧°★*'</h3>
        </div>
        <div id="msgitem3">
            <span id="close_btn">&times;</span>
            <img src="img/gamesrc .PNG" alt="">
        </div>


        <div class="container">
            <div class="wrap_top">
                <div id="item_top_L">
                    <div id="bag1" onmousedown="divMouseDown(event)" onmouseup="divMouseUp(event)"><img id="cuteguys1" src="img/ff-cuteguys.png" alt="">
                    </div>
                    <div id="bag2" onmousedown="divMouseDown(event)" onmouseup="divMouseUp(event)"><img id="cuteguys2" src="img/FF-mogole.png" alt="">
                    </div>
                    <div id="bag3" onmousedown="divMouseDown(event)" onmouseup="divMouseUp(event)"><img id="cuteguys3" src="img/picu.gif" alt="">
                    </div>
                </div>
                <pre></pre>
                    <div id="item_top_R">
                        <p>剩餘時間:</p>
                        <p id="timer"></p>
                        <p>食指指力:</p>
                        <p id="score" name="score"></p>
                        <p>中原超標準時間:</p>
                        <p id="nowTime"></p>
                        <img id="showrule" name="showrule"onclick="ruleMsg()" src="img/Chocobo.jpg" alt="">
                    </div>
            </div>

            <div class="wrap_bottom">
                <div id="item3">
                    <button id="startGames" onclick="startGame()">Start</button>

                </div>
            </div>

        </div>


        <script src="js/Fantasy.js"></script>
        <script src="js/lg_one.js"></script>
</body>

</html>