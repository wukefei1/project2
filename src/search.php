<!DOCTYPE html>
<html lang='zh-CN'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='css/reset.css'>
    <link rel='stylesheet' href='css/common.css'>
    <link rel='stylesheet' href='css/search.css'>
    <title>search</title>
    <script src='js/search.js'></script>
    <script src='js/jquery.js'></script>
    <script src='js/common.js'></script>
</head>

<body onload='resize()'>
    <div class='box'>
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
                <li><a class='navigation' href='./search.php' id='chosen'>搜索</a></li>
            </ul>
            <?php
            if (isset($_COOKIE['Username'])) {
                echo
                    "<div class='header_right'>
                <ul>
                    <a>
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
            <!-- 搜索框 -->
            <ul class='first'>搜索</ul>
            <ul class='last' style='height: 280px;'>
                <form name='form1' method='GET' action=''>
                    <?php
                    $title = isset($_GET['title']) ? $_GET['title'] : '';
                    $content = isset($_GET['content']) ? $_GET['content'] : '';
                    echo "<label><input name='search' type='radio' value='' onclick=' changeText(1)' " . (($title == '' && $content != '') ? '' : 'checked') . ">按标题过滤</label><br>";
                    echo "<input type='text' name='title' id='title' autocomplete='off' value='$title' " . (($title == '' && $content != '') ? 'disabled=\'disabled\'' : '') . ">";

                    echo "<br><label><input name='search' type='radio' value='' onclick=' changeText(2)'" . (($content == '') ? '' : 'checked') . ">按内容过滤</label><br>";
                    echo "<textarea type='text' name='content' id='content' " . (($content == '') ? 'disabled=\'disabled\'' : '') . ">$content</textarea>"
                    ?>
                    <br>
                    <input type='submit' value='过滤'>
                </form>
            </ul>
            <br><br>
            <ul class='first'>搜索结果</ul>
            <?php
            $page = 5;

            include('connect.php'); //链接数据库
            include('random.php');

            $pn = $_GET['pn'];
            if (!$pn) $pn = 0;
            $pn *= $page;
            $id = array();
            $rows = $page;
            $maxrows = $page;


            $sql = "select ImageID from travelimage where " . (($title == '') ? "" : " Title like '%$title%' and ")  . (($content == '') ? "" : " Description like '%$content%' and ") . "1";
            $result = mysqli_query($mysqli, $sql); //执行sql
            $maxrows = ($result) ? mysqli_num_rows($result) : 1;

            $sql = "select ImageID from travelimage where " . (($title == '') ? "" : " Title like '%$title%' and ")  . (($content == '') ? "" : " Description like '%$content%' and ") . "1 LIMIT $pn,$page";
            $result = mysqli_query($mysqli, $sql); //执行sql
            $rows = ($result) ? mysqli_num_rows($result) : 0;
            for ($i = 0; $i < $rows; $i++) {
                $array = mysqli_fetch_array($result);
                $id[$i] = $array['ImageID'];
            }



            if ($rows == 0)
                echo "<ul>该分类暂无图片！</ul>";

            for ($i = 0; $i < $rows; $i++) {
                $ImageID = $id[$i];
                $sql = "select * from travelimage where ImageID = '$ImageID'";
                $result = mysqli_query($mysqli, $sql); //执行sql
                $array = mysqli_fetch_array($result);
                if ($array['Description'] == NULL) {
                    $array['Description'] = "该图片暂无简介！";
                }
                echo "<ul class='result' name='ul'>
                <p style='position: relative;left: 25px;top: 25px;'>
                <a href='./details.php?id=" . $ImageID . "'><img src='../img/travel-images/small/" . $array['PATH'] . "' onload='Zoom(this,400,250)' name='img'></a>
                </p>
                <div name='div'>
                    <a href='./details.php?id=" . $ImageID . "'>" . $array['Title'] . "</a><br><br>
                    <p class='content' name='p'>" . $array['Description'] . "</p>
                </div>
            </ul>";
            }

            mysqli_close($mysqli);
            ?>
            <ul class='last' style='border-top: none; height: 50px;'>
                <!-- 切换页面 -->
                <div style='text-align: center;'>
                    <span id='span'>
                        <?php
                        $num = ceil($maxrows / $page);
                        if ($num > 5) $num = 5;

                        echo "<a onclick='changePage(\"1\")'>&lt</a>";
                        $pn = $_GET['pn'];
                        if (!$pn) $pn = 0;
                        for ($i = 1; $i < $num + 1; $i++) {
                            echo  "<a id='" . (($pn + 1 == $i) ? 'now' : ('page' . $i)) . "' onclick='changePage(\"$i\")'>" . $i . "</a>";
                        }
                        echo "<a onclick='changePage(\"$num\")'>&gt</a>"
                        ?>
                    </span>
                </div>
            </ul>
        </filter>

        <div id='back-to-top' class='top_e'>
            <img src='../img/common/totop.png' width='40' height='40' id='img'>
        </div>
        <!-- <div id='refresh' class='refresh_e'>
            <img src='../img/common/refresh.png' width='40' height='40' id='img' onclick='alert('图片已更新')'>
        </div> -->

        <footer>
            <br><br>Copyright © 2019-2021 Web fundamental. All Rights Reserved. 备案号：19302010012
            <br>所有图片以及数据，均已进入幻想。
        </footer>
    </div>
</body>

</html>