<?php
set_time_limit(360);
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

//clear
/* $sql = "UPDATE `context` set `key`='',adn='', msg='',msg_gift='',msg_sub='',msg_unsub=''";
$result = $conn->query($sql); */

/////////////////////////////////////
$total=0;
$tot_context=0;
$sql_insert="";



$sql = "SELECT * FROM `context` where ID like 'ML4%'";
$result = $conn->query($sql);
$total_context = $result->num_rows;


$sql = "SELECT package_keyword, ch_business_product FROM `fsd_product` where ch_business_product!=''";
$result = $conn->query($sql);
$total_source = $result->num_rows;


while($row = $result->fetch_assoc()) {
		
		$ml4=explode("|",$row['ch_business_product']);
		
		for($i=0;$i<sizeOf($ml4);$i++){
			
			$package_keyword=trim($row['package_keyword']);
			$key="fsd";
			$adn="3636";
			
			$package_keywordx="[package_keyword]";
			$msg="fsdact+".$package_keywordx;
			$msg_gift="GIFT+[bnumber]+fsdact+".$package_keywordx;
			$msg_sub="fsdsubact+".$package_keywordx;
			$msg_unsub="fsddeact+".$package_keywordx;
				
			$sql_insert = "UPDATE context set `key`='".$key."',
						adn='".$adn."', 
						package_keyword='".$package_keyword."',
						msg='".$msg."',
						msg_gift='".$msg_gift."',
						msg_sub='".$msg_sub."',
						msg_unsub='".$msg_unsub."' where ID='".$ml4[$i]."';";
			//$result_insert = $conn->query($sql_insert);
			$sql_fsd_context=$sql_fsd_context.$sql_insert."\n";
			$tot_context++;
			
				
		}
		
		$total++;
		
}
$summary="";
$summary.= "TOTAL-CONTEXT:".$total_context;
$summary.= "<br>";
$summary.= "TOTAL-DATA:".$total_source;
$summary.= "<br>";
$summary.= "TOTAL-CONVERT-DATA:".$total;
$summary.= "<br>";
$summary.= "TOTAL-CONVERT-DATA-ML4:".$tot_context;
$summary.= "<br>";

echo $summary;
$myfile = fopen("sql/context_service_data_sum.txt", "w") or die("Unable to open file!");
fwrite($myfile, $summary);
fclose($myfile);


$myfile = fopen("sql/context_service_data.txt", "w") or die("Unable to open file!");
fwrite($myfile, $sql_fsd_context);
fclose($myfile);


///////////////////////////////////////
echo "==============================================<br>";
$total=0;
$tot_context=0;
$sql_insert="";
	
//$sql = "SELECT * FROM `fsd_discount` where ch_business_product!=''";
$sql="SELECT a.discount_id,b.product_id,b.package_keyword,a.ch_business_product FROM `fsd_discount` a LEFT JOIN fsd_product b ON a.product_id=b.product_id 
WHERE a.ch_business_product!=''";

$result = $conn->query($sql);
$total_source = $result->num_rows;


while($row = $result->fetch_assoc()) {
		
		$ml4=explode("|",$row['ch_business_product']);
		
		for($i=0;$i<sizeOf($ml4);$i++){
			
			$package_keyword=trim($row['package_keyword']);
			$key="fsd";
			$adn="3636";
			$package_keywordx="[package_keyword]";
			$msg="fsdact+".$package_keywordx;
			$msg_gift="GIFT+[bnumber]+fsdact+".$package_keywordx;
			$msg_sub="fsdsubact+".$package_keywordx;
			$msg_unsub="fsddeact+".$package_keywordx;
				
			$sql_insert = "UPDATE context set `key`='".$key."',
						adn='".$adn."', 
						package_keyword='".$package_keyword."',
						msg='".$msg."',
						msg_gift='".$msg_gift."',
						msg_sub='".$msg_sub."',
						msg_unsub='".$msg_unsub."' where ID='".$ml4[$i]."';";
			//$result_insert = $conn->query($sql_insert);
			$sql_fsd_discount_context=$sql_fsd_discount_context.$sql_insert."\n";
			$tot_context++;
			
				
		}
		
		$total++;
		
}

$summary ="";
$summary.= "TOTAL-CONTEXT:".$total_context;
$summary.= "<br>";
$summary.= "TOTAL-DATA-DISCOUNT:".$total_source;
$summary.= "<br>";
$summary.= "TOTAL-CONVERT-DATA-DISCOUNT:".$total;
$summary.= "<br>";
$summary.= "TOTAL-CONVERT-DATA-ML4-DISCOUNT:".$tot_context;
$summary.= "<br>";

echo $summary;

$myfile = fopen("sql/context_service_data_discount_sum.txt", "w") or die("Unable to open file!");
fwrite($myfile, $summary);
fclose($myfile);

$myfile = fopen("sql/context_service_data_discount.txt", "w") or die("Unable to open file!");
fwrite($myfile, $sql_fsd_discount_context);
fclose($myfile);

/////////////////////////////////
$sql = "SELECT * FROM `context` where ID like 'ML4%' and `key`!=''";
$result = $conn->query($sql);
$total_context_convert = $result->num_rows;
echo "TOTAL-CONTEXT-CONVERTED:".$total_context_convert;
?>