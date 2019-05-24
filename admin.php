<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h2>Guitar Wars - 高分管理</h2>
    <p>以下列出所有的人的内容</p>
    <hr/>

<?php
//引入
require_once('appvars.php');
require_once('connectvars.php');

//连接数据库,执行SQL语句
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$query = "SELECT * FROM guitarwars ORDER BY score DESC ,`date` ASC";
$data = mysqli_query($dbc, $query);

echo '<table>';
//循环输出所有的内容
while ($row = mysqli_fetch_array($data)) {
    echo '<tr class="scorerow">';
    echo '<td><strong>' . $row['name'] . '</strong></td>';
    echo '<td>' . $row['date'] . '</td>';
    echo '<td>' . $row['score'] . '</td>';
    echo '<td><a href="removescore.php?id=' . $row['id'] . '&amp;date=' . $row['date'] .
        '&amp;name=' . $row['name'] . '&amp;score=' . $row['score'] .
        '&amp;screenshot=' . $row['screenshot']
        . '">删除</a></td>';
    echo '</tr>';
}
echo '</table>';

//关闭连接的数据库
mysqli_close($dbc);
?>

</body>
</html>
