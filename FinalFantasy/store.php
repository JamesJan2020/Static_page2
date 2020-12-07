<?php
require_once("dbconnect.php");
session_start();
//如有登入跳轉到會員登入頁面
$playerId = "Guest";
@$result = mysqli_query($link, "select * from member
where playerId ='{$_SESSION["playerID"]}'");
$row = mysqli_fetch_assoc($result);
@$playerId = $row["playerId"];

//熱門商品
$picture = [];
$productsName = [];
$price = [];

$hot_pd = <<< hotcontent
SELECT * FROM store 

hotcontent;

$result1 = mysqli_query($link, $hot_pd);

while ($row2 = mysqli_fetch_assoc($result1)) {
    $picture[count($picture)] = $row2["picture"];
    $productsName[count($productsName)] = $row2["productsName"];
    $price[count($price)] = $row2["price"];
}


//購買商品
for($i=0;$i<9;$i++){
    if (isset($_POST["ck_btn$i"])&&$playerId!=NULL&&isset($_POST["chkbuy_btn"])){
              $bplist = <<<bplistText
              insert into store(productsName,price,picture,playerId,update_time) 
              values('{$productsName[$i]}',
              '{$price[$i]}',
              '{$picture[$i]}',
              '{$playerId}',
                    NOW());
              bplistText;
              mysqli_query($link, $bplist);
              
        
        }   
    }



//購買紀錄
$bl_history = <<< history
SELECT * FROM store 

WHERE playerId= $playerId

history;

$result3 = mysqli_query($link, $bl_history);


mysqli_close($link);


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
    <link rel="stylesheet" href="css/store.css">
    <title>Final_Fantasy</title>
        <style>
       
    </style>


</head>

<body data-spy="scroll" data-target="#mynavbar" data-offset="0">

    <div class="container-fluid">

        <!-- navbar -->
        <nav class="navbar navbar-expand-lg navbar-light sticky-top">
            <a class="navbar-brand d-flex align-items-center" href="Fantasy.php"><img src="img/final_fantasy_legends_logo_by_eldi13.png" alt="">Final Fantasy</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mynavbar" aria-controls="mynavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse " id="mynavbar">
                <ul class="navbar-nav m-auto ">
                    <li class="nav-item ">
                        <a class="nav-link " href="Fantasy.php#origin_title">Origin</a>
                    </li>
                    <li class="nav-item">
                        <a href="Fantasy.php#timeline_title" class="nav-link ">Timeline</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="Fantasy.php#character_title">Character</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="Fantasy.php#news">News</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="little_game/littleGame.php?id=<?= $playerId ?>" target="_blank">Games</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="store.php?id=<?= $playerId ?>">Store</a>
                    </li>
                    <?php if($playerId!=NULL){ ?>
                    <li id="welText">welcome【 <?= @$row["userName"] ?>】</li>
                    <?php }?>
                </ul>
            </div>
        </nav>
        

        <div class="container">
            <form action="" method="post">
                <div class="content_L">
                    <h1>熱門商品</h1>
                    <div class="wrap">
                        <?php for ($i = 0; $i < 3; $i++) { ?>
                            <div class="item">
                                <img src="img/<?= $picture[$i] ?>">
                                <h4><?= $productsName[$i] ?></h4>
                                <p>價格:<?= $price[$i] ?>$</p><button type="button" id="buy_btn" name="buy_btn<?= $i + 1 ?>">加入試算</button>
                                <input type="checkbox" id="ckbb<?= $i?>" name="ck_btn<?= $i?>" value="ck_btn<?= $i?>"><label for="ckbb<?= $i?>" id="spcart"><img src="img/shopcart.png" alt=""></label>
                            </div>
                        <?php  } ?>
                    </div>
                    <div class="wrap">
                        <?php for ($i = 3; $i < 6; $i++) { ?>
                            <div class="item">
                                <img src="img/<?= $picture[$i] ?>">
                                <h4><?= $productsName[$i] ?></h4>
                                <p>價格:<?= $price[$i] ?>$</p>
                                <button type="button" id="buy_btn" name="buy_btn<?= $i + 1 ?>">加入試算</button>
                                <input type="checkbox" name="ck_btn<?= $i?>" value="ck_btn<?= $i?>">
                                <label for="ckbb<?= $i?>" id="spcart"><img src="img/shopcart.png" alt=""></label>
                            </div>
                        <?php  } ?>
                    </div>
                    <div class="wrap">
                        <?php for ($i = 6; $i < 9; $i++) { ?>
                            <div class="item">
                                <img src="img/<?= $picture[$i] ?>">
                                <h4><?= $productsName[$i] ?></h4>
                                <p>價格:<?= $price[$i] ?>$</p><button type="button" id="buy_btn" name="buy_btn<?= $i + 1 ?>">加入試算</button>
                                <input type="checkbox" name="ck_btn<?= $i?>" value="ck_btn<?= $i?>">
                                <label for="ckbb<?= $i?>" id="spcart"><img src="img/shopcart.png" alt=""></label>
                            </div>
                        <?php  } ?>
                    </div>
                </div>

                <div class="content_R">
                    <h1>購買清單試算</h1>
                    <div class="wrap_top">
                    <h4>如確定選購請"勾選"並按下購買</h4>
                        <?php for ($i = 1; $i < 10; $i++) { ?>
                            <div id="group">
                                <div id="item<?= $i ?>"></div>
                                <button type="button" class="deL_btn<?= $i ?>" id="del_btn">
                                    <span>&minus;</span></button>
                            </div>
                        <?php  } ?>

                    </div>
                    <div class="wrap_bottom">
                        <div class="item">
                            <h2>共計:<span id="count"></span>件</h2>
                            <h2 id="totPrice1">價錢:<span id="price"></span>$</h2>
                        </div>
                        
                        <div class="item">
                            <button type="button" name="totPrice" onclick="cal()">總計</button>
                            <button type="button" name="reMove" onclick="clean()">清空</button>
                            <button type="submit" id="ckb_btn" name="chkbuy_btn">購買</button>

                        </div>
                    </div>
                    <h2>購買紀錄</h2>
                    <div class="content_RB">
                        <ol>
                            <?php while (@$row3 = mysqli_fetch_assoc($result3)) { ?>
                                <li>
                                    <div class="item">
                                        <img src="img/<?= $row3["picture"] ?>">
                                        <h4><?= $row3["productsName"] ?></h4>
                                        <p>價格:<?= $row3["price"] ?>$</p>
                                        <h5>購買時間:<span id ="time"><?= $row3["update_time"] ?></span></h5>
                                        
                                    </div>
                                </li>
                            <?php } ?>
                        </ol>
                    </div>
            </form>
        </div>
    </div>



    <script src="js/Fantasy.js"></script>
    <script src="js/store.js"></script>

</body>

</html>