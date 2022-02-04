<?php
session_start();
if(empty($_COOKIE["user"])){
    $url = "http://106.53.108.210/DieOnMars/login"; 
    header("Location: $url");    
}
?>

<html>

<head>
    <title>死在火星上</title>
    <link rel="shortcut icon" href="pic/DieOnMars.ico"/>
    <link rel="stylesheet" type="text/css" href="css/index.css" >
    <script src="js/jquery-3.6.0.min.js"></script>
</head>

<body >


<div id="game">
    <?php
        $f_i = fopen("data/user/".$_COOKIE["user"]."/choices", "r") or die("error");
        if(filesize("data/user/".$_COOKIE["user"]."/choices")!=0){

            function history($checking){
                $f_i1 = fopen("data/gameData/".$checking.".json", "r") or die("error");
                $json = fread($f_i1,filesize("data/gameData/".$checking.".json"));//读取json
                fclose($f_i1);
                $json=json_decode($json,true);

                if($checking!=1){
                    $i = 0;//输出历史选择
                    $j = count($json["chosen"]);
                    while($i<$j){
                        if($checking!=$json["chosen"][$i]["num"]){//标亮选择
                            echo '<button disabled>'.$json["chosen"][$i]["choice"]."</button>";
                        }
                        else{
                            echo '<button disabled class="clicked">'.$json["chosen"][$i]["choice"]."</button>";
                        }
                        $i++;
                    }
                }

                $i = 0;//输出历史消息
                $j = count($json["msg"]);
                while($i<$j){
                    echo '<p>'.$json["msg"][$i]["msg"]."</p>";
                    $i++;
                }
            }
            
            function showChoice($checking){
                $f_i1 = fopen("data/gameData/".$checking.".json", "r") or die("error");
                $json = fread($f_i1,filesize("data/gameData/".$checking.".json"));//读取json
                fclose($f_i1);
                $json=json_decode($json,true);

                $i = 0;//输出可选选择
                $j = count($json["choice"]);
                while($i<$j){
                    echo '<button id="'.$json["choice"][$i]["num"].'" onclick="choose('.$json["choice"][$i]["num"].')">'.$json["choice"][$i]["choice"].'</button>';//显示按钮并且设定id以及触发事件
                    $i++;
                }
            }

            while(!feof($f_i)) {
                $latest=trim(fgets($f_i));
                history($latest);
            }
            fclose($f_i);

            showChoice($latest);//显示选择
        }
            if(empty($latest)){
            echo '<p id="latest" hidden="true">1</p>';
        }
        else{
            echo '<p id="latest" hidden="true">'.$latest.'</p>';
        }
    
    echo '
</div>
<script type="text/javascript" src="js/game.js"></script>
    ';

    if(filesize("data/user/".$_COOKIE["user"]."/choices")==0){
        echo '<script type="text/javascript">choose(1);</script>';
    }
    ?>
</body>


</html>
