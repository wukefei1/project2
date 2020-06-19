<!DOCTYPE html>
<html lang='zh-CN'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='css/reset.css'>
    <link rel='stylesheet' href='css/common.css'>
    <link rel='stylesheet' href='css/details.css'>
    <title>details</title>
    <script src='js/details.js'></script>
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
            <!-- 详细信息 -->
            <ul class='first'>详细信息</ul>
            <ul class='last photo' id='photo'>
                <br>
                <?php
                include('connect.php'); //链接数据库
                $isFavorite = 0;

                $id = $_GET['id'];
                if ($id) {
                    if (isset($_COOKIE['Username'])) {
                        $uid = $_COOKIE['Username'];
                        $sql = "select * from travelimagefavor where ImageID = '$id' and UID='$uid'";
                        $result = mysqli_query($mysqli, $sql);
                        $rows = mysqli_num_rows($result);
                        if ($rows) $isFavorite = 1;
                    }

                    $sql = "select * from travelimage where ImageID = '$id'";
                    $result = mysqli_query($mysqli, $sql);
                    $rows = mysqli_num_rows($result);
                    if ($rows > 0) {
                        $array = mysqli_fetch_array($result);
                        if ($array['Description'] == NULL) {
                            $array['Description'] = "该图片暂无简介！";
                        }
                        $Country_RegionCodeISO = $array['Country_RegionCodeISO'];
                        $sql1 = "select * from geocountries_regions where ISO = '$Country_RegionCodeISO'";
                        $result1 = mysqli_query($mysqli, $sql1);
                        $array1 = mysqli_fetch_array($result1);
                        $CityCode = $array['CityCode'];
                        $sql2 = "select * from geocities where GeoNameID = '$CityCode'";
                        $result2 = mysqli_query($mysqli, $sql2);
                        $array2 = mysqli_fetch_array($result2);
                        $UID = $array['UID'];
                        $sql3 = "select * from traveluser where UID = '$UID'";
                        $result3 = mysqli_query($mysqli, $sql3);
                        $array3 = mysqli_fetch_array($result3);
                        echo "<h1>" . $array['Title'] . "<small>by " . $array3['UserName'] . "</small></h1>
                <div>
                    <a>
                        <img src='../img/travel-images/large/" . $array['PATH'] . "' onload='Zoom(this,540,360)' onclick='showImage(this.src)'>
                    </a>
                </div>
                <p id='hint'>点击图片以查看原图</p>
                <ul class='first' name='ul'>喜爱程度</ul>
                <ul class='last' name='ul' style='height: 30px;text-align: center;font: 24px Verdana;color: red;'>99</ul>
                <br>
                <ul class='first' name='ul'>图片详细信息</ul>
                <ul name='ul'>内容：" . $array['Content'] . "</ul>
                <ul name='ul'>国家：" . $array1['Country_RegionName'] . "</ul>
                <ul name='ul' class='last'>城市：" . $array2['AsciiName'] . "</ul>
                <br>
                <ul name='ul' class='like'>
                    <a href='change_favourite.php?uid=$uid&ImageID=$id&isFavorite=$isFavorite'>
                        <img src='../img/common/test.png' width='20' height='20' style='position: relative;top: -3px'>&#12288" . ($isFavorite == 1 ? '取消' : '点击') . "收藏
                    </a>
                </ul>
                <p class='content' id='p'>" . $array['Description'] . "</p>";
                    } else {
                        echo "<script type='text/javascript'>alert('非法的图片ID！');location='javascript:history.back()';</script>";
                    }
                } else {
                    echo "<script type='text/javascript'>alert('请选择图片后再查看相信信息！');location='javascript:history.back()';</script>";
                }
                ?>
            </ul>
        </filter>

        <div id='back-to-top' class='top_e'>
            <img src='../img/common/totop.png' width='40' height='40' id='img'>
        </div>
        <!-- <div id='refresh' class='refresh_e'>
            <img src='../img/common/refresh.png' width='40' height='40' id='img' onclick='alert("图片已更新")'>
        </div> -->

        <footer>
            <br><br>Copyright © 2019-2021 Web fundamental. All Rights Reserved. 备案号：19302010012
        </footer>
    </div>
    <a><img src='' onclick='closeImage()' id='yuantu'></a>
    <p id='hidden' hidden>点击图片以返回</p>
</body>

</html>