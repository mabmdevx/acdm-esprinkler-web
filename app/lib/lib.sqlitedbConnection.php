<?php
class SQLiteConnection extends SQLite3
{
  function __construct($db)
  {
	 $this->open("sysdb/".$db);
  }
}

   
class sqlitedbConnection{
	
	private $db=DB_NAME;
	private $lnk;
	
	var $result;

	function sqlitedbConnection(){
		$this->connect();		
		return $this;
	}

	function connect(){
		
		$this->lnk = new SQLiteConnection($this->db);
		
		if(!$this->lnk){
		  echo $this->lnk->lastErrorMsg();
	  	} else {
		  echo "Opened database successfully\n";
		  return $this->lnk;
	  	}
			
	}
	
	function fireQuery($query,$type="select",$result_type=SQLITE3_ASSOC){
		
		$this->result = $this->lnk->query($query);
		
		
		if($this->result){
			if($type=="select"){
				$this->result = $this->makeRowSet($this->result,$result_type);	
				if($this->result){
					return $this->result;
				}else{
					return false;
				}
			}elseif($type=="config"){
				return $this->configRow($this->result);
			}elseif($type=="insert"){
				return mysql_insert_id($this->lnk);
			}else{
				return true;
			}
		}else{
			return false;
		}
	}
	
	function configRow($result){
		$configRowSet=array();
		while($row=mysql_fetch_row($result)){
			$configRowSet[$row[0]]=$row[1];
		}
		return $configRowSet;
	}
	
	function makeRowSet($result,$result_type=SQLITE3_BOTH){
		
		$dataRowSet=array();
		
		if(count($result)>0){
			while($row = $result->fetchArray($result_type)){
				array_push($dataRowSet,$row);
			}
		}else{
			$dataRowSet=NULL;
		}
		return $dataRowSet;
	}
}
?>
