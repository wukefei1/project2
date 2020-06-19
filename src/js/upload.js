// function GetRequest() {
//     var url = location.search; //获取url中"?"符后的字串
//     var theRequest = new Object();
//     if (url.indexOf("?") != -1) {
//         var str = url.substr(1);
//         strs = str.split("&");
//         for (var i = 0; i < strs.length; i++) {
//             theRequest[strs[i].split("=")[0]] = decodeURI(strs[i].split("=")[1]);
//         }
//     }
//     return theRequest;
// }

// function jump(str) {
//     var Request = new Object();
//     Request = GetRequest();

//     if (!Request['ImageID']) Request['ImageID'] = '';
//     if (!Request['src']) Request['src'] = '';
//     if (!Request['country']) Request['country'] = '';
//     if (!Request['city']) Request['city'] = '';
//     if (!Request['content']) Request['content'] = '';
//     if (!Request['title']) Request['title'] = '';
//     if (!Request['description']) Request['description'] = '';

//     var src = (str == 'src') ? document.getElementById('fileName').value : Request['src'];
//     var country = (str == 'country') ? document.getElementById('country').value : Request['country'];
//     var city = (str == 'city') ? document.getElementById('city').value : Request['city'];
//     if (str == 'country') city = '';
//     var content = (str == 'content') ? document.getElementById('content').value : Request['content'];
//     var title = (str == 'title') ? document.getElementById('title').value : Request['title'];
//     var description = (str == 'description') ? document.getElementById('description').value : Request['description'];

//     location.href = '?ImageID=' + Request['ImageID'] + '&src=' + src + '&title=' + title + '&description=' + description + '&country=' + country + '&city=' + city + '&content=' + content;
// }

// function jump1() {
//     var Request = new Object();
//     Request = GetRequest();

//     if (!Request['ImageID']) Request['ImageID'] = '';
//     if (!Request['src']) Request['src'] = '';
//     if (!Request['country']) Request['country'] = '';
//     if (!Request['city']) Request['city'] = '';
//     if (!Request['content']) Request['content'] = '';
//     if (!Request['title']) Request['title'] = '';
//     if (!Request['description']) Request['description'] = '';

//     document.forms[0].action = 'upload_judge.php?ImageID=' + Request['ImageID'] + '&src=' + Request['src'] + '&title=' + Request['title'] + '&description=' + Request['description'] + '&country=' + Request['country'] + '&city=' + Request['city'] + '&content=' + Request['content'];
//     document.forms[0].submit();
// }

function getObjectURL(file) {
    var url = null;
    if (window.createObjectURL != undefined) {
        url = window.createObjectURL(file);
    } else if (window.URL != undefined) { // mozilla(firefox)
        url = window.URL.createObjectURL(file);
    } else if (window.webkitURL != undefined) { // webkit or chrome
        url = window.webkitURL.createObjectURL(file);
    }
    return url;
}

function getImg() {
    //图片预览，并显示文件名
    var file = document.getElementById("file0");
    var objUrl = getObjectURL(file.files[0]);
    console.log("objUrl = " + objUrl);
    var obj = document.getElementById("img0");
    if (objUrl != "") {
        obj.setAttribute("src", objUrl);
    }
    var urlArr = file.value.split("\\");
    console.log(urlArr);
    if (file && file.files && file.files[0]) {
        document.getElementById("fileName").innerHTML = urlArr[urlArr.length - 1];
        var fileUrl = URL.createObjectURL(file.files[0]);
        // document.getElementById("fileImg").src = fileUrl;
    } else {
        //兼容IE9以下
        document.getElementById("fileName").innerHTML = urlArr[urlArr.length - 1];
        // document.getElementById("fileImg").style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
        // document.getElementById("fileImg").filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = this.value;
    }
    obj.onload = function() {
        width = 570;
        height = 380;
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
        div.parentNode.parentNode.style.height = "1000px";
        document.getElementById("hint").removeAttribute("hidden");
    }

    // document.forms[0].action = 'upload_temp.php';
    // document.forms[0].submit();
};

function resize() {
    //响应式布局
    var w = document.documentElement.clientWidth;
    var h = document.documentElement.clientHeight;

    var x = document.getElementById("filter");
    var nav = document.getElementById("nav");
    if (w < 720) {
        nav.style.width = "720px";
    } else {
        nav.style.width = "100%";
    }
    if (w < 720) {
        x.style.width = "560px";
    } else {
        x.style.width = w - 160 + "px";
    }
}

window.addEventListener("resize", resize);