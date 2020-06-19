function resize() {
    //响应式布局
    var w = document.documentElement.clientWidth;
    var h = document.documentElement.clientHeight;

    var nav = document.getElementById("nav");
    if (w < 720) {
        nav.style.width = "720px";
    } else {
        nav.style.width = "100%";
    }

    var p = document.getElementsByName("p");
    var a = document.getElementsByName("a");
    var img = document.getElementsByName("img");
    var table = document.getElementById("table");
    var td = document.getElementsByName("td");
    var div = document.getElementsByName("div");
    const scale = w / 1520;

    table.style.borderSpacing = 40 * scale + "px";
    table.style.right = -80 * scale + "px";
    for (var i = 0; i < p.length; i++) {
        p[i].style.fontSize = scale * 20 + "px";
        p[i].style.left = 25 * scale + "px";
        p[i].style.bottom = 25 * scale + "px";
        a[i].style.fontSize = scale * 30 + "px";
        a[i].style.left = 25 * scale + "px";
        a[i].style.bottom = 75 * scale + "px";
        thisZoom(img[i], 350 * scale, 280 * scale);
        td[i].style.minWidth = 400 * scale + "px";
        td[i].style.height = 430 * scale + "px";
        td[i].style.borderRadius = 40 * scale + "px";
        div[i].style.bottom = 40 * scale + "px";
        div[i].style.left = 25 * scale + "px";
        div[i].style.borderRadius = 15 * scale + "px";
    }

    var footer = document.getElementById("footer");
    footer.style.height = 250 * scale + "px";
    var fp = footer.getElementsByTagName("p");
    fp[0].style.top = 30 * scale + "px";
    fp[0].style.fontSize = 15 * scale + "px";
    var ftable = footer.getElementsByTagName("table");
    ftable[0].style.top = 40 * scale + "px";
    ftable[0].style.left = 100 * scale + "px";
    ftable[0].style.fontSize = 20 * scale + "px";
    var ftd = footer.getElementsByTagName("td");
    for (var i = 0; i < ftd.length; i++) {
        ftd[i].style.paddingBottom = 30 * scale + "px";
        ftd[i].style.paddingRight = 150 * scale + "px";
    }

    var weiXin = document.getElementById("myweixin");
    weiXin.style.height = 200 * scale + "px";
    weiXin.style.width = 200 * scale + "px";
    weiXin.style.top = 20 * scale + "px";
    weiXin.style.right = 20 * scale + "px";

    var img11 = document.getElementById("img11");
    var img12 = document.getElementById("img12");
    var img21 = document.getElementById("img21");
    var img22 = document.getElementById("img22");
    img11.width = 40 * scale;
    img11.height = 40 * scale;
    img11.style.width = 40 * scale;
    img11.style.height = 40 * scale;
    img11.style.top = 120 * scale + "px";
    img11.style.left = 900 * scale + "px";
    img12.width = 40 * scale;
    img12.height = 40 * scale;
    img12.style.width = 40 * scale;
    img12.style.height = 40 * scale;
    img12.style.top = 40 * scale + "px";
    img12.style.left = 900 * scale + "px";
    img21.width = 40 * scale;
    img21.height = 40 * scale;
    img21.style.width = 40 * scale;
    img21.style.height = 40 * scale;
    img21.style.top = 120 * scale + "px";
    img21.style.left = 820 * scale + "px";
    img22.width = 40 * scale;
    img22.height = 40 * scale;
    img22.style.width = 40 * scale;
    img22.style.height = 40 * scale;
    img22.style.top = 40 * scale + "px";
    img22.style.left = 820 * scale + "px";
}

window.addEventListener("resize", resize);

function thisZoom(obj, width, height) {
    //裁剪图片符合固定长宽
    var scale = Math.max(width / obj.width, height / obj.height);
    var newWidth = obj.width * scale;
    var newHeight = obj.height * scale;
    var div = obj.parentNode.parentNode;

    obj.width = newWidth;
    obj.height = newHeight;
    div.style.width = width + "px";
    div.style.height = height + "px";
    div.style.overflow = "hidden";
    obj.style.marginLeft = (width - newWidth) / 2 + "px";
    obj.style.marginRight = (height - newHeight) / 2 + "px";
}