
// loding...
setInterval(creatDot, 700) // 每0.7秒執行一次
var dot = '';
function creatDot() {
    for (i = 0; i < 1; i++) {
        dot += ".";
        var dd = dot
        //當...長度到達指定數量 回傳空自串
        if (dd == '......') {
            return dot = '';
        }
    }
    //寫出來
    document.getElementById("dotHome").innerText = dot
}

// 4秒後pointer出現
setTimeout(opPointer, 4000)

function opPointer() {
    document.getElementById("pointer").style.display = "block"
}


//按下Chocobo monitor選單 跑出來

function opMonitor() {
    document.getElementById("monitor_open").style.display = "block"
    document.getElementById("pointer").style.display = "none"

}

//讓pointer2 可上下移動

var pointer2 = document.getElementById("pointer2")
function movePointer(upDown) {
    // console.log(upDown)
    var mytype = window.getComputedStyle(pointer2);
    var mytop = mytype.getPropertyValue('top');
    var current = parseInt(mytop)

    console.log(current)

    switch (upDown.keyCode) {

        //往上
        case 38:
            // 防止手指超出上方
            if (current == 20) {
                return current
            }
            pointer2.style.top = (current - 75) + "px";
            break;
        //往下
        case 40:
            // 防止手指超出下方
            if (current > 20) {
                return current
            }
            pointer2.style.top = (current + 75) + "px";

            break;


        //選到開始 按Enter 跳轉到首頁或返回(視窗關掉)
        case 13:
            if (current == 20) {
            document.location.href = "Fantasy.php";
            }
            else{
                document.location.href = "Fantasyopening.html";
            }
            break;
    }

}

