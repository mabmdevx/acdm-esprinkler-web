<?php
   class MyDB extends SQLite3
   {
      function __construct()
      {
         $this->open('sysdb/test.db');
      }
   }
   
   $db = new MyDB();
   
   if(!$db){
      echo $db->lastErrorMsg();
   } else {
      echo "Opened database successfully\n";
   }

   $sql =<<<EOF
      SELECT * from COMPANY;
EOF;

   $ret = $db->query($sql);
   
   echo "<pre>";
   $res=$ret->fetchArray(SQLITE3_ASSOC);
   var_dump($res);
   
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
      echo "ID = ". $row['ID'] . "\n";
      echo "NAME = ". $row['NAME'] ."\n";
      echo "ADDRESS = ". $row['ADDRESS'] ."\n";
      echo "SALARY =  ".$row['SALARY'] ."\n\n";
   }
   echo "Operation done successfully\n";
   
   
   
   $db->close();
?>