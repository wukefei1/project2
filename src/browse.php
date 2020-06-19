<!DOCTYPE html>
<html lang='zh-CN'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='css/reset.css'>
    <link rel='stylesheet' href='css/common.css'>
    <link rel='stylesheet' href='css/browse.css'>
    <title>browse</title>
    <script src='js/browse.js'></script>
    <script src='js/jquery.js'></script>
    <script src='js/common.js'></script>
</head>

<body>
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
                <li><a class='navigation' href='./browse.php' id='chosen'>浏览</a></li>
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
        <aside style='top:97px'>
            <!-- 侧边栏 -->
            <ul class='first'>按标题搜索</ul>
            <ul class='last' style='padding: 0; height: 40px;text-indent: 0;'>
                <form name='form0' method='POST' action='./browse.php?type=5&pn=0'>
                    <input type='text' name='title' required>
                    <input type='submit' value='搜索' name='submit'><br>
                </form>
            </ul><br>

            <ul class='first'>热门内容</ul>
            <?php
            include('connect.php');
            $sql = "select Content,count(*) from travelimage where Content IS NOT NULL group by Content order by count(*) DESC LIMIT 0,6";
            $result = mysqli_query($mysqli, $sql); //执行sql
            $rows = mysqli_num_rows($result);
            $content = array();
            for ($i = 0; $i < $rows; $i++) {
                $array = mysqli_fetch_array($result);
                $content[$i] = $array['Content'];
            }
            for ($i = 0; $i < $rows - 1; $i++) {
                echo "<ul><a href='./browse.php?type=1&hotcontent=" . $content[$i] . "&pn=0'>" . $content[$i] . "</a></ul>";
            }
            echo "<ul class='last'><a href='./browse.php?type=1&hotcontent=" . $content[$rows - 1] . "&pn=0'>" . $content[$rows - 1] . "</a></ul><br>";
            mysqli_close($mysqli);
            ?>
            <ul class='first'>热门国家</ul>
            <?php
            include('connect.php');
            $sql = "select Country_RegionCodeISO,count(*) from travelimage where Country_RegionCodeISO IS NOT NULL group by Country_RegionCodeISO order by count(*) DESC LIMIT 0,5";
            $result = mysqli_query($mysqli, $sql); //执行sql
            $rows = mysqli_num_rows($result);
            $Country_RegionCodeISO = array();
            $country = array();
            for ($i = 0; $i < $rows; $i++) {
                $array = mysqli_fetch_array($result);
                $Country_RegionCodeISO[$i] = $array['Country_RegionCodeISO'];
                $sql_temp = "select * from geocountries_regions where ISO = '" . $Country_RegionCodeISO[$i] . "'";
                $result_temp = mysqli_query($mysqli, $sql_temp); //执行sql
                $array_temp = mysqli_fetch_array($result_temp);
                $country[$i] = $array_temp['Country_RegionName'];
            }
            for ($i = 0; $i < $rows - 1; $i++) {
                echo "<ul><a href='./browse.php?type=2&hotcountry=" . $Country_RegionCodeISO[$i] . "&pn=0'>" . $country[$i] . "</a></ul>";
            }
            echo "<ul class='last'><a href='./browse.php?type=2&hotcountry=" . $Country_RegionCodeISO[$rows - 1] . "&pn=0'>" . $country[$rows - 1] . "</a></ul><br>";
            mysqli_close($mysqli);
            ?>

            <ul class='first'>热门城市</ul>
            <?php
            include('connect.php');
            $sql = "select CityCode,count(*) from travelimage where CityCode IS NOT NULL group by CityCode order by count(*) DESC LIMIT 0,5";
            $result = mysqli_query($mysqli, $sql); //执行sql
            $rows = mysqli_num_rows($result);
            $CityCode = array();
            $city = array();
            for ($i = 0; $i < $rows; $i++) {
                $array = mysqli_fetch_array($result);
                $CityCode[$i] = $array['CityCode'];
                $sql_temp = "select * from geocities where GeoNameID = '" . $CityCode[$i] . "'";
                $result_temp = mysqli_query($mysqli, $sql_temp); //执行sql
                $array_temp = mysqli_fetch_array($result_temp);
                $city[$i] = $array_temp['AsciiName'];
            }
            for ($i = 0; $i < $rows - 1; $i++) {
                echo "<ul><a href='./browse.php?type=3&hotcity=" . $CityCode[$i] . "&pn=0'>" . $city[$i] . "</a></ul>";
            }
            echo "<ul class='last'><a href='./browse.php?type=3&hotcity=" . $CityCode[$rows - 1] . "&pn=0'>" . $city[$rows - 1] . "</a></ul><br>";
            mysqli_close($mysqli);
            ?>
        </aside>

        <div id='back-to-top' class='top_e'>
            <img src='../img/common/totop.png' width='40' height='40' id='img'>
        </div>
        <!-- <div id='refresh' class='refresh_e'>
            <img src='../img/common/refresh.png' width='40' height='40' id='img' onclick='alert('图片已更新')'>
        </div> -->
    </div>

    <filter id='filter'>
        <!-- 过滤器 -->
        <ul class='first'>过滤器</ul>
        <ul style='text-indent: 0px;'>
            <form name='form1' method='POST' action='' style='position: relative;left: 20px;'>
                <?php
                include('connect.php');
                $country = isset($_GET['country']) ? $_GET['country'] : ' ';
                $city = isset($_GET['city']) ? $_GET['city'] : ' ';
                $content = isset($_GET['content']) ? $_GET['content'] : ' ';
                if ($country == '') $country = ' ';
                if ($city == '') $city = ' ';
                if ($content == '') $content = ' ';

                $sql = "select Content from travelimage group by Content";
                $result = mysqli_query($mysqli, $sql); //执行sql
                $rows = ($result) ? mysqli_num_rows($result) : 0;
                echo "<select name='content' id='content' onchange='jump(\"content\")'>";
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
                echo "<select name='country' id='country' onchange='jump(\"country\")'>";
                echo "<option value=' ' " . (($country == ' ') ? 'selected' : '') . ">请选择国家</option>";
                for ($i = 0; $i < $rows; $i++) {
                    $array = mysqli_fetch_array($result);
                    $temp1 = $array['Country_RegionName'];
                    $temp2 = $array['ISO'];
                    echo "<option value='$temp2' " . (($array['ISO'] == $country) ? 'selected' : '') . ">$temp1</option>";
                }
                echo "</select>";

                $sql = "select GeoNameID,AsciiName from geocities where Country_RegionCodeISO='$country'";
                $result = mysqli_query($mysqli, $sql);
                $rows = ($result) ? mysqli_num_rows($result) : 0;
                echo "<select name='city' id='city' onchange='jump(\"city\")'>";
                echo "<option value=' '" . (($city == ' ') ? 'selected' : '') . ">请选择城市</option>";
                for ($i = 0; $i < $rows; $i++) {
                    $array = mysqli_fetch_array($result);
                    $temp1 = $array['AsciiName'];
                    $temp2 = $array['GeoNameID'];
                    echo "<option value='$temp2' " . (($array['GeoNameID'] == $city) ? 'selected' : '') . ">$temp1</option>";
                }
                echo "</select>";

                echo "<input type='button' value='过滤' name='filter' onclick='jump1()'>";
                mysqli_close($mysqli);
                ?>
            </form>
        </ul>
        <ul style='height: fit-content;'>
            <table>
                <?php
                $page = 16;

                include('connect.php'); //链接数据库
                include('random.php');
                $type = $_GET['type'];
                $pn = $_GET['pn'] * $page;
                if (!$pn) $pn = 0;
                $id = array();
                $rows = $page;
                $maxrows = $page;

                if (!$type) {
                    $l = 1;
                    for ($i = 0; $i < $rows; $i++) {
                        while (true) {
                            $flag = true;
                            $sql = "select ImageID from travelimage where ImageID = '$l' and PATH IS NOT NULL";
                            $result = mysqli_query($mysqli, $sql); //执行sql
                            $row = mysqli_num_rows($result);
                            if ($row == 0) {
                                $flag = false;
                                $l++;
                            }
                            if ($flag) break;
                        }
                        $id[$i] = $l++;
                    }
                } else {
                    if ($type == 5) {
                        $title = $_POST['title'];
                        if (!$title) {
                            echo "<script type='text/javascript'>alert('请填写后在搜索！');location='javascript:history.back()';</script>";
                            exit;
                        } else {
                            $sql = "select ImageID from travelimage where Title like '%" . $title . "%'";
                            $result = mysqli_query($mysqli, $sql); //执行sql
                            $maxrows = ($result) ? mysqli_num_rows($result) : 1;

                            $sql = "select ImageID from travelimage where Title like '%" . $title . "%' LIMIT $pn,$page";
                            $result = mysqli_query($mysqli, $sql); //执行sql
                            $rows = ($result) ? mysqli_num_rows($result) : 0;
                            for ($i = 0; $i < $rows; $i++) {
                                $array = mysqli_fetch_array($result);
                                $id[$i] = $array['ImageID'];
                            }
                        }
                    } else if ($type == 1) {
                        $content = $_GET['hotcontent'];
                        $sql = "select ImageID from travelimage where Content = '$content'";
                        $result = mysqli_query($mysqli, $sql); //执行sql
                        $maxrows = ($result) ? mysqli_num_rows($result) : 1;

                        $sql = "select ImageID from travelimage where Content = '$content' LIMIT $pn,$page";
                        $result = mysqli_query($mysqli, $sql); //执行sql
                        $rows = mysqli_num_rows($result);
                        for ($i = 0; $i < $rows; $i++) {
                            $array = mysqli_fetch_array($result);
                            $id[$i] = $array['ImageID'];
                        }
                    } else if ($type == 2) {
                        $content = $_GET['hotcountry'];
                        $sql = "select ImageID from travelimage where Country_RegionCodeISO = '$content'";
                        $result = mysqli_query($mysqli, $sql); //执行sql
                        $maxrows = ($result) ? mysqli_num_rows($result) : 1;

                        $sql = "select ImageID from travelimage where Country_RegionCodeISO = '$content' LIMIT $pn,$page";
                        $result = mysqli_query($mysqli, $sql); //执行sql
                        $rows = mysqli_num_rows($result);
                        for ($i = 0; $i < $rows; $i++) {
                            $array = mysqli_fetch_array($result);
                            $id[$i] = $array['ImageID'];
                        }
                    } else if ($type == 3) {
                        $content = $_GET['hotcity'];
                        $sql = "select ImageID from travelimage where CityCode = '$content'";
                        $result = mysqli_query($mysqli, $sql); //执行sql
                        $maxrows = ($result) ? mysqli_num_rows($result) : 1;

                        $sql = "select ImageID from travelimage where CityCode = '$content' LIMIT $pn,$page";
                        $result = mysqli_query($mysqli, $sql); //执行sql
                        $rows = mysqli_num_rows($result);
                        for ($i = 0; $i < $rows; $i++) {
                            $array = mysqli_fetch_array($result);
                            $id[$i] = $array['ImageID'];
                        }
                    } else if ($type == 4) {
                        $content = isset($_GET['content']) ? $_GET['content'] : ' ';
                        $country = isset($_GET['country']) ? $_GET['country'] : ' ';
                        $city = isset($_GET['city']) ? $_GET['city'] : ' ';
                        if ($country == '') $country = ' ';
                        if ($city == '') $city = ' ';
                        if ($content == '') $content = ' ';
                        if ($content == ' ' && $country == ' ' && $city == ' ') {
                            echo "<script type='text/javascript'>alert('请选择后再搜索！');location='javascript:history.back()';</script>";
                            exit;
                        }
                        $sql = "select ImageID from travelimage where " . (($content == ' ') ? "" : " Content='$content' and ") . (($country == ' ') ? "" : " Country_RegionCodeISO='$country' and ") . (($city == ' ') ? "" : " CityCode='$city' and ") . "1";
                        $result = mysqli_query($mysqli, $sql); //执行sql
                        $maxrows = ($result) ? mysqli_num_rows($result) : 1;

                        $sql = "select ImageID from travelimage where " . (($content == ' ') ? "" : " Content='$content' and ") . (($country == ' ') ? "" : " Country_RegionCodeISO='$country' and ") . (($city == ' ') ? "" : " CityCode='$city' and ") . "1 LIMIT $pn,$page";
                        $result = mysqli_query($mysqli, $sql); //执行sql
                        $rows = ($result) ? mysqli_num_rows($result) : 0;
                        for ($i = 0; $i < $rows; $i++) {
                            $array = mysqli_fetch_array($result);
                            $id[$i] = $array['ImageID'];
                        }
                    } else {
                        echo "<script type='text/javascript'>alert('非法的搜索类型！');location='javascript:history.back()';</script>";
                        exit;
                    }
                }

                if ($rows == 0)
                    echo "该分类暂无图片！";

                for ($i = 0; $i < 4; $i++) {
                    echo "<tr>";
                    for ($j = 0; $j < 4; $j++) {
                        if ($i * 4 + $j >= $rows) continue;
                        $ImageID = $id[$i * 4 + $j];
                        $sql = "select PATH from travelimage where ImageID = '$ImageID'";
                        $result = mysqli_query($mysqli, $sql); //执行sql
                        $array = mysqli_fetch_array($result);
                        echo "<td>
                        <div name='row" . ($j + 1) . "'>
                        <a href='./details.php?id=" . $ImageID . "'><img src='../img/travel-images/small/" . $array['PATH'] . "' onload='Zoom(this,220,220)' name='img'></a>
                        </div>
                    </td>";
                    }
                    echo "</tr>";
                }

                mysqli_close($mysqli);
                ?>
            </table>
        </ul>
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
    <?php
    if ($rows > 8) {
        echo "<footer>";
    } else {
        echo "<footer style='position:absolute;bottom:-300px'>";
    }
    ?>
    <br><br>Copyright © 2019-2021 Web fundamental. All Rights Reserved. 备案号：19302010012
    </footer>
</body>

</html>