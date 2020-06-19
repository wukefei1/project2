# PJ2说明文档

----------
>   吴可非 19302010012
>   Github地址：[https://github.com/wukefei1/project2](https://github.com/wukefei1/project2)
>   网站地址：[http://wukefei.xyz:55555](http://wukefei.xyz:55555/)

## 项目完成情况
----------
>   设计文档中提到的所有功能均已完成
>   bonus(1)/(3)中提到的所有功能均已完成

### 首页

* 下拉栏

纯css写法。正常状态下display为none，鼠标放上去时为block。

```
.show_list .move_list {
    display: none;
    list-style: none;
    ...
}
...
.show_list:hover .move_list {
    display: block;
}
```

* 头图
选择了文件夹中的一张图作为头图。

* 回到页面顶部的按钮
回到顶部时有动画效果（js实现）。

### 浏览页
* 侧边栏
点击国家时会改变城市选项（代码有些糟糕，之后会改进）

* 选项框
二级菜单联动，使用js实现。

### 搜索页
* 筛选部分
使用js实现了只有选择了的输入框才能填写。

### 上传界面
* 图片预览
为了保证界面效果，图片使用js进行裁剪之后被显示（点击图片后可以查看原图，再次点击可以返回上传界面，同样js实现）。

### 我的照片、我的收藏
* 界面设计
基本没什么好讲的，主要是响应式布局（会在下面详细讲）。

### 登录界面、注册界面
>可以相互跳转，js判断注册时两次密码是否一致。

### 图片详细信息
* 界面设计
同样没什么好讲的，做了响应式布局。





## Bonus完成情况和解决方法

### 更复杂的图片处理
* 图片裁剪
js实现，代码如下，大致思路是先放缩，然后再给外容器加入margin和overflow：hidden属性以隐藏多余部分。

```
function Zoom(obj, width, height) {
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
```

### 响应式布局
* 移动设备适配
在所有页面加入这行代码即可。
`<meta name="viewport" content="width=device-width, initial-scale=1.0">`

* 不过分改变浏览器宽度
js和css并用，主要思路是当宽度缩小到某个范围时改变布局或改变属性值,在必要的地方使用calc()来简化。

* * 导航栏
当界面宽度减小时，“我的账户”首先跟随界面移动，当宽度小于720px时固定。
```
var w = document.documentElement.clientWidth;
var nav = document.getElementById("nav");
if (w < 720) {
    nav.style.width = "720px";
} else {
    nav.style.width = "100%";
}
```

* * 首页
由于一些原因，直接使用js做了页面长宽等比例缩放。

* * 浏览页
当浏览器窗口变小时，筛选结果中每一行所含有的图片数量会变少。（依然js实现）

* * 浏览页
当浏览器窗口变小时，右侧文字宽度变小。
窗口更小时，改变布局，将文字置于图片下方。
```
var div = document.getElementsByName("div");
var ul = document.getElementsByName("ul");
var p = document.getElementsByName("p");
for (var i = 0; i < div.length; i++) {
    if (w > 1300) {
        div[i].style.position = "absolute";
        div[i].style.left = "500px";
        div[i].style.top = "50px";
        ul[i].style.height = "300px";
        p[i].style.width = "600px";
    } else if (w > 1000) {
        div[i].style.position = "absolute";
        div[i].style.left = "500px";
        div[i].style.top = "50px";
        ul[i].style.height = "300px";
        p[i].style.width = w - 700 + "px";
    } else if (w > 720) {
        div[i].style.position = "relative";
        div[i].style.left = "20px";
        div[i].style.top = "10px";
        ul[i].style.height = "500px";
        p[i].style.width = w - 300 + "px";
    } else {
        div[i].style.position = "relative";
        div[i].style.left = "20px";
        div[i].style.top = "10px";
        ul[i].style.height = "500px";
        p[i].style.width = "420px";
    }
}
```

* * 我的照片、我的收藏
同样，当浏览器窗口变小时，右侧文字宽度变小。
窗口更小时，改变布局，将文字置于图片下方，同时改变按钮位置。
代码类型大致和搜索页相同，不再赘述。

### 界面美观
网页配色大致采用示例截图里的配色，所有可以点的地方在hover时都设置了cursor：pointer以增进用户体验。

## 意见与建议
* 暂无

