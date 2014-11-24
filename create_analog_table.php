<?php

  echo '* Script start...', PHP_EOL;

  CONST _HOST     = '127.0.0.1';
  CONST _USER     = 'root';
  CONST _PASSWORD = 'kldu57nv';
  CONST _DATABASE = 'temp';
  
  $query = "select * from analogs_source";
  $rowsAll = _getQuery($query);
  
  foreach ($rowsAll as $row) {
    $query = "select * from analogs_source as a where a.k = '".$row['k']."' and a.id <> ".$row['id'];
    $rows = _getQuery($query);
    if (count($rows) > 0) {
      foreach ($rows as $r) {
        //echo $row['brand'] . ' ' . $row['detail'] . ' ' . $r['brand'] . ' ' . $r['detail'] . PHP_EOL;
        $queryInsert = "insert into analogs_res values ('".$row['brand']."','".$row['detail']."','".$r['brand']."','".$r['detail']."')";
        _setQuery($queryInsert);
      }
    }
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
    
    /*
    mysql_query ("set_client='utf8'");
    mysql_query ("set character_set_results='utf8'");
    mysql_query ("set collation_connection='utf8_general_ci'");
    mysql_query ("SET NAMES utf8");
    */
    
    $result = @mysql_query($query, $db);
    if (mysql_num_rows($result) > 0) {
      mysql_data_seek($result, 0);

      while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $resultArray[] = $row;
      }
      mysql_free_result($result);
      mysql_close($db);
    } else {
      mysql_close($db);
      return array();
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
    
    @mysql_query($query, $db);
    mysql_close($db);
  }