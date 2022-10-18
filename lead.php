<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Total Source</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='148'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
    <script type="text/javascript" src="../js/common.js"></script>
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
     <script type="text/javascript">
    $(document).ready(function()
    {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
    });
	</script>
	<script type="text/javascript">
	function submitAction(action)
	{
		var chks = document.getElementsByName('chkRecords[]');
	    var hasChecked = false;
        for (var i = 0; i < chks.length; i++)
	    {
	        if (chks[i].checked)
            {
	            hasChecked = true;
                break;
            }
        }
        if (hasChecked == false)
        {
	        alert("Please select at least one record to do operation");
            $('#selAction').val('');
            return false;
        }
        document.getElementById('formAction').value=action;
        if(action=="delete")
        {
		    if(confirm("Are you sure, you want to delete selected record(s)?"))
	    	    document.frmTakeAction.submit();
	    	else
	    	{
				$('#selAction').val('');
				return false;
			}
		}
		else

                document.frmTakeAction.submit();

        }

        function redirect1(value,value1)

        {           

            //alert(value);

           // alert(value1);

            window.location.href=value+value1;

        }



        function validationToDelete(type)

        {

            if(confirm("Are you sure, you want to delete selected record(s)?"))

                return true;

            else

                return false;

        }

    </script>

</head>
<body>
<?php include "include/header.php"; ?>
<!--info start-->
<div id="info">
<!--left start-->
<?php include "include/menuLeft.php"; ?>
<!--left end-->
<!--right start-->
<div id="right_info">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "include/report_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid" align="center">
		<table cellspacing="0" cellpadding="0" class="table" width="95%">
			<tr class="head_td">
				<td colspan="8">
			        <form method="get" name="search">
						<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
			              <tr>
			                <td class="width5"></td>
			                <!--<td width="20%">
	                        <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                <option value="">-Operation-</option>
                                <option value="delete">Delete</option>
	                        </select></td>-->
                        <?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
						{
						?>
						 <td width="15%">
							<select name="branch_name" id="branch_name"  class="input_select_login"  style="width: 150px; ">
								<option value="">-Branch Name-</option>
								<?php 
									$sel_branch="select branch_id,branch_name from branch";
									$ptr_sel=mysql_query($sel_branch);
									while($data_branch=mysql_fetch_array($ptr_sel))
									{
										$sel='';
										if($data_branch['branch_name']==$_GET['branch_name'])
										{
											$sel='selected="selected"';
										}
										echo '<option '.$sel.' value="'.$data_branch['branch_name'].'" > '.$data_branch['branch_name'].'</option>';
									}
								?>
							</select>
						</td>
						<?php
						}
						?>
                        <td width="10%">
                        	<input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>">
                        </td>
                        <td width="10%">
							<input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>">
                        </td>
                        <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
						<td class="rightAlign" > 
             <!-- <select name="inq"  >
             <option value="">--Select By--</option>
			 <option value="inquiry">Inquiry</option>
			 <option value="enrollment">Enrollment</option>-->
             <?php
			 /* $sel_payment_mode="SELECT source_id,source_name FROM source where 1";
				$ptr_payment_mode=mysql_query($sel_payment_mode);
			// $i=0;
			 while($data_payment_mode=mysql_fetch_array($ptr_payment_mode))
			 { 
			      $sel='';
			    if($_GET['inq']==$data_payment_mode['source_id'])
				{
					$sel='selected="selected"';
				}
				echo '<option '.$sel.' value='.$data_payment_mode['source_id'].'>'.$data_payment_mode['source_name'].'</option>';
			 } */
			  ?>
            <!--  </select>-->
                    <!--<table border="0" cellspacing="0" cellpadding="0" align="right">

              <tr>

              <td></td>

              <td class="width5"></td>

                <td><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>

                <td class="width2"></td>

                <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>

              </tr>

                    </table>	-->
                  
                </td>
                 
 <!--<td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>-->
            </tr>
            

        </table>

        </form>	

    </td>

  </tr>
<?php

						if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
						 {
						  	$pre_from_date=" and DATE(`admission_date`) >='".date('Y-m-d')."'";
							$installment_from_date=" and DATE(`admission_date`) >='".date('Y-m-d')."'";
							$enquiry_from_date=" and DATE(`added_date`) >='".date('Y-d-m',strtotime($_REQUEST['from_date']))."'";

						 }

						else
						{
							$pre_from_date=""; 
							$enquiry_date="";
							$installment_from_date="";                           
						}
						
						if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
						{
							 $var=$_REQUEST['to_date'];                            
							 $date=str_replace('/','-',$var);
							 $pre_to_date=" and DATE(`admission_date`) <='".date('Y-m-d')."'";
							$installment_to_date=" and DATE(`admission_date`)<='".date('Y-m-d')."' ";
							$enquiery_to_date=" and DATE(`added_date`)<='".date('Y-m-d',strtotime($date))."'";
						}
						else
						{
							$pre_to_date="";
							$enquiery_to_date="";
							$installment_to_date="";
						}
						$search_cm_id='';
						$cm_ids=$_SESSION['cm_id'];
						if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
						{
							if($_REQUEST['branch_name']!='')
							{
								$branch_name=$_REQUEST['branch_name'];
								$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_cm_id=mysql_query($select_cm_id);
								$data_cm_id=mysql_fetch_array($ptr_cm_id);
								$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
								$cm_ids=$data_cm_id['cm_id'];
							}
							else
							{
								$search_cm_id='';
							}
						}
						if($_REQUEST['inq'])
						{
						     $inquiry=$_REQUEST['inq'];
						}
						
						

                        if($_REQUEST['page'])

                            $page=$_REQUEST['page'];

                        else

                            $page=0;

                        

                        if($_REQUEST['show_records'])

                            $show=$_REQUEST['show'];

                        else

                            $show=0;



                        if($_GET['order']=='asc')

                        {

                            $order='desc';

                            $img = "<img src='images/sort_up.png' border='0'>";

                        }

                        else if($_GET['order']=='desc')

                        {

                            $order='asc';

                            $img = "<img src='images/sort_down.png' border='0'>";

                        }
                        else

                            $order='desc';

	                   if($_GET['orderby']=='name' )
                            $img1 = $img;
                       if($_GET['order'] !='' && ($_GET['orderby']=='firstname'))
                       {
                           $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                           $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                       }
					   else
							$branch_id='';
                       		$select_directory='order by source_id asc';                      
                       		$sql_query= "select source_name,source_id from source where 1 ".$search_cm_id." ".$enquiry_from_date." ".$enquiery_to_date." ".$select_directory."  "; 
							$db=mysql_query($sql_query);
							$no_of_records=mysql_num_rows($db);
			

                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword.'&from_date='.$_REQUEST['from_date'].'&to_date='.$_REQUEST['to_date'].'&branch_name='.$_REQUEST['branch_name'];
                            $query_string1=$query_string.$date_query;
                           // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
  							<form method="post"  name="frmTakeAction"  action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>">
							<input type="hidden" name="formAction" id="formAction" value=""/>

                      		<tr class="grey_td" >
								<td width="10%" align="center"><strong>Sr. No.</strong></td>
                                <td width="18%" align="center"><strong>Source Name</strong></td>
                                <td width="12%" align="center"><strong>Very Hot</strong></td>
                                <td width="12%" align="center"><strong>Hot</strong></td>
                                <td width="12%" align="center"><strong>Warm</strong></td>
                                <td width="12%" align="center"><strong>Nutral</strong></td>
                                <td width="12%" align="center"><strong>Cold</strong></td>     
                                <td width="12%" align="center"><strong>Total</strong></td>
							</tr>
                            <?php
							$to=0;
                            while($val_query=mysql_fetch_array($all_records))
                            {
								if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor=""; 
								$total_source='';	       
                                
									 // echo "hello";
									/* if($inquiry=='inquiry')
									 {
										 
                                  "<br>".$sel_inq_source="select count(enquiry_source) as total_inq_src from inquiry where enquiry_source =".$val_query['source_id']." ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiery_to_date."   ";
								  
								$ptr_inq_source=mysql_query($sel_inq_source);

								$total_inq_source=mysql_fetch_array($ptr_inq_source);

									 }
									 
                                     if($inquiry=='enrollment')
								     {
                                     
								 "<br>".$sel_enroll_src="select count(source) as total_enroll_src from enrollment where source =".$val_query['source_id']." ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiery_to_date." ";

								$ptr_enroll_src=mysql_query($sel_enroll_src);

								$total_enroll_src=mysql_fetch_array($ptr_enroll_src);

								     }
									 if($_GET['inq']=='')
									 {
										 
										  "<br>".$sel_inq_source="select count(enquiry_source) as total_inq_src from inquiry where enquiry_source =".$val_query['source_id']." ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiery_to_date."   ";
								  
								$ptr_inq_source=mysql_query($sel_inq_source);

								$total_inq_source=mysql_fetch_array($ptr_inq_source);
										 
										 "<br>".$sel_enroll_src="select count(source) as total_enroll_src from enrollment where source =".$val_query['source_id']." ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiery_to_date." ";

								$ptr_enroll_src=mysql_query($sel_enroll_src);

								$total_enroll_src=mysql_fetch_array($ptr_enroll_src);
									 }
                                  
								$total_src=$total_inq_source['total_inq_src'] + $total_enroll_src['total_enroll_src'];*/
								//if()
                                 //$total_src=$total_inq_source['total_inq_src'];
								include "include/paging_script.php";
    	                        echo '<tr '.$bgcolor.'>';
							   	echo '<td align="center">'.$sr_no.'</td>';
                                echo '<td align="center">'.$val_query['source_name'].'</td>';
								  
								//echo $sel_inq_source="select count(enquiry_source) as total_lead,count(lead_grade) AS lead_grade from inquiry where enquiry_source=".$val_query['source_id']." ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiery_to_date."   ";
								   
								"<br>".$sel_inq_source="select inquiry_id,lead_grade from inquiry where enquiry_source=".$val_query['source_id']." ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiery_to_date."   ";
								  
								   
								$ptr_inq_source=mysql_query($sel_inq_source);
                             	echo '<td align="center">';
							 	$count1=0;
								while($total_inq_source=mysql_fetch_array($ptr_inq_source))
								{
								   if($total_inq_source['lead_grade']=='very_hot')
								   {
									   
									   $sel="select count(lead_grade) AS total_lead from inquiry where lead_grade='very_hot' and inquiry_id=".$total_inq_source['inquiry_id']." ".$_SESSION['where']."  ";
									   $sel_query=mysql_query($sel);
									   $fetch=mysql_fetch_array($sel_query);
									   $count=mysql_num_rows($sel_query);
									   
									   $count1+=$count;
								  // echo $fetch['total_lead'];
								   }
								   
								}
								echo $count1;'</td>';
								
								"<br>".$sel_inq="select inquiry_id,lead_grade from inquiry where enquiry_source=".$val_query['source_id']." ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiery_to_date."   ";
								  
								   
								$ptr_inq=mysql_query($sel_inq);
								 //$total=mysql_num_rows($ptr_inq);
								
								
							echo '<td align="center">';
							 $tota=0;
							 $s=0;
								while($total_inq_source=mysql_fetch_array($ptr_inq))
								{ 
								   $t=0;   
								   
								   if($total_inq_source['lead_grade']=='hot')
								   {
									 
									  "<br>".$sel1="select count(lead_grade) AS total_lead from inquiry where lead_grade='hot' and inquiry_id=".$total_inq_source['inquiry_id']." ".$_SESSION['where']."  ";
									   $sel_query1=mysql_query($sel1);
									   $fetch1=mysql_fetch_array($sel_query1);
									   $total=mysql_num_rows($sel_query1);
									  
									   $tota+=$total;
								         
								   }
								   $t++;
								   
								      // echo $tota;
								}
								
								 
								 echo $tota;'</td>';  
								  
								  "<br>".$sel="select inquiry_id,lead_grade from inquiry where enquiry_source=".$val_query['source_id']." ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiery_to_date."   ";
								  
								   
								$ptr_query=mysql_query($sel);
								  echo '<td align="center">';
							    $cont=0;
								while($total_inq_source=mysql_fetch_array($ptr_query))
								{  
								   
								   if($total_inq_source['lead_grade']=='warm')
								   {
									   $sel2="select count(lead_grade) AS total_lead from inquiry where lead_grade='warm' and inquiry_id=".$total_inq_source['inquiry_id']." ".$_SESSION['where']."  ";
									   $sel_query2=mysql_query($sel2);
									   $fetch2=mysql_fetch_array($sel_query2); 
									   $count1=mysql_num_rows($sel_query2);
									  $cont+=$count1;
								   //echo $fetch2['total_lead'];
								   }
								  
								}
								 echo  $cont;'</td>';  
								   
								    "<br>".$sel_in="select inquiry_id,lead_grade from inquiry where enquiry_source=".$val_query['source_id']." ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiery_to_date."   ";
								  
								   
								$ptr_query=mysql_query($sel_in);
								   
								   echo '<td align="center">';
							    $cnt=0;
								while($total_inq_source=mysql_fetch_array($ptr_query))
								{   
								   
								   if($total_inq_source['lead_grade']=='Nutral')
								   {
									    $sel3="select count(lead_grade) AS total_lead from inquiry where lead_grade='Nutral' and inquiry_id=".$total_inq_source['inquiry_id']." ".$_SESSION['where']."  ";
									   $sel_query3=mysql_query($sel3);
									   $fetch3=mysql_fetch_array($sel_query3); 
									   $raw=mysql_num_rows($sel_query3);
									   $cnt+=$raw;
								   //echo $fetch3['total_lead'];
								   }
								   
								}
								   echo $cnt;'</td>'; 
								   
								   "<br>".$sel_inqe="select inquiry_id,lead_grade from inquiry where enquiry_source=".$val_query['source_id']." ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiery_to_date."   ";
								  
								   
								$ptr_que=mysql_query($sel_inqe); 
								  
								   echo '<td align="center">';
							 $count5=0;
								while($total_inq_source=mysql_fetch_array($ptr_que))
								{    
								   
								   if($total_inq_source['lead_grade']=='cold')
								   {
									    $sel4="select count(lead_grade) AS total_lead from inquiry where lead_grade='cold' and inquiry_id=".$total_inq_source['inquiry_id']." ".$_SESSION['where']."  ";
									   $sel_query4=mysql_query($sel4);
									   $fetch4=mysql_fetch_array($sel_query4); 
									   
									   $count4=mysql_num_rows($sel_query4);
									   $count5+=$count4;
								   //echo $fetch4['total_lead'];
								   }
								   
								 }
								  
								   echo $count5;'</td>';
								    
								   $total_src=$count1+$tota+$cont+$cnt+$count5;
								    
								
                                    echo '<td align="center">'.$total_src.'</td>';

								  $to+=$total_src;
								  
                               /* $s=0;
								if($t!=0)
								{
									
									$s+=$t;
									
								}
								if($s!=0)
								{ 
								     $p=0;
									 $p+=$s;  
								       echo $p;
								}*/
								
								
								
                                echo '</tr>';

                               

								$bgColorCounter++;

                                                                

							}
							
							
							echo '<tr>';
							
							   echo '<td align="center">'.Total.'</td>';
							   echo '<td align="center"></td>';
							   echo '<td align="center"></td>';
							   echo '<td align="center"></td>';
							   echo '<td align="center"></td>';
							   echo '<td align="center"></td>';
							   echo '<td align="center"></td>';
							   echo '<td align="center">'.$to.'</td>';
							   echo '</tr>';

                                ?>

                                

                                <tr class="head_td">

    <td colspan="15">

       <table cellspacing="0" cellpadding="0" width="100%">

            <tr>

                <?php

                      if($no_of_records>10)

                            {

                                echo '<td width="3%" align="left">Show</td>

                                <td width="20%" align="left"><select class="input_select_login" name="show_records" onchange="redirect(this.value)">';

                                $show_records=array(0=>'10',1=>'20','50','100');

                                for($s=0;$s<count($show_records);$s++)

                                {

                                    if($_SESSION['show_records']==$show_records[$s])

                                        echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';

                                    else

                                        echo '<option value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';

                                }

                                echo'</td></select>';

                            }

                            echo '<td width="75%" align="right">'.$pager->renderFullNav().'</td>';

                         

                 ?>

                                    

            </tr>

        </table>

 
    </td>

    </tr>

  

  

  </form>

  <?php } 

	  

      else

        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No records found related to your search criteria, please try again</div><br></td></tr>';?>

      

</table>



	</td>

    <td class="mid_right"></td>

  </tr>

    

    

    

    

  <tr>

    <td class="bottom_left"></td>

    <td class="bottom_mid"></td>

    <td class="bottom_right"></td>

  </tr>

</table>



</div>

<!--right end-->



</div>

<!--info end-->

<div class="clearit"></div>

<!--footer start-->

<div id="footer">

<?php include "include/footer.php"; ?>

</div>

<!--footer end-->

</body>

</html>

