<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title> Report</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<script type="text/javascript" src="../js/common.js"></script>
    
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    
     <script type="text/javascript">
       
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd', showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
            
        });
		</script>
    <script type="text/javascript" src="../js/common.js"></script>
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
    <td colspan="12">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
                <?php if($_SESSION['type']=='S')
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
				<td width="10%">
				<select name="admin_id" id="admin_id">
				<option value="" >Select Staff</option>
				<?php
				$sel_name="select name,admin_id from site_setting where 1 ".$_SESSION['where']." ";
				$ptr_name=mysql_query($sel_name);
				while($data_names=mysql_fetch_array($ptr_name))
				{
					$sel='';
					if($_REQUEST['admin_id']== $data_names['admin_id'])
					{
						$sel='selected="selected"';
					}
					
					echo '<option '.$sel.' value="'.$data_names['admin_id'].'" >'.$data_names['name'].'</option>';
				}
				?>
				</select>
				</td>
				 
				<td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                <!--<td class="rightAlign" > 
                    <table border="0" cellspacing="0" cellpadding="0" align="right">
              <tr>
              <td></td>
              <td class="width5"></td>
                <td><input type="text" value="<?php //if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                <td class="width2"></td>
                <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
              </tr>
                    </table>	
                </td>-->
            </tr>
        </table>
        </form>	
    </td>
  </tr>
    
    
    <?php
                        if($_REQUEST['keyword']!="Keyword")
                            $keyword=trim($_REQUEST['keyword']);
                        if($keyword)
                            $pre_keyword=" and (pcategory_name like '%".$keyword."%')";
                        else
                            $pre_keyword="";
							
						$search_cm_id='';
						if($_SESSION['type']=="S")
						{
							if($_REQUEST['branch_name']!='')
							{
								$branch_name=$_REQUEST['branch_name'];
								$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_cm_id=mysql_query($select_cm_id);
								$data_cm_id=mysql_fetch_array($ptr_cm_id);
								$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
								$search_cm_id_s=" and sp.cm_id='".$data_cm_id['cm_id']."'";
								
							}
							else
							{
								$search_cm_id='';
								$search_cm_id_s='';
							}
						}
						if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
						 {
						  	$pre_from_date=" and DATE(`date`) >='".$_REQUEST['from_date']."'";
							
							$installment_from_date=" and DATE(`date`) >='".date('Y-m-d')."'";
							
							$enquiry_from_date=" and DATE(`date`) >='".date('Y-m-d',strtotime($_REQUEST['from_date']))."'";
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
							 $pre_to_date=" and DATE(`date`) <='".$_REQUEST['to_date']."'";
							
							$installment_to_date=" and DATE(`admission_date`)<='".date('Y-m-d')."' ";
							$enquiery_to_date=" and DATE(`added_date`)<='".date('Y-m-d',strtotime($date))."'";
						}
						else
						{
							$pre_to_date="";
							$enquiery_to_date="";
							$installment_to_date="";
						}
						
						if($_REQUEST['admin_id'])
                            $admin_id='and admin_id="'.$_REQUEST['admin_id'].'"';
                        else
                            $admin_id='';

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

                        if($_GET['orderby']=='pcategory_name' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='pcategory_name'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                                                 
                           	$sql_query= "select * from site_setting where 1 ".$_SESSION['where']." ".$search_cm_id." ".$admin_id." order by name asc"; 
                       		//echo $sql_query;
                        	$no_of_records=mysql_num_rows($db->query($sql_query));
                        	if($no_of_records)
                        	{
                            	$bgColorCounter=1;
                            	//$_SESSION['show_records'] = 10;
                            	$query_string='&keyword='.$keyword.'&branch_name='.$_REQUEST['branch_name'].'&from_date='.$_REQUEST['from_date'].'&to_date='.$_REQUEST['to_date'].'&admin_id='.$_REQUEST['admin_id'];
                            	$query_string1=$query_string.$date_query;
                           		// $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            	$pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            	$all_records= $pager->paginate();
                            	?>
    			<form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                     <input type="hidden" name="formAction" id="formAction" value=""/>
                      <tr class="grey_td" >
                        <td width="5%" align="center"><strong>Sr. No.</strong></td>
                        <td width="15%" align="center"><strong>Employee Name</strong></td>
                        <td width="80%" align="center"><strong>Action</strong></td>
                      </tr>
                            <?php

                            while($val_query=mysql_fetch_array($all_records))
                            {
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                $listed_record_id=$val_query['pcategory_id']; 
                                include "include/paging_script.php";
                                echo '<tr '.$bgcolor.' >';
                                echo '<td align="center" width="5%">'.$sr_no.'</td>';  
                                echo '<td align="center">'.$val_query['name'].'</td>';
								echo '<td width="25%" style="padding-top:10px;padding-bottom:10px">';
								
								if($_REQUEST['admin_id'] > 0)
								{
									 $admin_id="and admin_id='".$_REQUEST['admin_id']."'";
								}
								else
								{
									 $admin_id="and admin_id='".$val_query['admin_id']."'";
								}
								
								$select=" select * from log_history where 1 ".$admin_id." and cm_id='".$val_query['cm_id']."' ".$pre_from_date." ".$pre_to_date."  ";
							   	$query=mysql_query($select);
							   	if(mysql_num_rows($query))
								{
							  		while($fetch=mysql_fetch_array($query))
							   		{
										$category=str_replace("-"," ",$fetch['category']);
										if($fetch['action']=="Add" || $fetch['action']=="add")
										{
											$desc='';
											if($category=="Expense")
											{
												$select_exp="select * from expense where expense_id='".$fetch['id']."'";
												$ptr_exp=mysql_query($select_exp);
												$data_exp=mysql_fetch_array($ptr_exp);
												$desc='==><b>amnt-</b>'.$data_exp['amount'].'==><b>Desc-</b>'.$data_exp['description'].'';
											}
											else if($category=="receipt")
											{
												$select_exp="select * from receipt where receipt_id='".$fetch['id']."'";
												$ptr_exp=mysql_query($select_exp);
												$data_exp=mysql_fetch_array($ptr_exp);
												$desc='==><b>amnt-</b>'.$data_exp['amount'].'==><b>Desc-</b>'.$data_exp['description'].'';
											}
											else if($category=="cash_transfer")
											{
												$select_exp="select * from receipt where category='cash_transfer' and receipt_id='".$fetch['id']."'";
												$ptr_exp=mysql_query($select_exp);
												$data_exp=mysql_fetch_array($ptr_exp);
												$desc='==><b>amnt-</b>'.$data_exp['amount'].'==><b>type-</b>'.$data_exp['cash_transfer_mode'].'==><b>Desc-</b>'.$data_exp['description'].'';
											}
											else if($category=="Add_payment")
											{
												$select_exp="select * from invoice where invoice_id='".$fetch['id']."'";
												$ptr_exp=mysql_query($select_exp);
												$data_exp=mysql_fetch_array($ptr_exp);
												$sel_course="select course_name from courses where course_id='".$fetch['course_id']."'";
												$ptr_course=mysql_query($sel_course);
												$data_course=mysql_fetch_array($ptr_course);
												$desc='==><b>amnt-</b>'.$data_exp['amount'].'==><b>Course Name-</b>'.$data_course['course_name'].'';
											}
											echo '<a><b >Insert in </b>'.$category.' ==> <b >'.$fetch['name'].'</b> ('.$fetch['date'].')'.$desc.'<br/> </a>';
										}
										else if($fetch['action']=="Edit" || $fetch['action']=="edit")
										{
											echo '<a><b >Edit in '.$category.' ==> </b>'.$fetch['name'].' ('.$fetch['date'].')<br/> </a>';
										}
										else if($fetch['action']=="Delete" || $fetch['action']=="delete")
										{
											echo '<a><b style="color:red;">Delete from '.$category.' ==> </b>'.$fetch['name'].' ('.$fetch['date'].')<br/> </a>';
										}
								   	}
							   	}
								
							  	/*$select1=" select * from log_history where admin_id='".$val_query['admin_id']."' and cm_id='".$val_query['cm_id']."' and action='Add' ";
							   	$query1=mysql_query($select1);
							   	while($fetch1=mysql_fetch_array($query1))
							   	{
									$course_id=$fetch1['id'];
								   	if(mysql_num_rows($query1))
								   	{
										echo '<a><a href=""><b>Add '.$fetch1['category'].'</b></a>';
								   	}
								   	echo "<br>";
							   	}
							    $select1=" select * from log_history where admin_id='".$val_query['admin_id']."' and cm_id='".$val_query['cm_id']."' and action='Edit' ";
							   	$query1=mysql_query($select1);
							   	while($fetch1=mysql_fetch_array($query1))
							   	{
									$course_id=$fetch1['id'];
								   	if(mysql_num_rows($query1))
								   	{
										echo '<a><a href="course_manage.php?record_id='.$course_id.'"><b>Edit Course</b></a>';
								   	}
								   	echo "<br>";
							   	}
								
								$select=" select * from log_history where admin_id='".$val_query['admin_id']."' and cm_id='".$val_query['cm_id']."' and action='delete'";
							   	$query=mysql_query($select);
							   	while($fetch=mysql_fetch_array($query))
							   	{
									if(mysql_num_rows($query))
									{
										echo '<a><b style="color:red;">Delete Course==></b>'.$fetch['name'].'</a>';
									}
								    echo "<br>";
							   	}*/
							   	echo '</td>';
                                echo '</tr>';
                                $bgColorCounter++;
                            }    
                                ?>
  
  
  <tr class="head_td">
    <td colspan="12">
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
    </tr></form>
      <?php } 
      else
        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No Page found related to your search criteria, please try again</div><br></td></tr>';?>
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
