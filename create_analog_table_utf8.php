<?php

  echo '* Script start...', PHP_EOL;

  CONST _HOST     = '127.0.0.1';
  CONST _USER     = 'root';
  CONST _PASSWORD = 'kldu57nv';
  CONST _DATABASE = 'temp_utf8';
  
  $query = "select `k`, count(*) from analogs_source group by `k` having count(*) > 1";
  $allKeys = _getQuery($query);
  
  $ix = 0;
  foreach ($allKeys as $key) {
    $ix++;
    echo $ix . '. ' . $key['k'] . PHP_EOL;
    $query = "select * from analogs_source as a where a.k = '".$key['k']."'";
    $rows = _getQuery($query);
    $rowsTemp = $rows;
    $insertStr = "";
    
    foreach ($rows as $row) {
      foreach ($rowsTemp as $r) {
        if ($row['id'] != $r['id']) {
          $insertStr .= "('".
              prepareCharset($row['detail'])."','".
              prepareCharset($row['brand']) ."','".
              prepareCharset($r['detail'])  ."','".
              prepareCharset($r['brand'])   ."'),";
        }
      }
    }
    $insertStr = substr($insertStr, 0, -1);
    _setQuery("insert ignore into analogue_orig values ".$insertStr);
    
    //$insertStr = "insert ignore into analogue_orig_cp1251 values ".$insertStr;
    //$queryInsert = iconv('utf-8', 'windows-1251', $insertStr);
    //_setQuery($queryInsert);
    //_setQuery($insertStr);
  }
  
  echo '* Script end.', PHP_EOL;
  
  
  function _getQuery($query, $databaseName = null) {
    $db = @mysql_connect(_HOST, _USER, _PASSWORD);
    if (is_null($databaseName)) {
      @mysql_select_db(_DATABASE, $db);
    } else {
      @mysql_select_db($databaseName, $db);
    }
    $resultArray = array();
    
    mysql_query ("set_client='utf8'");
    mysql_query ("set character_set_results='utf8'");
    mysql_query ("set collation_connection='utf8_general_ci'");
    mysql_query ("SET NAMES utf8");
    
    $result = @mysql_query($query, $db);
    if (mysql_num_rows($result) > 0) {
      mysql_data_seek($result, 0);

      while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $resultArray[] = $row;
      }
    }
    return $resultArray;
  }
  
  function _setQuery($query, $databaseName = null) {
    $db = @mysql_connect(_HOST, _USER, _PASSWORD);
    if (is_null($databaseName)) {
      @mysql_select_db(_DATABASE, $db);
    } else {
      @mysql_select_db($databaseName, $db);
    }
    
    mysql_query ("set_client='utf8'");
    mysql_query ("set character_set_results='utf8'");
    mysql_query ("set collation_connection='utf8_general_ci'");
    mysql_query ("SET NAMES utf8");
    
    @mysql_query($query, $db);
    mysql_close($db);
  }
  
  function prepareCharset($str) {
    $str = CyrillicToLatinica2($str);       //перегоняем кирилицу в латиницу
    //return preg_replace("/\W/",'',$str);    //[a-zA-Z0-9]
    return mb_strtolower($str, 'UTF-8');
  }
  
  function CyrillicToLatinica2($str_in) {
    $r = array('а','б','в','г','д','е','ё','ж','з','и','й','к','л','м', 'н','о','п','р','с','т','у','ф','х','ц','ч', 'ш', 'щ', 'ъ','ы','ь','э', 'ю', 'я', 
               'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М', 'Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч', 'Ш', 'Щ', 'Ъ','Ы','Ь','Э', 'Ю', 'Я');
    $l = array('a','b','v','g','d','e','e','g','z','i','y','k','l','m','n', 'o','p','r','s','t','u','f','h','c','ch','sh','sh','', 'y','y', 'e','yu','ya',
               'A','B','V','G','D','E','E','G','Z','I','Y','K','L','M','N', 'O','P','R','S','T','U','F','H','C','CH','SH','SH','', 'Y','Y', 'E','YU','YA');
    $str_out = str_replace($r, $l, $str_in);
    return $str_out;
  }
  
  function RemoveCharset($str) {
    $str = CyrillicToLatinica($str);
    return preg_replace("/[^A-Za-zА-Яа-я0-9]/", '', $str);
  }

  function CyrillicToLatinica($str) {
    $count = strlen($str);
    $temp = '';
    
    $dictionary = array(
      '224' => 'a',
      '225' => 'b',
      '226' => 'v',
      '246' => 'c',
      '247' => 'ch',
      '228' => 'd',
      '229' => 'e',
      '184' => 'e',
      '244' => 'f',
      '227' => 'g',
      '232' => 'i',
      '233' => 'y',
      '231' => 'z',
      '230' => 'j',
      '234' => 'k',
      '235' => 'l',
      '236' => 'm',
      '237' => 'n',
      '238' => 'o',
      '239' => 'p',
      '240' => 'r',
      '241' => 's',
      '248' => 'sh',
      '249' => 'sch',
      '242' => 't',
      '243' => 'u',
      '226' => 'v',
      '245' => 'h',
      '255' => 'ya',
      '254' => 'yu',
      '231' => 'z',
      '252' => '',
      '250' => '',
      '251' => 'q',
      '192' => 'a',
      '193' => 'b',
      '194' => 'v',
      '214' => 'c',
      '215' => 'ch',
      '196' => 'd',
      '197' => 'e',
      '168' => 'e',
      '212' => 'f',
      '195' => 'g',
      '200' => 'i',
      '201' => 'y',
      '221' => 'z',
      '198' => 'j',
      '202' => 'k',
      '203' => 'l',
      '204' => 'm',
      '205' => 'n',
      '206' => 'o',
      '207' => 'p',
      '208' => 'r',
      '209' => 's',
      '216' => 'sh',
      '217' => 'sch',
      '210' => 't',
      '211' => 'u',
      '194' => 'v',
      '213' => 'h',
      '223' => 'ya',
      '222' => 'yu',
      '199' => 'z',
      '220' => '',
      '218' => '',
      '219' => 'q'
    );

    for ($i = 0; $i < $count; $i++) {
      if (isset($dictionary[ord($str[$i])])) {
        $temp .= $dictionary[ord($str[$i])];
      } else {
        $temp .= $str[$i];
      }
    }
    return $temp;
  }