<?php
// predefined, database-name
/*if (isset($_POST['predefined'])) {
    if ($_POST['predefined'] == "pre-students-marks") {
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

        $prefix = substr(md5(date("YmdHis")),0, 5);

        $databaseName = $prefix.'_'.$databaseName;
        $file = fopen($databaseName.'.sql', 'w+');

        fwrite($file, 'CREATE DATABASE IF NOT EXISTS `database-generator`;'.PHP_EOL);
        fwrite($file, 'CREATE TABLE '.$databaseName.PHP_EOL.'('.PHP_EOL.'id INT AUTO_INCREMENT PRIMARY KEY,'.PHP_EOL.'imie VARCHAR(50) NOT NULL,'.PHP_EOL.'nazwisko VARCHAR(50) NOT NULL,'.PHP_EOL.'klasa VARCHAR(2) NOT NULL'.PHP_EOL.');'.PHP_EOL);
        fwrite($file, 'INSERT INTO '.$databaseName.' VALUES '.PHP_EOL);
        for($i=0;$i<$rowsNumber;$i++){
            if(rand(0,1)==0){
                fwrite($file, '(NULL, "'.$nameMan[rand(0,count($nameMan)-1)].'", "'.$surnameMan[rand(0,count($surnameMan)-1)].'", "'.rand(1,4).chr(rand(65,70))).'")';
            } else {
                fwrite($file, '(NULL, "'.$nameWoman[rand(0,count($nameWoman)-1)].'", "'.$surnameWoman[rand(0,count($surnameWoman)-1)].'", "'.rand(1,4).chr(rand(65,70))).'")';
            }
            if($i!=$rowsNumber-1) fwrite($file, '"),'.PHP_EOL);
            else fwrite($file, '");'.PHP_EOL);
        }

        fclose($file);


    }}*/
echo "<pre>";
var_dump($_POST);
?>