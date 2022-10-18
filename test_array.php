<?php
$arraychars=array("green","red","yellow","green","red","yellow","green");
$arrlength=count($arraychars);
$arrCount=array();
for($i=0;$i<$arrlength;$i++){
	$key=$arraychars[$i];
	if(@$arrCount[$key]>=1){
		$arrCount[$key]++;
	} else{
		$arrCount[$key]=1;
	}
	
	echo "<br/>->".$arraychars[$i];
}
echo "<pre>";
print_r($arrCount);
?>