<?php
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

    if(!is_dir('sql')) mkdir('sql');
    $fileDirectory = 'sql/'.date("Y-m-d_H-i-s_").$databaseName.'.sql';
    $file = fopen($fileDirectory, 'w+'); // create sql file

    $prefix = substr(md5(date("YmdHis")),0, 5);
    $databaseName = $prefix.'_'.$databaseName;

    fwrite($file, 'CREATE DATABASE IF NOT EXISTS `'.$databaseName.'`;'.PHP_EOL); // create database

    for($i=0;$i<$tableNumber;$i++){
        /** @noinspection SqlNoDataSourceInspection */
        fwrite($file, 'CREATE TABLE `'.$tables[$i]['title'].'`'.PHP_EOL.'('.PHP_EOL); // create X table
        for($j=0;$j<count($tables[$i])-1;$j++){ // for each column
            switch($tables[$i][$j]['scheme']){ // table variables, for each table scheme
                case "id": // case if id
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
                case "gender":
                    if(!empty($tables[$i][$j]['title'])) fwrite($file, $tables[$i][$j]['title']);
                    else fwrite($file, "plec");
                    fwrite($file, ' VARCHAR(1) NOT NULL');
                    if($j<count($tables[$i])-2) fwrite($file, ','.PHP_EOL); // if not last, write ","
                    else fwrite($file, PHP_EOL); // if last, end of line
                    break;
                case "class":
                    if(!empty($tables[$i][$j]['title'])) fwrite($file, $tables[$i][$j]['title']);
                    else fwrite($file, "klasa");
                    fwrite($file, ' VARCHAR(4) NOT NULL');
                    if($j<count($tables[$i])-2) fwrite($file, ','.PHP_EOL); // if not last, write ","
                    else fwrite($file, PHP_EOL); // if last, end of line
                    break;
                case "birthday":
                    if(!empty($tables[$i][$j]['title'])) fwrite($file, $tables[$i][$j]['title']);
                    else fwrite($file, "data_ur");
                    fwrite($file, ' DATE NOT NULL');
                    if($j<count($tables[$i])-2) fwrite($file, ','.PHP_EOL); // if not last, write ","
                    else fwrite($file, PHP_EOL); // if last, end of line
                    break;
                case "pesel":
                    if(!empty($tables[$i][$j]['title'])) fwrite($file, $tables[$i][$j]['title']);
                    else fwrite($file, "pesel");
                    fwrite($file, ' VARCHAR(11) NOT NULL');
                    if($j<count($tables[$i])-2) fwrite($file, ','.PHP_EOL); // if not last, write ","
                    else fwrite($file, PHP_EOL); // if last, end of line
                    break;
            }
        }
        fwrite($file, ');'.PHP_EOL);
        fwrite($file, 'INSERT INTO `'.$tables[$i]['title'].'` VALUES '.PHP_EOL); // insert to X tables
        for($k=0;$k<$rowsNumber;$k++){ // for K rows
            $gender = rand(0,1);
            $temp_class = "0";
            $temp_date = "";
            fwrite($file, '(');
            for($j=0;$j<count($tables[$i])-1;$j++) { // for each column
                switch ($tables[$i][$j]['scheme']) { // table variables, for each table scheme
                    case "id": // case if id
                        fwrite($file, 'NULL');
                        if($j<count($tables[$i])-2) fwrite($file, ', '); // if not last, write ", "
                        break;
                    case "name": // case if name
                        if($gender==0){ // if man
                            fwrite($file, '"'.$nameMan[rand(0,count($nameMan)-1)].'"');
                        } else { // if woman
                            fwrite($file, '"'.$nameWoman[rand(0,count($nameWoman)-1)].'"');
                        }
                        if($j<count($tables[$i])-2) fwrite($file, ', '); // if not last, write ", "
                        break;
                    case "surname": // case if surname
                        if($gender==0){ // if man
                            fwrite($file, '"'.$surnameMan[rand(0,count($surnameMan)-1)].'"');
                        } else { // if woman
                            fwrite($file, '"'.$surnameWoman[rand(0,count($surnameWoman)-1)].'"');
                        }
                        if($j<count($tables[$i])-2) fwrite($file, ', '); // if not last, write ", "
                        break;
                    case "gender": // case if gender
                        if($gender==0){ // if man
                            fwrite($file, '"M"');
                        } else { // if woman
                            fwrite($file, '"K"');
                        }
                        if($j<count($tables[$i])-2) fwrite($file, ', '); // if not last, write ", "
                        break;
                    case "class": // case if class
                        $temp_class = rand(1,4).chr(rand(65,70));
                        fwrite($file, '"'.$temp_class.'"');
                        if($j<count($tables[$i])-2) fwrite($file, ', '); // if not last, write ", "
                        break;
                    case "birthday": // case if birthday
                        switch($temp_class[0]){
                            case "1":
                                $temp_date_start = strtotime("2004-01-01");
                                $temp_date_end = strtotime("2004-12-31");
                                break;
                            case "2":
                                $temp_date_start = strtotime("2003-01-01");
                                $temp_date_end = strtotime("2003-12-31");
                                break;
                            case "3":
                                $temp_date_start = strtotime("2002-01-01");
                                $temp_date_end = strtotime("2002-12-31");
                                break;
                            case "4":
                                $temp_date_start = strtotime("2001-01-01");
                                $temp_date_end = strtotime("2001-12-31");
                                break;
                            default:
                                $temp_date_start = strtotime("1960-01-01");
                                $temp_date_end = strtotime("2000-12-31");
                                break;
                        }
                        $temp_date = date("Y-m-d", mt_rand($temp_date_start, $temp_date_end));
                        fwrite($file, '"'.$temp_date.'"');
                        if($j<count($tables[$i])-2) fwrite($file, ', '); // if not last, write ", "
                        break;
                    case "pesel": // case if pesel
                        fwrite($file, '"');
                        if(!empty($temp_date)){ // if date exist
                            fwrite($file, $temp_date[2].$temp_date[3].$temp_date[5].$temp_date[6].$temp_date[8].$temp_date[9]);
                        } else { // if date not exist
                            fwrite($file, rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9));
                        }
                        fwrite($file, rand(0,9).rand(0,9).rand(0,9)); // random 3 digits
                        if($gender==0) fwrite($file, (rand(1,5)*2-1)); // gender digit
                        else fwrite($file, (rand(0,4)*2));
                        fwrite($file, rand(0,9).'"'); // random control digit
                        if($j<count($tables[$i])-2) fwrite($file, ', '); // if not last, write ", "
                        break;
                }
            }
            if($k<$rowsNumber-1)fwrite($file, '), '.PHP_EOL);
            else fwrite($file, ');'.PHP_EOL);
        }
    }
        fclose($file); // close file
    echo 'Done.<br><br>';
    echo '<a href="'.$fileDirectory.'" download>Pobierz plik</a>';

} else {
    echo 'Brak danych.<br><a href="index.html">Powrót</a>';
}
?>