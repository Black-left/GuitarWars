<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style type="text/css">
        .error {
            font-weight: bold;
            color: #FF0000;
        }

        .topscoreheader {
            text-align: center;
            font-size: 200%;
            background-color: #36407F;
            color: #FFFFFF;
        }

        .score {
            font-size:150%;
            color: #36407F;
        }

        .scoreinfo {
            vertical-align: top;
            padding-right:15px;
        }

    </style>
</head>
<body>
  <h2>Guitar Wars - 高分</h2>
  <p>欢迎各位来到这个小小的demo处 ，<a href="addscore.php">添加你自己的分数吧</a>。</p>
  <hr />

<?php
require_once ('appvars.php');
require_once ('connectvars.php');
  //连接数据库连接
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  //调取分数内容
  $query = "SELECT * FROM guitarwars ORDER BY score DESC ";
  $data = mysqli_query($dbc, $query);
    $i = 0;

  echo '<table>';
  while ($row = mysqli_fetch_array($data)) {
      //显示最高分
      if($i == 0){
          echo '<tr><td colspan="2" class="topscoreheader">最高分:'.$row['score'].'</td></tr>';
      }

    echo '<tr><td class="scoreinfo">';
    echo '<span class="score">' . $row['score'] . '</span><br />';
    echo '<strong>姓名:</strong> ' . $row['name'] . '<br />';
    echo '<strong>日期:</strong> ' . $row['date'] . '</td>';
    if(is_file(GW_UPLOADPATH.$row['screenshot']) && filesize(GW_UPLOADPATH.$row['screenshot'])>0){
        echo '<td><img src="'.GW_UPLOADPATH.$row['screenshot'].'" alt="Score image" /></td></tr>';
    }else{
        echo '<td><img src="'.GW_UPLOADPATH.'unverified.png" alt="Unverified score" /></td></tr>';
    }
    $i++;
  }
  echo '</table>';

  mysqli_close($dbc);
?>

</body> 
</html>
