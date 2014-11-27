<?php

  echo '* Script start...', PHP_EOL;

  CONST _HOST     = '127.0.0.1';
  CONST _USER     = 'root';
  CONST _PASSWORD = 'kldu57nv';
  CONST _DATABASE = 'temp';
  
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
              iconv('windows-1251', 'utf-8', $row['detail'])."','".
              iconv('windows-1251', 'utf-8', $row['brand'])."','".
              iconv('windows-1251', 'utf-8', $r['detail'])."','".
              iconv('windows-1251', 'utf-8', $r['brand'])."'),";
        }
      }
    }
    $insertStr = substr($insertStr, 0, -1);
    _setQuery("insert ignore into analogue_orig values ".$insertStr);
    
    $insertStr = "insert ignore into analogue_orig_cp1251 values ".$insertStr;
    $queryInsert = iconv('utf-8', 'windows-1251', $insertStr);
    _setQuery($queryInsert);
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
    
    /*mysql_query ("set_client='utf8'");
    mysql_query ("set character_set_results='utf8'");
    mysql_query ("set collation_connection='utf8_general_ci'");
    mysql_query ("SET NAMES utf8");*/
    
    $result = @mysql_query($query, $db);
    if (mysql_num_rows($result) > 0) {
      mysql_data_seek($result, 0);

      while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $resultArray[] = $row;
      }
      /*mysql_free_result($result);
      mysql_close($db);*/
    } /*else {
      mysql_close($db);
      return array();
    }*/
    
    return $resultArray;
  }
  
  function _setQuery($query, $databaseName = null) {
    $db = @mysql_connect(_HOST, _USER, _PASSWORD);
    if (is_null($databaseName)) {
      @mysql_select_db(_DATABASE, $db);
    } else {
      @mysql_select_db($databaseName, $db);
    }
    
    /*mysql_query ("set_client='utf8'");
    mysql_query ("set character_set_results='utf8'");
    mysql_query ("set collation_connection='utf8_general_ci'");
    mysql_query ("SET NAMES utf8");*/
    
    @mysql_query($query, $db);
    mysql_close($db);
  }