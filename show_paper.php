<?php
include "include/config.php";
header('Content-Type: text/xml');
$exam_id = $_GET['exam_id'];
$res= " <select name='paper_id' id='paper_id'>
					  <option value=''>Select Paper</option>";
					   
					  $select_names = "select paper_id, paper_title from  paper  where exam_id='$exam_id'";
					  $ptr= mysql_query($select_names);
					  if(mysql_num_rows($ptr) !=0)
					  {
					  	while($data=mysql_fetch_array($ptr))
					  	{
					  					 
					 		$res .= "<option value='".$data['paper_id']."' > ".$data['paper_title']."</option>";
					 
					  	}
					  }
					  else
					  {
					  
					  }
					 
					$res .= "</select>";
					
					?>

<response>
  <urlpath><?php echo htmlspecialchars($res,ENT_QUOTES); ?></urlpath>
 </response>