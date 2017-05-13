<?php
set_time_limit(1000);
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

include ("lib/dumper.php");




echo "
<div class=\"container\">
			<div class=\"row\">
                <div class=\"col-lg-12\">
				&nbsp;
                </div>
            </div>
			<div class=\"row\">
                <div class=\"col-lg-12\">
				<h5>EXPORT ".$table."
                </div>
            </div>
           ";
			
		echo "<div class=\"row\">
                <div class=\"col-lg-12\">";
			
			
$tx = date("Ymd_His");
$table_tx=$table."_".$tx;
$filename="temp/".$table_tx.".sql";

if($table=="fsd_product" || $table=="fsd_discount"){
	
	$sql="select * from $table";
	$result = $conn_wl->query($sql);
	$total = $result->num_rows;
	echo "total row table ...".$total;
	echo "<br>";

	$sql_truncate="drop table if exists $table";
	$result_truncate = $conn->query($sql_truncate);
	echo "drop table temp...";
	echo "<br>";
	
	$world_dumper = Shuttle_Dumper::create(array(
		'host' => $servername_wl,
		'username' => $username_wl,
		'password' => $password_wl,
		'db_name' => $dbname_wl,
		'include_tables' => array($table),
	));
	$world_dumper->dump($filename);
	execute_sql($conn, $table, $filename);
}

if($table=="roaming_product"){
	
	$sql="select * from $table";
	$result = $conn_prem->query($sql);
	$total = $result->num_rows;
	echo "total row table ...".$total;
	echo "<br>";

	$sql_truncate="drop table if exists $table";
	$result_truncate = $conn->query($sql_truncate);
	echo "drop table temp...";
	echo "<br>";
	
	$world_dumper = Shuttle_Dumper::create(array(
		'host' => $servername_prem,
		'username' => $username_prem,
		'password' => $password_prem,
		'db_name' => $dbname_prem,
		'include_tables' => array($table),
	));
	$world_dumper->dump($filename);
	execute_sql($conn, $table, $filename);
}
if(startsWith($table, 'dynda_')){
	
	$sql="select * from $table";
	$result = $conn_mass->query($sql);
	$total = $result->num_rows;
	echo "total row table ...".$total;
	echo "<br>";

	$sql_truncate="drop table if exists $table";
	$result_truncate = $conn->query($sql_truncate);
	echo "drop table temp...";
	echo "<br>";
	
	$world_dumper = Shuttle_Dumper::create(array(
		'host' => $servername_mass,
		'username' => $username_mass,
		'password' => $password_mass,
		'db_name' => $dbname_mass,
		'include_tables' => array($table),
	));
	$world_dumper->dump($filename);
	execute_sql($conn, $table, $filename);
}

if(startsWith($table, 'services_') || $table=='bonuses' || $table=='price'){
	
	$table=strtoupper($table);
	
	$sql_truncate="drop table if exists $table";
	$result_truncate = $conn->query($sql_truncate);
	echo "drop table ".$table."....";

	$oratable=$prefix.$table;
	$filename=$folder.$oratable.".sql";
	$param="\"".$jndi."\" \"".$oratable."\" \"".$table."\" \"".$filename."\"";
	echo $param;
	echo "<br>";
	exec("java -jar lib/ApiOracleDb.jar ".$param." 2>&1", $output);
	print_r($output);
	
	
	//alter add index
	echo "add indexing..";
	echo "<br>";
	$sql_index="CREATE INDEX idx)id ON ".$table." (ID)";
	$result_index = $conn->query($sql_index);
	
	execute_sql($conn, $table, $filename);
	
}

	echo $content;
	echo "</div>
			<div class=\"row\">
                <div class=\"col-lg-12\">
				<a href=\"index.php?page=convert\" class=\"btn btn-primary\"> BACK </a>
                </div>
            </div>
            
 </div>";
		
		
function execute_sql($conn, $table, $filename){
	
	/* $sql="select * from $table";
	$result = $conn->query($sql); */
		
	echo "dump production table ...";
	echo "<br>";
		
	echo "execute to temporary table ...";
	echo "<br>";
			
		//execute
		$lines = file($filename);
		foreach ($lines as $line)
		{
			if (substr($line, 0, 2) == '--' || $line == '')//This IF Remove Comment Inside SQL FILE
			{
				continue;
			}
			$op_data .= $line;
			if (substr(trim($line), -1, 1) == ';')//Breack Line Upto ';' NEW QUERY
			{
				$conn->query($op_data);
				$op_data = '';
			}
		}

		$sql="select * from $table";
		$result = $conn->query($sql);
		$total = $result->num_rows;

		echo "finish  total ".$table." ...".$total;
		echo "<br>";
		

}


function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}
?>