<?php

  $r = array('а','б','в','г','д','е','ё','ж','з','и','й','к','л','м', 'н','о','п','р','с','т','у','ф','х','ц','ч', 'ш', 'щ', 'ъ','ы','ь','э', 'ю', 'я', 
             'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М', 'Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч', 'Ш', 'Щ', 'Ъ','Ы','Ь','Э', 'Ю', 'Я');
  $rs = array('а','б','в','г','д','е','ё','ж','з','и','й','к','л','м', 'н','о','п','р','с','т','у','ф','х','ц','ч', 'ш', 'щ', 'ъ','ы','ь','э', 'ю', 'я');
  $l = array('a','b','v','g','d','e','e','g','z','i','y','k','l','m','n', 'o','p','r','s','t','u','f','h','c','ch','sh','sh','', 'y','y', 'e','yu','ya',
             'A','B','V','G','D','E','E','G','Z','I','Y','K','L','M','N', 'O','P','R','S','T','U','F','H','C','CH','SH','SH','', 'Y','Y', 'E','YU','YA');
        
  /*foreach ($rs as $char) {
    echo $char, ' ', ord($char), PHP_EOL;
  }*/
  
  $str = 'тема';
  $strNew = prepareCharset($str);
  echo $strNew, PHP_EOL;
  
  function prepareCharset($str) {
    $str = CyrillicToLatinica2($str);    //перегоняем кирилицу в латиницу
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