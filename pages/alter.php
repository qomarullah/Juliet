<?php
set_time_limit(360);
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$content="";	

if($table=="fsd_product"){
	
	$sql="ALTER TABLE $table
	  ADD `name` VARCHAR(100) DEFAULT NULL,
	  ADD `short_description` VARCHAR(100) DEFAULT NULL,
	  ADD `long_description` VARCHAR(255) DEFAULT NULL,
	  ADD `ch_business_product` VARCHAR(255) DEFAULT NULL,
	  ADD `ch_offer_priority` INT(3) DEFAULT NULL,
	  ADD `ch_featured_product` VARCHAR(10) DEFAULT NULL;";
	  
}

if($table=="fsd_discount"){
	
	$sql="ALTER TABLE $table 
	  ADD `name` VARCHAR(100) DEFAULT NULL,
	  ADD `short_description` VARCHAR(100) DEFAULT NULL,
	  ADD `long_description` VARCHAR(255) DEFAULT NULL,
	  ADD `ch_business_product` VARCHAR(255) DEFAULT NULL,
	  ADD `ch_offer_priority` INT(3) DEFAULT NULL,
	  ADD `ch_featured_product` VARCHAR(10) DEFAULT NULL;";
	  
}

if($table=="roaming_product"){
	
	$sql="ALTER TABLE $table 
	  ADD `name` VARCHAR(100) DEFAULT NULL,
	  ADD `short_description` VARCHAR(100) DEFAULT NULL,
	  ADD `long_description` VARCHAR(255) DEFAULT NULL,
	  ADD `ch_business_product` VARCHAR(255) DEFAULT NULL,
	  ADD `ch_offer_priority` INT(3) DEFAULT NULL,
	  ADD `ch_featured_product` VARCHAR(10) DEFAULT NULL;";
	  
}


if($table=="dynda_service_promo_city" || $table=="dynda_service_promo_product"){
	
	$sql="ALTER TABLE $table 
	  ADD `product_id` VARCHAR(100) DEFAULT NULL FIRST,
	  ADD `name` VARCHAR(100) DEFAULT NULL AFTER `product_id`,
	  ADD `short_description` VARCHAR(100) DEFAULT NULL,
	  ADD `long_description` VARCHAR(255) DEFAULT NULL,
	  ADD `ch_business_product` VARCHAR(255) DEFAULT NULL,
	  ADD `ch_offer_priority` INT(3) DEFAULT NULL,
	  ADD `ch_featured_product` VARCHAR(10) DEFAULT NULL;";
	  //echo $sql;
}


$result = $conn->query($sql);
if($result){
	$content.= "Alter success ...";
	$content.="<br>";
}

echo "

<div class=\"container\">
			<div class=\"row\">
                <div class=\"col-lg-12\">
				&nbsp;
                </div>
            </div>
			<div class=\"row\">
                <div class=\"col-lg-12\">
				<h5>ALTER ".$table."
                </div>
            </div>
            <div class=\"row\">
                <div class=\"col-lg-12 text-left\">
                    ".$content."
                </div>
            </div>
			<div class=\"row\">
                <div class=\"col-lg-12\">
				&nbsp;
                </div>
            </div>
			
			<div class=\"row\">
                <div class=\"col-lg-12\">
				<a href=\"index.php?page=convert\" class=\"btn btn-primary\"> BACK </a>
                </div>
            </div>
            
 </div>";
		

?>