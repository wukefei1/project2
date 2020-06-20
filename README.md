# PJ2说明文档

----------
>   吴可非 19302010012
>   Github地址：[https://github.com/wukefei1/project2](https://github.com/wukefei1/project2)
>   网站地址：[http://wukefei.xyz:55555](http://wukefei.xyz:55555/)

## 项目完成情况
----------
>   设计文档中提到的所有功能均已完成
>   bonus(1)/(3)中提到的所有功能均已完成
>   PS:使用浏览器为新版Edge（在Chrome上应该也能正常运行）

### 首页

* 导航栏

    通过Cookie判断是否为登录状态并更改导航栏。

* 显示区域

    sql读取收藏最多的图片。不足六张则用随机图片补全。

```php
    $sql = "select ImageID,count(*) from travelimagefavor group by ImageID order by count(*) DESC";
```

* 刷新

    点击时会刷新页面，并读取随机图片。

* 注册和登录

    在后文会详细讲。

### 浏览页
* 侧边栏

    sql读取拥有最多图片的内容、国家、城市。点击时将其作为GET参数放入url中实现筛选。

* 标题筛选

    通过通配符%实现模糊筛选，代码如下：

```php
    $sql = "select ImageID from travelimage where Title like '%" . $title . "%' LIMIT $pn,$page";
```

* 多级筛选栏

    因为比较菜所以这里的二级联动是用php写的，代码比较糟糕。
    讲内容、国家、城市作为参数放入url中实现筛选。

* 分页

    在筛选时统计最大数量，若超出五页则赋为五页。
    url中同时传入代表页码的参数pn来实现分页，代码如下：

```php
    $sql = "select ImageID from travelimage where Title like '%" . $title . "%'";
    $result = mysqli_query($mysqli, $sql); //执行sql
    $maxrows = ($result) ? mysqli_num_rows($result) : 1;

    $sql = "select ImageID from travelimage where Title like '%" . $title . "%' LIMIT $pn,$page";
    $result = mysqli_query($mysqli, $sql); //执行sql
    $rows = ($result) ? mysqli_num_rows($result) : 0;

    ...

    $num = ceil($maxrows / $page);
    if ($num > 5) $num = 5;

    echo "<a onclick='changePage(\"1\")'>&lt</a>";
    $pn = $_GET['pn'];
    if (!$pn) $pn = 0;
    for ($i = 1; $i < $num + 1; $i++) {
        echo  "<a id='" . (($pn + 1 == $i) ? 'now' : ('page' . $i)) . "' onclick='changePage(\"$i\")'>" . $i . "</a>";
    }
    echo "<a onclick='changePage(\"$num\")'>&gt</a>"
```

### 搜索页
* 搜索部分

    模糊搜索同上。

* 图片展示部分

    同上。

### 上传界面
* 合法性校验

    由于图片库中的数据也可以没有图片描述以及城市，故这两项为选填，其他必填。

* 已上传图片的修改

    检验这张图是否为Cookie中储存的用户的，如果是的话就从数据库中读取数据，提交后修改数据库中原有数据。

### 我的照片、我的收藏
* 页码等功能

    同上。

* 删除照片

    我的照片中，删除按钮将同时删除数据库中所有对应数据，并删除本地库中该图片所有大小的复制。
    我的收藏中，删除按钮只删除数据库中该条收藏的记录。

### 登录界面、注册界面
* 注册

    用户名支持4-16位大小写字母、数字以及下划线、中划线、小数点。
    密码要求为6-20位大小写字母、数字。
    使用了哈希加盐储存盐值和密码。

* 登录

    输入的密码经处理后和数据库中的密码比对，相同则登录成功并记录Cookie。

### 图片详细信息
* 收藏按钮

    点击时跳转到另一个php文件以判断收藏状态并改变之，然后再跳回来。

## Bonus完成情况和解决方法

### 哈希加盐

* 实现方法

    代码如下，大致思路是注册时给用户赋随机的盐值，然后把通过sha1()得到的哈希值作为密码，登录时取出密码和盐值并执行sha1()后和密码对比即可。

```php
    $salt = base64_encode(random_bytes(32));
    $password = sha1($password1 . $salt);//register_judge.php
    ...

    if (sha1($password . $array['salt']) == $array['Pass']) {
        echo "登录成功！即将跳往首页";//login_judge.php
        ...
    }
```

### 服务器部署
* 网站地址

    [http://wukefei.xyz:55555](http://wukefei.xyz:55555/)

* 实现方法

    在阿里云上白嫖学生服务器，在腾讯云上购买了域名，在服务器上配置了各种服务后就可以通过域名和端口号访问了。

### 重置密码
* 实现方法

    通过用户名和邮箱验证，发送验证邮件确认是否是本人，然后进入重置密码界面。（顺带做了修改密码的功能）

* PS：

    在本地(localhost)上能正常使用，但是由于服务器的25端口不对外开放暂时无法在服务器上实现。

## 意见与建议
* 暂无

