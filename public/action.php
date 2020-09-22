<?php
if(isset($_POST[''])) {
    $nameMan = file_get_contents("data/nameMan.json");
    $nameMan = json_decode($nameMan);
    $surnameMan = file_get_contents("data/surnameMan.json");
    $surnameMan = json_decode($surnameMan);
    $nameWoman = file_get_contents("data/nameWoman.json");
    $nameWoman = json_decode($nameWoman);
    $surnameWoman = file_get_contents("data/surnameWoman.json");
    $surnameWoman = json_decode($surnameWoman);

}
