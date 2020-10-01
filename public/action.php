<?php
echo '<pre>';
var_dump($_POST);
if (isset($_POST['predefined']) && isset($_POST['db_name']) && isset($_POST['db_rows']) && isset($_POST['db_tables_count'])) {
    $nameMan = file_get_contents("data/nameMan.json");
    $nameMan = json_decode($nameMan);
    $surnameMan = file_get_contents("data/surnameMan.json");
    $surnameMan = json_decode($surnameMan);
    $nameWoman = file_get_contents("data/nameWoman.json");
    $nameWoman = json_decode($nameWoman);
    $surnameWoman = file_get_contents("data/surnameWoman.json");
    $surnameWoman = json_decode($surnameWoman);

    $databaseName = $_POST['db_name'];
    $rowsNumber = $_POST['db_rows'];
    $tableNumber = $_POST['db_tables_count'];
    $tables = $_POST['tables'];

    $prefix = substr(md5(date("YmdHis")),0, 5);
    $databaseName = $prefix.'_'.$databaseName;

    $file = fopen($databaseName.'.sql', 'w+'); // create sql file

    fwrite($file, 'CREATE DATABASE IF NOT EXISTS `'.$databaseName.'`;'.PHP_EOL); // create database

    for($i=0;$i<$tableNumber;$i++){
        /** @noinspection SqlNoDataSourceInspection */
        fwrite($file, 'CREATE TABLE `'.$tables[$i]['title'].'`'.PHP_EOL.'('.PHP_EOL); // create X table
        for($j=0;$j<count($tables[$i])-1;$j++){ // for each column
            switch($tables[$i][$j]['scheme']){ // table variables, for each table scheme
                case "id": // case if id
                    // TODO  reszta case
                    if(!empty($tables[$i][$j]['title'])) fwrite($file, $tables[$i][$j]['title']);
                    else fwrite($file, "id");
                    fwrite($file, ' INT AUTO_INCREMENT PRIMARY KEY');
                    if($j<count($tables[$i])-2) fwrite($file, ','.PHP_EOL); // if not last, write ","
                    else fwrite($file, PHP_EOL); // if last, end of line
                    break;
                case "name": // case if name
                    if(!empty($tables[$i][$j]['title'])) fwrite($file, $tables[$i][$j]['title']);
                    else fwrite($file, "imie");
                    fwrite($file, ' VARCHAR(40) NOT NULL');
                    if($j<count($tables[$i])-2) fwrite($file, ','.PHP_EOL); // if not last, write ","
                    else fwrite($file, PHP_EOL); // if last, end of line
                    break;
                case "surname": // case if surname
                    if(!empty($tables[$i][$j]['title'])) fwrite($file, $tables[$i][$j]['title']);
                    else fwrite($file, "nazwisko");
                    fwrite($file, ' VARCHAR(40) NOT NULL');
                    if($j<count($tables[$i])-2) fwrite($file, ','.PHP_EOL); // if not last, write ","
                    else fwrite($file, PHP_EOL); // if last, end of line
                    break;
                case ""
            }
        }
        fwrite($file, ');'.PHP_EOL);
    }
//        fwrite($file, 'CREATE TABLE '.$databaseName.PHP_EOL.'('.PHP_EOL.'id INT AUTO_INCREMENT PRIMARY KEY,'.PHP_EOL.'imie VARCHAR(50) NOT NULL,'.PHP_EOL.'nazwisko VARCHAR(50) NOT NULL,'.PHP_EOL.'klasa VARCHAR(2) NOT NULL'.PHP_EOL.');'.PHP_EOL);
//        fwrite($file, 'INSERT INTO '.$databaseName.' VALUES '.PHP_EOL);
//        for($i=0;$i<$rowsNumber;$i++){
//            if(rand(0,1)==0){
//                fwrite($file, '(NULL, "'.$nameMan[rand(0,count($nameMan)-1)].'", "'.$surnameMan[rand(0,count($surnameMan)-1)].'", "'.rand(1,4).chr(rand(65,70))).'")';
//            } else {
//                fwrite($file, '(NULL, "'.$nameWoman[rand(0,count($nameWoman)-1)].'", "'.$surnameWoman[rand(0,count($surnameWoman)-1)].'", "'.rand(1,4).chr(rand(65,70))).'")';
//            }
//            if($i!=$rowsNumber-1) fwrite($file, '"),'.PHP_EOL);
//            else fwrite($file, '");'.PHP_EOL);
//        }
//
        fclose($file); // close file


} else {
    echo 'Brak danych.<br><a href="index.html">Powrót</a>';
}
?>