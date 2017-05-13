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

$sql_truncate="TRUNCATE `fsd_product`";
$result_truncate = $conn->query($sql_truncate);

$sql = "SELECT * FROM `fsd_product`";
$result = $conn_prem->query($sql);


while($row = $result->fetch_assoc()) {
		
		$ada=false;
		$sql1 = "SELECT * FROM fsd_product where product_id='".$row['ID']."'";
		//echo $sql1;
		$result1 = $conn->query($sql1);
		$row1 = $result1->fetch_assoc();
		$num = $result1->num_rows;
		if($num>0){
			echo "PRODUCT:".$row['ID']."=".$row1['product_id'];
			$tot_prod++;
			$ada=true;
			
			$sql_insert = "UPDATE fsd_product set short_description='".$row['ShortDescription']."',
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
			echo "DISCOUNT:".$row['ID']."=".$row1['discount_id'];
			$tot_dis++;
			$ada=true;
			
			$sql_insert = "UPDATE fsd_discount set short_description='".$row['ShortDescription']."',
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
			echo "ROAMING:".$row['ID']."=".$row1['product_id'];
			$tot_roaming++;
			$ada=true;
			
			$sql_insert = "UPDATE roaming_product set short_description='".$row['ShortDescription']."',
							long_description='".$row['LongDescription']."', 
							ch_business_product='".$row['ch_business_product']."',
							ch_offer_priority='".$row['ch_offer_priority']."',
							ch_featured_product='".$row['ch_featured_product']."' where product_id='".$row['ID']."';";
			//$result_insert = $conn->query($sql_insert);
			$sql_roaming_product=$sql_roaming_product.$sql_insert."\n";
			
		}
		
		if($ada==false){
			echo "NOTFOUND:".$row['ID'];
			$sql_insert = "INSERT INTO services_data_nomap SELECT * FROM services_data where ID='".$row['ID']."';";
			//$result_insert = $conn->query($sql_insert);
			$sql_notfound=$sql_notfound.$sql_insert."\n";
			
			$tot_notfound++;
			$ada=true;
		}
		echo "<BR>";
		
			
}
/* 

$sql_truncate="TRUNCATE `service_data_nomap`";
$result_truncate = $conn->query($sql_truncate);

echo $sql_insert;
$result_insert = $conn->query($sql_insert);
			 */
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




$myfile = fopen("sql/fsd_product.txt", "w") or die("Unable to open file!");
fwrite($myfile, $sql_fsd_product);
fclose($myfile);

$myfile = fopen("sql/fsd_discount.txt", "w") or die("Unable to open file!");
fwrite($myfile, $sql_fsd_discount);
fclose($myfile);

$myfile = fopen("sql/roaming_product.txt", "w") or die("Unable to open file!");
fwrite($myfile, $sql_roaming_product);
fclose($myfile);

$myfile = fopen("sql/fsd_notfound.txt", "w") or die("Unable to open file!");
fwrite($myfile, $sql_notfound);
fclose($myfile);



?>