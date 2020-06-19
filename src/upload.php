<!DOCTYPE html>
<html lang='zh-CN'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='css/reset.css'>
    <link rel='stylesheet' href='css/common.css'>
    <link rel='stylesheet' href='css/upload.css'>
    <title>upload</title>
    <script src='js/upload.js'></script>
    <script src='js/jquery.js'></script>
    <script src='js/common.js'></script>
</head>

<body onload='resize()'>
    <div class='box' id='others'>
        <header class='nav' id='nav'>
            <!-- 导航栏 -->
            <ul>
                <li>
                    <a class='navigation' href='./home.php'>
                        <img src='../img/common/default.png' width='30' height='30'>
                    </a>
                </li>
                <li><a class='navigation' href='./home.php'>首页</a></li>
                <li><a class='navigation' href='./browse.php'>浏览</a></li>
                <li><a class='navigation' href='./search.php'>搜索</a></li>
            </ul>
            <?php
            if (isset($_COOKIE['Username'])) {
                echo
                    "<div class='header_right'>
                <ul>
                    <a href='./login.php'>
                        <li class='show_list'>
                            <span>&#12288个人中心&#12288</span>
                            <ul class='move_list'>
                                <li style='border-radius: 10px 10px 0px 0px;'>
                                    <a href='./upload.php'>
                                        &#12288<img class='h' src='../img/common/upload_w.png' width='20' height='20'>&#12288上传
                                    </a>
                                </li>
                                <li>
                                    <a href='./my_photos.php'>
                                        &#12288<img class='h' src='../img/common/my pictures_w.png' width='20' height='20'>&#12288我的照片
                                    </a>
                                </li>
                                <li>
                                    <a href='./my_favourite.php'>
                                        &#12288<img class='h' src='../img/common/my favourite_w.png' width='20' height='20'>&#12288我的收藏
                                    </a>
                                </li>
                                <li style='border-radius: 0px 0px 10px 10px;'>
                                    <a href='./logout.php'>
                                        &#12288<img class='h' src='../img/common/log in_w.png' width='20' height='20'>&#12288登出
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </a>
                </ul>
            </div>";
            } else {
                echo "<div class='header_right'>
                <ul>
                    <a href='./login.php'>
                        <li class='show_list'>
                            <span>&#12288&#12288登录&#12288&#12288</span>
                        </li>
                    </a>
                </ul>
            </div>";
            }
            ?>
        </header>
        <br><br><br><br>

        <filter id='filter'>
            <!-- 上传框 -->

            <ul class='first'>上传</ul>
            <?php
            header("Content-Type: text/html; charset=utf8");
            if (!isset($_COOKIE['Username'])) {
                echo "<ul>你尚未登录！<ul>";
                echo "
            <script>
                setTimeout(function(){window.location.href='./login.php';},1000);
            </script>";
            } else {
                include('connect.php');
                include('compress.php');

                $ImageID = isset($_GET['ImageID']) ? $_GET['ImageID'] : ' ';
                if ($ImageID  == '') $ImageID = ' ';

                $src = '';
                $country = '';
                $content = '';
                $content = '';
                $title = '';
                $description = '';

                if ($ImageID != ' ') {
                    $sql = "select * from travelimage where ImageID='$ImageID'";
                    $result = mysqli_query($mysqli, $sql); //执行sql
                    $rows = ($result) ? mysqli_num_rows($result) : 0;
                    if ($rows) {
                        $array = mysqli_fetch_array($result);
                        if ($src == '') $src = "../img/travel-images/large/" . $array['PATH'];
                        if ($country == '') $country = $array['Country_RegionCodeISO'];
                        if ($content == '') $city = $array['CityCode'];
                        if ($content == '') $content = $array['Content'];
                        if ($title == '') $title = $array['Title'];
                        if ($description == '') $description = $array['Description'];
                    } else {
                        echo "<script type='text/javascript'>alert('非法的图片ID！');location='javascript:history.back()';</script>";
                        exit;
                    }
                }


                echo "
            <ul class='last' style='height: " . ($src == '' ? '600' : '1000') . "px;'>
                <form enctype='multipart/form-data' name='upload_form' action='upload_judge.php?ImageID=$ImageID' method='POST'>
                    <div>
                        <a><img src='" . ($src == '' ? '' : $src) . "'  id='img0' onload='Zoom(this,570,380)' onclick='showImage(this.src)'>
                        </a>
                    </div>
                    <p id='hint' " . ($src == '' ? 'hidden' : '') . ">点击图片以查看原图</p>
                    <p id='fileName'>" . ($src == '' ? '' : $src) . "</p>
                    <label for='file0' id='upFile'>" . ($src == '' ? "上传" : "修改") . "文件</label>
                    <input type='file' name='file0' id='file0' accept='image/jpeg,image/jpg,image/png' onchange='getImg()' hidden>
                    <br><br>
                    <label>
                        图片标题：<br>
                        <input class='normal' type='text' name='title' id='title' value='" . ($title == ' ' ? '' : $title) . "' required>
                    </label>
                    <br><br>
                    <label>
                        图片描述：<br>
                        <textarea class='normal' type='text' name='description' id='description' required>$description</textarea>
                    </label>
                    <br><br>";




                $sql = "select Content from travelimage group by Content";
                $result = mysqli_query($mysqli, $sql); //执行sql
                $rows = ($result) ? mysqli_num_rows($result) : 0;
                echo "<select name='content' id='content'>";
                echo "<option value=' ' " . (($content == ' ') ? 'selected' : '') . ">请选择内容</option>";
                for ($i = 0; $i < $rows; $i++) {
                    $array = mysqli_fetch_array($result);
                    $temp1 = $array['Content'];
                    echo "<option value='$temp1' " . (($array['Content'] == $content) ? 'selected' : '') . ">$temp1</option>";
                }
                echo "</select>";

                $sql = "select Country_RegionName,ISO from geocountries_regions where 1";
                $result = mysqli_query($mysqli, $sql); //执行sql
                $rows = ($result) ? mysqli_num_rows($result) : 0;
                echo "<select name='country' id='country'>";
                echo "<option value=' ' " . (($country == ' ') ? 'selected' : '') . ">请选择国家</option>";
                for ($i = 0; $i < $rows; $i++) {
                    $array = mysqli_fetch_array($result);
                    $temp1 = $array['Country_RegionName'];
                    $temp2 = $array['ISO'];
                    echo "<option value='$temp2' " . (($array['ISO'] == $country) ? 'selected' : '') . ">$temp1</option>";
                }
                echo "</select>";

                echo "<select name='city' id='city'>";
                echo "<option value=' '" . (($city == ' ') ? 'selected' : '') . ">请选择城市</option>";
                echo "</select><br><br>
                <script src='js/filter_onchange.js'></script>
            <input type='submit' value='提交' name='submit'>
            </form>
            </ul>";
                mysqli_close($mysqli);
            }
            ?>

        </filter>

        <div id='back-to-top' class='top_e'>
            <img src='../img/common/totop.png' width='40' height='40' id='img'>
        </div>
        <!-- <div id='refresh' class='refresh_e'>
            <img src='../img/common/refresh.png' width='40' height='40' id='img' onclick='alert('图片已更新')'>
        </div> -->

        <footer>
            <br><br>Copyright © 2019-2021 Web fundamental. All Rights Reserved. 备案号：19302010012
        </footer>
    </div>
    <a><img src='' onclick='closeImage()' id='yuantu'></a>
    <p id='hidden' hidden>点击图片以返回</p>
</body>

</html>