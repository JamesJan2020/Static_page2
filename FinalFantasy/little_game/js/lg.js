function nowTime() {
    var d = new Date;
    var tt = d.toLocaleString();
    document.getElementById("nowTime").innerText = tt;
}
nowTime()
setInterval(nowTime, 1000)






//開始遊戲

function startGame() {
    //清空上一回分數跟跳出的視窗
    tot = 0;
    document.getElementById('score').innerText = '';
    document.getElementById('msgitem1').style.display = 'none';
    document.getElementById('msgitem2').style.display = 'none';

    //啟動倒數計時器
    // 01:00 有分有秒 
    // s從這來
    var cntSec = -1;

    var startTime = 30; //倒數的時間

    var stopTime = setInterval(cntDown, 1000)

    function cntDown() {
        cntSec++; //2,3,4,5,6,7 自動加1

        //把得到的數值利用funtuin做秒數轉換
        var newTime = (changeSec(startTime - cntSec))

        document.getElementById("timer").innerText = newTime

    }

    //秒數轉換
    function changeSec(s) {

        if (s == 0) {
            clearInterval(stopTime)
        }

        var Min = Math.floor(s / 60);

        var Sec = s % 60;

        return Min.toString().padStart(2, '0') + ':' + Sec.toString().padStart(2, '0');


    }


    //增加animation
    document.getElementById('bag1').setAttribute('style', 'animation: imgMove 5s infinite;')
    document.getElementById('bag2').setAttribute('style', 'animation: imgRotate 5s infinite;')
    document.getElementById('bag3').setAttribute('style', 'animation: imgOpacity 5s infinite;')

    //指定秒數後變更animation原有狀態
    setTimeout(imgMove, 1000) //picu變狀態
    setTimeout(imgRotate, 8000) //Chocobo8秒後變狀態
    setTimeout(imgOpacity, 15000) //mogole15秒後變狀態
    setTimeout(onlyRotate, 27000) //mogole旋轉


    //遊戲結束
    setTimeout(function timeout() {
        //最後分數
        if (tot < 125) {

            document.getElementById("msgitem1").style.display = "block"
        } else {

            document.getElementById("msgitem2").style.display = "block"
        }
        //清除style讓圖片消失防止圖片繼續做動
        document.getElementById("bag1").removeAttribute('style')
        document.getElementById("bag2").removeAttribute('style')
        document.getElementById("bag3").removeAttribute('style')
        console.log(tot)
    }, 32000)

}



//增加點擊事件換圖片

var tot = 0;

function divMouseDown(hitDown) {
    console.log(hitDown.target.id)
    var hitEvt = hitDown.target.id
    switch (hitEvt) {
        //點擊不同圖片分數不同

        // Chocobo點擊一次1分
        case "cuteguys1":
            for (i = 0; i < 1; i++) {
                tot += 1
            }
            break;

        // mogole點擊一次2分
        case "cuteguys2":
            for (i = 0; i < 2; i++) {
                tot += 1
            }
            break;

        // picu點擊一次3分
        case "cuteguys3":
            for (i = 0; i < 3; i++) {
                tot += 1
            }
            break;

    }
    //點擊跑出Boom圖片
    document.getElementById('score').innerText = `${tot}分指力`
    document.getElementById(hitDown.target.id).src = "img/Boom.png"

}


//點擊完變回原圖片
function divMouseUp(hitUp) {

    var hitUpEvt = hitUp.target.id
    switch (hitUpEvt) {
        case "cuteguys1":
            document.getElementById(hitUp.target.id).src = "img/ff-cuteguys.png"
            break;

        case "cuteguys2":
            document.getElementById(hitUp.target.id).src = "img/FF-mogole.png"
            break;

        case "cuteguys3":
            document.getElementById(hitUp.target.id).src = "img/picu.gif"
            break;
    }

}


//增加不同animation
function imgMove() {

    document.getElementById('bag1').style.display = "block";
    document.getElementById('bag3').style.animationName = "imgMove";

}


function imgRotate() {
    document.getElementById('bag3').style.display = "block";
    document.getElementById('bag1').style.animationName = "imgRotate";

}

function imgOpacity() {
    document.getElementById('bag2').style.display = "block";
    document.getElementById('bag2').style.animationName = "imgOpacity";


}

function onlyRotate() {
    document.getElementById('bag2').style.animationName = "onlyRotate";
    document.getElementById('bag2').style.animationDuration = "0.5s"
    document.getElementById('bag2').style.animationTimingFunction = "linear"
}


function ruleMsg() {
    document.getElementById("msgitem3").style.display = "block"

}

close_btn1.onclick = function () {
    console.log("ok");
    document.getElementById("msgitem3").style.display = "none"
    document.getElementById("msgitem2").style.display = "none"
    document.getElementById("msgitem1").style.display = "none"
}