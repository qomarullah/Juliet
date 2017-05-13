<?php
set_time_limit(360);
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include("../config.php");

$total=0;
$tot_prod=0;
$tot_dis=0;
$tot_notfound=0;
$tot_roaming=0;
$tot_tm=0;
$tot_campaign=0;
$tot_postpaid=0;

$sql_insert="";

$sql = "SELECT * FROM `services_data`";
$result = $conn->query($sql);
$total = $result->num_rows;

$sql_drop="DROP if exists `services_data_nomap`";
$result_drop = $conn->query($result_drop);

$sql_create="CREATE TABLE `services_data_nomap` SELECT * FROM `services_data` LIMIT 0";
$result_create = $conn->query($sql_create);

while($row = $result->fetch_assoc()) {
		
		$ada=false;
		$sql1 = "SELECT * FROM fsd_product where product_id='".$row['ID']."'";
		//echo $sql1;
		$result1 = $conn->query($sql1);
		$row1 = $result1->fetch_assoc();
		$num = $result1->num_rows;
		if($num>0){
			//echo "PRODUCT:".$row['ID']."=".$row1['product_id'];
			$tot_prod++;
			$ada=true;
			
			$sql_insert = "UPDATE fsd_product set name='".$row['Name']."', 
							short_description='".$row['ShortDescription']."',
							long_description='".$row['LongDescription']."', 
							ch_business_product='".$row['ch_business_product']."',
							ch_offer_priority='".$row['ch_offer_priority']."',
							ch_featured_product='".$row['ch_featured_product']."' where product_id='".$row['ID']."';";
			//$result_insert = $conn->query($sql_insert);
			$sql_fsd_product=$sql_fsd_product.$sql_insert."\n";
			
			
		}
		$sql1 = "SELECT * FROM fsd_discount where discount_id='".$row['ID']."'";
		//echo $sql1;
		$result1 = $conn->query($sql1);
		$row1 = $result1->fetch_assoc();
		$num = $result1->num_rows;
		if($num>0){
			//echo "DISCOUNT:".$row['ID']."=".$row1['discount_id'];
			$tot_dis++;
			$ada=true;
			
			$sql_insert = "UPDATE fsd_discount set name='".$row['Name']."', 
							short_description='".$row['ShortDescription']."',
							long_description='".$row['LongDescription']."', 
							ch_business_product='".$row['ch_business_product']."',
							ch_offer_priority='".$row['ch_offer_priority']."',
							ch_featured_product='".$row['ch_featured_product']."' where discount_id='".$row['ID']."';";
			//$result_insert = $conn->query($sql_insert);
			$sql_fsd_discount=$sql_fsd_discount.$sql_insert."\n";
			
			
		}
		
		$sql1 = "SELECT * FROM roaming_product where product_id='".$row['ID']."'";
		//echo $sql1;
		$result1 = $conn->query($sql1);
		$row1 = $result1->fetch_assoc();
		$num = $result1->num_rows;
		if($num>0){
			//echo "ROAMING:".$row['ID']."=".$row1['product_id'];
			$tot_roaming++;
			$ada=true;
			
			$sql_insert = "UPDATE roaming_product set name='".$row['Name']."', 
							short_description='".$row['ShortDescription']."',
							long_description='".$row['LongDescription']."', 
							ch_business_product='".$row['ch_business_product']."',
							ch_offer_priority='".$row['ch_offer_priority']."',
							ch_featured_product='".$row['ch_featured_product']."' where product_id='".$row['ID']."';";
			//$result_insert = $conn->query($sql_insert);
			$sql_roaming_product=$sql_roaming_product.$sql_insert."\n";
			
		}
		
		if($ada==false){
			//echo "NOTFOUND:".$row['ID'];
			$sql_insert = "INSERT INTO services_data_nomap SELECT * FROM services_data where ID='".$row['ID']."';";
			//$result_insert = $conn->query($sql_insert);
			$sql_notfound=$sql_notfound.$sql_insert."\n";
			
			$tot_notfound++;
			$ada=true;
		}
		//echo "<BR>";
		
			
}

			 

echo "<div class=\"row\">
			<div class=\"col-lg-12\">";

echo "TOTAL:".$total;
echo "<br>";

echo "PRODUCT:".$tot_prod;
echo "<br>";
echo "DISCOUNT:".$tot_dis;
echo "<br>";
echo "ROAMING:".$tot_roaming;
echo "<br>";
echo "NOTFOUND:".$tot_notfound;
echo "<br>";

//renew servic_data_nomap
$sql_nomap_drop="DROP table if Exists `services_data_nomap`";
$sql_nomap="CREATE table `services_data_nomap` like services_data";
$result_nomap_drop = $conn->query($sql_nomap_drop);
$result_nomap = $conn->query($sql_nomap);
echo "RECREATE service_data_nomap";
echo "<BR>";


$tx = date("Ymd_His");

$table_tx="uxp_fsd_product_".$tx;
$filename="temp/".$table_tx.".sql";
$myfile = fopen($filename, "w") or die("Unable to open file!");
fwrite($myfile, $sql_fsd_product);
fclose($myfile);
execute_sql($conn,$filename,"fsd_product");


$table_tx="uxp_fsd_discount_".$tx;
$filename="temp/".$table_tx.".sql";
$myfile = fopen($filename, "w") or die("Unable to open file!");
fwrite($myfile, $sql_fsd_discount);
fclose($myfile);
execute_sql($conn,$filename,"fsd_discount");


$table_tx="uxp_roaming_product_".$tx;
$filename="temp/".$table_tx.".sql";
$myfile = fopen($filename, "w") or die("Unable to open file!");
fwrite($myfile, $sql_roaming_product);
fclose($myfile);
execute_sql($conn,$filename,"roaming_product");


$table_tx="uxp_fsd_notfound_".$tx;
$filename="temp/".$table_tx.".sql";
$myfile = fopen($filename, "w") or die("Unable to open file!");
fwrite($myfile, $sql_notfound);
fclose($myfile);
execute_sql($conn,$filename,"services_data_nomap");


echo "</div>
		</div>";
echo "<br>";
echo "<div class=\"row\">
			<div class=\"col-lg-12\">
			<a href=\"index.php?page=convert\" class=\"btn btn-primary\"> BACK </a>
			</div>
		</div>";

function execute_sql($conn, $filename, $table){
	//execute
	$lines = file($filename);
	$i=0;
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
			$i++;
		}

	}
	echo "finish in $table=".$i."<br>"	;
	
}


?>