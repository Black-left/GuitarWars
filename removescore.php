<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<h2>Guitar Wars - 删除分数确定</h2>

<?php
    require_once ('appvars.php');
    require_once ('connectvars.php');

    if(isset($_GET['id'])&&isset($_GET['date'])&& isset($_GET['name']) && isset($_GET['score']) && isset($_GET['screenshot'])){
        //创建变量并存储URL传递的值
        $id = $_GET['id'];
        $date = $_GET['date'];
        $name = $_GET['name'];
        $score = $_GET['score'];
        $screenshot = $_GET['screenshot'];
    }else if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['score'])){
        //创建变量并存储表单传递的值
        $id = $_POST['id'];
        $name = $_POST['name'];
        $score = $_POST['score'];
    }else{
        echo '<p class="error">对不起，出现问题</p>';
    }

    if(isset($_POST['submit'])){
        if($_POST['confirm']=='Yes'){
            //删除图片资源
            @unlink(GW_UPLOADPATH . $screenshot);
            //连接数据库删除记录
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $query = "DELETE FROM guitarwars WHERE id = $id LIMIT 1";
            mysqli_query($dbc,$query);
            mysqli_close($dbc);
            echo '<p>高分 ' . $score . ' ： ' . $name . ' 成功移除</p>';
        }else{
            echo '<p class="error">此分数没有被移除</p>';
        }
    }else if(isset($id) && isset($name) && isset($date) && isset($score)){
        echo '<p>你是否确定要删除下面的这条高分记录？</p>';
        echo '<p><strong>名字: </strong>' . $name . '<br /><strong>日期: </strong>' . $date .
            '<br /><strong>分数: </strong>' . $score . '</p>';
        echo '<form method="post" action="removescore.php">';
        echo '<input type="radio" name="confirm" value="Yes" /> 是的 ';
        echo '<input type="radio" name="confirm" value="No" checked="checked" /> 不 <br />';
        echo '<input type="submit" value="提交" name="submit" />';
        echo '<input type="hidden" name="id" value="' . $id . '" />';
        echo '<input type="hidden" name="name" value="' . $name . '" />';
        echo '<input type="hidden" name="score" value="' . $score . '" />';
        echo '</form>';
    }

    echo '<p><a href="admin.php">&lt;&lt; 返回管理</a></p>';
?>

</body>
</html>
