<?php
include('connect.php');
include('compress.php');

$UID = $_COOKIE['Username'];
$ImageID = isset($_GET['ImageID']) ? $_GET['ImageID'] : ' ';
$country = isset($_POST['country']) ? $_POST['country'] : ' ';
$city = isset($_POST['city']) ? $_POST['city'] : ' ';
$content = isset($_POST['content']) ? $_POST['content'] : ' ';
$title = isset($_POST['title']) ? $_POST['title'] : ' ';
$description = isset($_POST['description']) ? $_POST['description'] : ' ';

if ($ImageID  == '') $ImageID = ' ';
if ($country == '') $country = ' ';
if ($city == '') $city = ' ';
if ($content == '') $content = ' ';
if ($title == '') $title = ' ';
if ($description == '') $description = ' ';


if ($city != ' ') {
    $sql = "select GeoNameID from geocities where AsciiName='$city'";
    $result = mysqli_query($mysqli, $sql); //执行sql
    $array = mysqli_fetch_array($result);
    $city = $array['GeoNameID'];
}

if (
    (isset($_FILES['file0'])
        && is_uploaded_file($_FILES['file0']['tmp_name']) || $ImageID != ' ')
    && $country != ' '
    && $content != ' '
    && $title != ' '
) {
    if ($ImageID == ' ') {
        $file0 = $_FILES['file0'];
        $upErr = $file0['error'];
        if ($upErr == 0) {
            $imgType = $file0['type'];
            if (
                $imgType == 'image/jpeg'
                || $imgType == 'image/jpg'
                || $imgType == 'image/png'
            ) {
                $imgFileName = $file0['name'];
                $imgSize = $file0['size'];
                $imgTmpFile = $file0['tmp_name'];
                $salt = base64_encode(random_bytes(8));
                $imgFileName = sha1($imgFileName . $salt) . '.png';
                $PATH = $imgFileName;
                move_uploaded_file($imgTmpFile, '../img/travel-images/large/' . $imgFileName);
                $source = '../img/travel-images/large/' . $imgFileName;
                $dst_img = '../img/travel-images/medium/' . $imgFileName; //可加存放路径
                $percent = 0.625;
                $image = (new imgcompress($source, $percent))->compressImg($dst_img);
                $source = '../img/travel-images/large/' . $imgFileName;
                $dst_img = '../img/travel-images/small/' . $imgFileName; //可加存放路径
                $percent = 5 / 16;
                $image = (new imgcompress($source, $percent))->compressImg($dst_img);
                $source = '../img/travel-images/large/' . $imgFileName;
                $dst_img = '../img/travel-images/thumb/' . $imgFileName; //可加存放路径
                $percent = 25 / 256;
                $image = (new imgcompress($source, $percent))->compressImg($dst_img);

                $q = "insert into travelimage(Title," . ($description == ' ' ? '' : 'Description,') . ($city == ' ' ? '' : 'CityCode,') . "Country_RegionCodeISO,PATH,UID,Content) values ('$title'," . ($description == ' ' ? '' : "'$description',") . ($city == ' ' ? '' : "'$city',") . "'$country','$PATH','$UID','$content')";
                $result = mysqli_query($mysqli, $q); //执行sql
                if ($result) {
                    echo "<script type='text/javascript'>alert('上传成功！即将跳往我的照片界面');</script>";
                    header("refresh:0;url=./my_photos.php");
                    exit;
                } else {
                    echo "<script type='text/javascript'>alert('表单有错误！');location='javascript:history.back()';</script>";
                    exit;
                }
            } else {
                echo "请选择jpg或png文件，不支持其它类型的文件。";
                echo "
        <script>
            setTimeout(function(){location='javascript:history.back()';},1000);
        </script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('文件上传失败！');</script>";
            switch ($upErr) {
                case 1:
                    echo "超过了php.ini中设置的上传文件大小。";
                    break;
                case 2:
                    echo "超过了MAX_FILE_SIZE选项指定的文件大小。";
                    break;
                case 3:
                    echo "文件只有部分被上传。";
                    break;
                case 4:
                    echo "文件未被上传。";
                    break;
                case 5:
                    echo "上传文件大小为0";
                    break;
            }
            echo "
        <script>
            setTimeout(function(){location='javascript:history.back()';},1000);
        </script>";
        }
    }
    if ($ImageID != ' ') {
        $file0 = $_FILES['file0'];
        $upErr = $file0['error'];
        if ($upErr == 0) {
            $imgType = $file0['type'];
            if (
                $imgType == 'image/jpeg'
                || $imgType == 'image/jpg'
                || $imgType == 'image/png'
            ) {
                $imgFileName = $file0['name'];
                $imgSize = $file0['size'];
                $imgTmpFile = $file0['tmp_name'];
                $salt = base64_encode(random_bytes(8));
                $imgFileName = sha1($imgFileName . $salt) . '.png';
                $PATH = $imgFileName;
                move_uploaded_file($imgTmpFile, '../img/travel-images/large/' . $imgFileName);
                $source = '../img/travel-images/large/' . $imgFileName;
                $dst_img = '../img/travel-images/medium/' . $imgFileName; //可加存放路径
                $percent = 0.625;
                $image = (new imgcompress($source, $percent))->compressImg($dst_img);
                $source = '../img/travel-images/large/' . $imgFileName;
                $dst_img = '../img/travel-images/small/' . $imgFileName; //可加存放路径
                $percent = 5 / 16;
                $image = (new imgcompress($source, $percent))->compressImg($dst_img);
                $source = '../img/travel-images/large/' . $imgFileName;
                $dst_img = '../img/travel-images/thumb/' . $imgFileName; //可加存放路径
                $percent = 25 / 256;
                $image = (new imgcompress($source, $percent))->compressImg($dst_img);

                $q = "insert into travelimage(Title," . ($description == ' ' ? '' : 'Description,') . ($city == ' ' ? '' : 'CityCode,') . "Country_RegionCodeISO,PATH,UID,Content) values ('$title'," . ($description == ' ' ? '' : "'$description',") . ($city == ' ' ? '' : "'$city',") . "'$country','$PATH','$UID','$content')";
                $result = mysqli_query($mysqli, $q); //执行sql
                if ($result) {
                    echo "<script type='text/javascript'>alert('上传成功！即将跳往我的照片界面');</script>";
                    header("refresh:0;url=./my_photos.php");
                    exit;
                } else {
                    echo "<script type='text/javascript'>alert('表单有错误！');location='javascript:history.back()';</script>";
                    exit;
                }
            } else {
                echo "请选择jpg或png文件，不支持其它类型的文件。";
                echo "
        <script>
            setTimeout(function(){location='javascript:history.back()';},1000);
        </script>";
            }
        } else {
            $PATH = ' ';
        }
        if ($title != ' ') {
            $q1 = "update travelimage set Title = '$title' where ImageID = '$ImageID'";
            $r1 = mysqli_query($mysqli, $q1);
        }
        if ($description != ' ') {
            $q2 = "update travelimage set Description = '$description' where ImageID = '$ImageID'";
            $r2 = mysqli_query($mysqli, $q2);
        }
        if ($city != ' ') {
            $q3 = "update travelimage set CityCode = '$city' where ImageID = '$ImageID'";
            $r3 = mysqli_query($mysqli, $q3);
        }
        if ($Country_RegionCodeISO != ' ') {
            $q4 = "update travelimage set Country_RegionCodeISO = '$country' where ImageID = '$ImageID'";
            $r4 = mysqli_query($mysqli, $q4);
        }
        if ($PATH != ' ') {
            $q5 = "update travelimage set PATH = '$PATH' where ImageID = '$ImageID'";
            $r5 = mysqli_query($mysqli, $q5);
        }
        echo "<script type='text/javascript'>alert('修改成功！即将跳往我的照片界面');</script>";
        header("refresh:0;url=./my_photos.php");
        exit;
    }
} else {
    echo "<script type='text/javascript'>alert('请填写完表单后再提交！');location='javascript:history.back()';</script>";
    exit;
}

header("refresh:0;url=./my_photos.php");

mysqli_close($mysqli);
