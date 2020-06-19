<!DOCTYPE html>
<html lang='zh-CN'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='css/reset.css'>
    <link rel='stylesheet' href='css/common.css'>
    <link rel='stylesheet' href='css/home.css'>
    <title>home</title>

    <!-- <script type='text/javascript'>
        //事件一
        function
        myfunction(obj, type, fn) {
            if (obj.attachEvent) {
                obj.attachEvent('on' + type, function () {
                    fn.call(obj);
                })
            } else {
                obj.addEventListener(type, fn, false);
            }
        }
        myfunction(window, 'scroll', function () {
            var
                tymnc =
                document.documentElement.scrollTop ||
                document.body.scrollTop;
            var
                mydiv =
                document.getElementById('test');
            if (tymnc >= 100) {
                mydiv.style.position = 'fixed';
                mydiv.style.top = '100px';
                mydiv.style.right = '100px';
            } else {
                mydiv.style.position = 'relative';
                mydiv.style.top = '0px';
                mydiv.style.right = '-60px';
            }
        });
    </script> -->
    <script src='js/home.js'></script>
    <script src='http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js'></script>
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
                <li><a class='navigation' href='./home.php' id='chosen'>首页</a></li>
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

        <img id='toutu' src='../img/home/toutu.jpg'>
        <!-- 头图 -->

        <table id='table'>
            <!-- 图片展示 -->
            <?php
            include('connect.php'); //链接数据库
            include('random.php');
            $sql = "select ImageID from travelimage order by ImageID DESC LIMIT 0,1";
            $result = mysqli_query($mysqli, $sql); //执行sql
            $array = mysqli_fetch_array($result);
            $num = $array['ImageID'];
            $id = array();

            $type = $_GET['type'];
            if ($type) {
                $random = getRandom($num);
                $l = 0;
                for ($i = 0; $i < 6; $i++) {
                    while (true) {
                        $flag = true;
                        $ImageID = $random[$l];
                        $sql = "select ImageID from travelimage where ImageID = '$ImageID' and PATH IS NOT NULL";
                        $result = mysqli_query($mysqli, $sql); //执行sql
                        $rows = mysqli_num_rows($result);
                        if ($rows == 0) {
                            $flag = false;
                            $l++;
                        }
                        if ($flag) break;
                    }
                    $id[$i] = $random[$l++];
                }
            } else {
                $sql = "select ImageID,count(*) from travelimagefavor group by ImageID order by count(*) DESC";
                $result = mysqli_query($mysqli, $sql); //执行sql
                $rows = mysqli_num_rows($result);
                for ($i = 0; $i < $rows; $i++) {
                    $array = mysqli_fetch_array($result);
                    $id[$i] = $array['ImageID'];
                }
                $random = getRandom($num);
                $l = 0;
                for ($i = $rows; $i < 6; $i++) {
                    while (true) {
                        $flag = true;
                        for ($j = 0; $j < $rows; $j++) {
                            if ($random[$l] == $id[$j]) {
                                $flag = false;
                                $l++;
                                break;
                            }
                            $ImageID = $random[$l];
                            $sql = "select ImageID from travelimage where ImageID = '$ImageID' and PATH IS NOT NULL";
                            $result = mysqli_query($mysqli, $sql); //执行sql
                            $rows = mysqli_num_rows($result);
                            if ($rows == 0) {
                                $flag = false;
                                $l++;
                                break;
                            }
                        }
                        if ($flag) break;
                    }
                    $id[$i] = $random[$l++];
                }
            }
            for ($i = 0; $i < 2; $i++) {

                echo "<tr>";
                for ($j = 0; $j < 3; $j++) {
                    $ImageID = $id[3 * $i + $j];
                    $sql = "select * from travelimage where ImageID = '$ImageID'";
                    $result = mysqli_query($mysqli, $sql); //执行sql
                    $array = mysqli_fetch_array($result);
                    if ($array['Description'] == NULL) {
                        $array['Description'] = "该图片暂无简介！";
                    }
                    echo "<td class='show' name='td'>
                    <div name='div'>
                        <a href='./details.php?id=" . $ImageID . "'><img src='../img/travel-images/small/" . $array['PATH'] . "' onload='Zoom(this,350,280)' name='img'></a>
                    </div>
                    <br>
                    <a href='./details.php" . $ImageID . "' class='title' name='a'>" . $array['Title'] . "</a>
                    <p class='content' name='p'>" . $array['Description'] . "</p>
                </td>";
                }
                echo "</tr>";
            }
            mysqli_close($mysqli); //关闭数据库
            ?>
        </table>

        <div id='back-to-top' class='top_e'>
            <img src='../img/common/totop.png' width='40' height='40' id='img'>
        </div>
        <!-- 返回顶部 -->
        <div id='refresh' class='refresh_e'>
            <img src='../img/common/refresh.png' width='40' height='40' id='img' onclick='javascript:refresh()'>
            <script type="text/javascript">
                function refresh() {
                    document.location.href = "?type=refresh";
                }
            </script>
        </div>
        <!-- 刷新 -->
    </div>

    <footer id='footer'>
        <!-- 页脚 -->
        <table>
            <tr>
                <td>
                    使用条款
                </td>
                <td>
                    关于
                </td>
            </tr>
            <tr>
                <td>
                    隐私保护
                </td>
                <td>
                    联系我们
                </td>
            </tr>
            <tr>
                <td>
                    Cookie
                </td>
            </tr>
        </table>
        <img src='../img/home/github.png' style='top:120px;left: 900px;' id='img11'>
        <img src='../img/home/shot.png' style='top:40px;left: 900px;' id='img12'>
        <img src='../img/home/tencent.png' style='top:120px;left: 820px;' id='img21'>
        <img src='../img/home/weixin.png' style='top:40px;left: 820px;' id='img22'>
        <img src='../img/home/footer.png' id='myweixin'>
        <p>Copyrightc © 2019-2021 Web fundamental. All Rights Reserved. 备案号：19302010012</p>
    </footer>
</body>

</html>