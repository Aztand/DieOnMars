<?php
session_start();
if(empty($_COOKIE["user"])){
    $url = "http://106.53.108.210/DieOnMars/login"; 
    header("Location: $url");    
}
if(isset($_GET["choose"])){
    $f_i1 = fopen("data/gameData/".$_GET["choose"].".json", "r") or die("error");
    $json = fread($f_i1,filesize("data/gameData/".$_GET["choose"].".json"));//读取json
    fclose($f_i1);
    echo $json;//显示json

    //更新选项数据
    $f_i = fopen("data/user/".$_COOKIE["user"]."/choices", "a+") or die("error");

    if(filesize("data/user/".$_COOKIE["user"]."/choices")){//判断是否新开存档
        fwrite($f_i,"\n".$_GET["choose"]);
    }
    else{
        fwrite($f_i,$_GET["choose"]);
    }

    fclose($f_i);
}
?>