<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Guitar Wars - 添加你的高分数</h2>
</body>
</html>
<?php
require_once('appvars.php');
require_once('connectvars.php');

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $score = $_POST['score'];
    $screenshot = $_FILES['screenshot']['name'];//文件名称
    $screenshot_type = $_FILES['screenshot']['type'];//文件类型
    $screenshot_size = $_FILES['screenshot']['size'];//文件大小
    //判定如果内容为非空时
    if (!empty($name) && !empty($score) && !empty($screenshot)) {
        if (($screenshot_type == 'image/gif') || ($screenshot_type == 'image/jpeg') || ($screenshot_type == 'image/pjpeg') || ($screenshot_type == 'image/png')
            && ($screenshot_size > 0) && ($screenshot_size <= GW_MAXFILESIZE)
        ) {
            if ($_FILES['screenshot']['error'] == 0) {
                //do something
                $target = GW_UPLOADPATH . $screenshot;
                if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $target)) {
                    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                    $query = "INSERT INTO guitarwars VALUES (0,NOW(),'$name','$score','$screenshot')";//$screenshot是图片的名称
                    //执行sql
                    mysqli_query($dbc, $query);

                    //确定成功
                    echo '<p>感谢上传你的分数：</p>';
                    echo '<p><strong>名字:</strong> ' . $name . '<br />';
                    echo '<strong>分数:</strong> ' . $score . '</p>';
                    echo '<img src="' . GW_UPLOADPATH . $screenshot . '" alt="Score image" /></p>';
                    echo '<p><a href="index.php">&lt;&lt; 返回高分首页</a></p>';

                    //清空用户信息
                    $name = "";
                    $score = "";

                    //关闭数据库
                    mysqli_close($dbc);
                }
            }else{
                echo '<p class="error">对不起图片错误</p>';
            }

        }else{
            echo '<p class="error">图片必须时 GIF,JPEG,or PNG 格式并且不能超过'.
                (GW_MAXFILESIZE / 1024).'KB这么大</p>';
        }

        @unlink($_FILES['screenshot']['tmp_name']);//删除临时的图片文件
    } else {
        echo '<p class="error">请输入所有内容并选择图片</p>';
    }
}
?>
<hr>
<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <input type="hidden" name="MAX_FILE_SIZE" value="3276800">
    <label for="name">名字:</label>
    <input type="text" id="name" name="name" value="<?php if (!empty($name)) echo $name; ?>"/><br/>
    <label for="score">分数:</label>
    <input type="text" id="score" name="score" value="<?php if (!empty($score)) echo $score; ?>"/>
    <br>
    <label for="screenshot">分数截图:</label>
    <input type="file" id="screenshot" name="screenshot">
    <hr/>
    <input type="submit" value="添加" name="submit"/>
</form>
</body>
</html>
