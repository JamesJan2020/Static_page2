
//讓每個buy_btn增加click事件
let buyBtn = document.querySelectorAll("#buy_btn");

for (i = 0; i < buyBtn.length; i++) {
    buyBtn[i].addEventListener("click", buyList);

}

//取出各價錢及圖片資訊
let image = document.querySelectorAll(".item");

let totPdname;
let pdname=[];
let totPrice;
let price = [];
let totpic;
let pic = [];
for (i = 0; i < 9; i++) {
    totPrice = image[i].children[2].innerHTML;
    price[price.length] = totPrice.substr(3,3) //價錢
    totpic = image[i].children[0].outerHTML;
    pic[pic.length] = totpic; //圖片
    totPdname=image[i].children[1].innerHTML;
    pdname[pdname.length]=totPdname; //項目名稱
    
}
// console.log(pdname[1]);





let delid_btn = document.querySelectorAll("#del_btn");

//讓每個del_btn增加click事件
for (i = 0; i < delid_btn.length; i++) {
    delid_btn[i].addEventListener("click", del);
}

//取出所有del_btn ID
let group = document.querySelectorAll("#group");
let totiDel;
let deli_btn = [];
for (i = 0; i < group.length; i++) {
    totiDel = group[i].lastElementChild.id;
    deli_btn[deli_btn.length] = totiDel;
}

//取出各delet按鍵className
let totDel;
let delclass_btn = [];
for (i = 0; i < group.length; i++) {
    totDel = group[i].lastElementChild.className;
    delclass_btn[delclass_btn.length] = totDel;
}

//讓每個del_btn增加class屬性隱藏按鈕
for (i = 0; i < group.length; i++) {
    document.getElementsByClassName(`${delclass_btn[i]}`)[0].classList.add("hide");
}


let cnt = 0;
let delcnt = 0;
let bPrice = [];
let bAllprice = 0;
function buyList(elm) {
    let itemName = elm.target.name;
    //按下加入購物車時 右邊清單增加一項目內容
    for (i = 0; i < 9; i++) {
        if (itemName == `buy_btn${i + 1}`) {
            document.getElementById(`item${i + 1}`).innerHTML = `${pic[i]}<h4>${pdname[i]}</h4><p>${price[i]}$</p>`;
            document.getElementsByClassName(`${delclass_btn[i]}`)[0].classList.remove("hide");
        //  console.log(itemName);
        }
    }


    //增加購買產品數量
    if (itemName) {
        cnt++;
        document.getElementById("count").innerText = cnt - delcnt;
    }
}




let aPrice = [];
let aAllprice = 0;
let lastTot = 0;
function del(elm) {
    let del = elm.target.className;
    console.log(del)
    //按下指定-鈕讓相對內容物消失
    for (i = 0; i < 9; i++) {
        if (del == `deL_btn${i + 1}`) {
            document.getElementById(`item${i + 1}`).innerHTML = "";
            this.classList.add("hide");

        }
    }
    //減掉購買產品數量
    if (del) {
        delcnt++;
        document.getElementById("count").innerText = cnt - delcnt;
    }
}



let money;
let calMoney = [];
let totoMoney = 0;
function cal() {
    for (i = 0; i < 9; i++) {
        //取得所有價錢
        money = document.getElementById(`item${i + 1}`).innerText.substr(16, 16);

        //空字串不存入陣列
        if (money != "") {
            calMoney[calMoney.length] = parseInt(money);

            //陣列數值加總
            document.getElementById("price").innerHTML = calMoney.reduce(myFunc);

            function myFunc(total, num) {
                return total + num;
            }
        }
    }

}
//資料初始化
function clean() {
    for (i = 0; i < 9; i++) {
        document.getElementById(`item${i + 1}`).innerHTML = "";
        document.getElementsByClassName(`${delclass_btn[i]}`)[0].classList.add("hide");
    }

    document.getElementById("price").innerHTML = "";
    document.getElementById("count").innerHTML = "";
    calMoney = [];
    cnt = 0;
    delcnt = 0;
}




