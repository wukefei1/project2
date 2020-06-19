function GetRequest() {
    var url = location.search; //获取url中"?"符后的字串
    var theRequest = new Object();
    if (url.indexOf("?") != -1) {
        var str = url.substr(1);
        strs = str.split("&");
        for (var i = 0; i < strs.length; i++) {
            theRequest[strs[i].split("=")[0]] = decodeURI(strs[i].split("=")[1]);
        }
    }
    return theRequest;
}

function jump(str) {
    var Request = new Object();
    Request = GetRequest();
    if (!Request['country']) Request['country'] = '';
    if (!Request['city']) Request['city'] = '';
    if (!Request['content']) Request['content'] = '';
    var country = (str == 'country') ? document.getElementById('country').value : Request['country'];
    var city = (str == 'city') ? document.getElementById('city').value : Request['city'];
    if (str == 'country') city = '';
    var content = (str == 'content') ? document.getElementById('content').value : Request['content'];
    location.href = '?country=' + country + '&city=' + city + '&content=' + content;
}

function jump1() {
    var Request = new Object();
    Request = GetRequest();
    if (!Request['country']) Request['country'] = '';
    if (!Request['city']) Request['city'] = '';
    if (!Request['content']) Request['content'] = '';

    document.forms[1].action = '?country=' + Request['country'] + '&city=' + Request['city'] + '&content=' + Request['content'] + '&type=4&pn=0';
    document.forms[1].submit();
}


function resize() {
    //响应式布局
    var w = document.documentElement.clientWidth;
    var h = document.documentElement.clientHeight;
    var filter = document.getElementById("filter");
    var row1 = document.getElementsByName("row1");
    var row2 = document.getElementsByName("row2");
    var row3 = document.getElementsByName("row3");
    var row4 = document.getElementsByName("row4");
    var nav = document.getElementById("nav");
    if (w < 720) {
        nav.style.width = "720px";
    } else {
        nav.style.width = "100%";
    }
    if (w < 1480) {
        for (var i = 0; i < row4.length; i++) {
            row4[i].hidden = "hidden";
        }
    } else {
        for (var i = 0; i < row4.length; i++) {
            row4[i].removeAttribute("hidden");
        }
    }
    if (w < 1220) {
        for (var i = 0; i < row4.length; i++) {
            row3[i].hidden = "hidden";
        }
    } else {
        for (var i = 0; i < row4.length; i++) {
            row3[i].removeAttribute("hidden");
        }
    }
    if (w < 960) {
        for (var i = 0; i < row4.length; i++) {
            row2[i].hidden = "hidden";
        }
    } else {
        for (var i = 0; i < row4.length; i++) {
            row2[i].removeAttribute("hidden");
        }
    }
    if (w < 700) {
        filter.style.width = "320px";
    } else {
        filter.style.width = "calc(100% - 410px)";
    }
}

window.addEventListener("resize", resize);