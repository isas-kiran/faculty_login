<?php  include 'ex_inc_classes.php';

$paper_ids=$_POST['paper_ids'];
if($paper_ids=='')
{
	echo "0";
}
else
{	
	$result = array();
	  if($paper_ids !='')
		  {
			  $result_seprated =explode(',',$paper_ids);
			  $concat = ' and  (';
						for($i=0;$i<count($result_seprated);$i++)
						{
							if($result_seprated[$i] !='')
								{
									$concat .="  papers_id='$result_seprated[$i]' ";
								}
							if( $i <(count($result_seprated)-2))
								{
									$concat .=" or " ;
								}
						}

			  $concat .=" ) ";
		  }
			"<br />".$sel_contact = "SELECT papers_section_id FROM ex_papers_section where 1 $concat  order by papers_section_id asc ";	 
			$query_contact = mysql_query($sel_contact);
			$i=1;
			echo $total_contact += mysql_num_rows($query_contact);
			
}
?>