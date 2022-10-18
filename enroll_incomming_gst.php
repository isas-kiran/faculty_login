<?php include 'inc_classes.php';?>
<!--ENROLLMENT INCOMMING GST REPORT WITH NO GST NO OF STUDENT-->
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Enroll Incomming GST</title>
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
    <td class="top_mid" valign="bottom"><?php include "include/financial_report_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid" align="center">
<table cellspacing="0" cellpadding="0" class="table" width="95%">
<?php
$sep_url_string='';
$sep_url= explode("?",$_SERVER['REQUEST_URI']);
if($sep_url[1] !='')
{
$sep_url_string="?".$sep_url[1];
}
?>   
	<tr class="head_td">
    <td colspan="10">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
    <?php
	if($_REQUEST['from_date'] =='')
	{
		?>
		Default Records show from <?php echo date('d/m/Y',strtotime('-30 days')) ?> to <?php echo date('d/m/Y') ?>
		<?php
	}
	?>
              <tr>
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
                <!--<td width="20%">
                        <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                <option value="">-Operation-</option>
                                <option value="delete">Delete</option>
                        </select></td>-->
						<td width="12%" align="center"><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                        <td width="10%" align="center">
                         <input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>">
                         </td>
                        <td width="10%" align="center">
                        <input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>">
                        </td>
						<td width="10%" align="center">
                        <select name="gst_student"class="input_select" >
							<option value="">Select All</option>
							<option value="with_gst">Student with GST no.</option>
							<option value="without_gst">Student w/o GST no.</option>
						</select>
                        </td>
                        <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                        <td><a href="enroll_incomming_gst_export.php<?php echo $sep_url_string; ?>"><img src="images/excel.png" height="30px" width="30px"/></a></td>  
            </tr>
        </table>
        </form>	
    </td>
  </tr>
     <?php
	 					if($_REQUEST['keyword']!="Keyword")
                            $keyword=trim($_REQUEST['keyword']);
							
                        if($keyword)
						{                            
							$pre_keyword =" and (name like '%".$keyword."%' )";
							$pre_keyword_i =" and (e.name like '%".$keyword."%' )";
						}                            
                        else
						{
                            $pre_keyword="";
							$pre_keyword_i ="";
						}
						if($_REQUEST['gst_student']!="")
							$gst_keyword =trim($_REQUEST['gst_student']);
						
						$search_cm_id='';
						$cm_ids=$_SESSION['cm_id'];
						if($_SESSION['type']=="S")
						{
							if($_REQUEST['branch_name']!='')
							{
								$branch_name=$_REQUEST['branch_name'];
								$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_cm_id=mysql_query($select_cm_id);
								$data_cm_id=mysql_fetch_array($ptr_cm_id);
								$search_cm_id=" and i.cm_id='".$data_cm_id['cm_id']."'";
								$cm_ids=$data_cm_id['cm_id'];
							}
							else
							{
								$search_cm_id='';
							}
						}
						if($gst_keyword)
						{
							if($gst_keyword=="with_gst")
							{
								$where_gst =" and e.cust_gst_no !=''";
								$where_gst_i =" and e.cust_gst_no !=''";
							}
							else if($gst_keyword=="without_gst")
							{
								$where_gst =" and e.cust_gst_no=''";
								$where_gst_i =" and e.cust_gst_no=''";
							}                            
							else
							{
								$where_gst="";
								$where_gst_i ="";
							}
						}                            
                        else
						{
                            $where_gst="";
							$where_gst_i ="";
						}
						
						if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
						{
							$frm_date=explode("/",$_REQUEST['from_date']);
							$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
							
							$pre_from_date=" and DATE(admission_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
							$installment_from_date=" and DATE(`installment_date`) >='".date('Y-m-d',strtotime($frm_dates))."'";
							$paid_from_date=" and DATE(`added_date`) >='".date('Y-m-d',strtotime($frm_dates))."'";
							$paid_from_date_i=" and DATE(i.added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
						}
						else
						{
							$pre_from_date=""; 
							if($_REQUEST['to_date']=='')
							{
								$paid_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime('-30 days'))."'";
								$paid_from_date_i=" and DATE(i.added_date) >='".date('Y-m-d',strtotime('-30 days'))."'";
							}
							else
							{
								$paid_from_date="";
								$paid_from_date_i="";
							}
							$installment_from_date="";                           
						}
						if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
						{
							$to_date=explode("/",$_REQUEST['to_date']);
							$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
							
							$pre_to_date=" and DATE(admission_date) <='".date('Y-m-d',strtotime($to_dates))."'";
							$installment_to_date=" and DATE(`installment_date`)<='".date('Y-m-d',strtotime($to_dates))."' ";
							$paid_to_date=" and DATE(added_date)<='".date('Y-m-d',strtotime($to_dates))."'";
							$paid_to_date_i=" and DATE(i.added_date)<='".date('Y-m-d',strtotime($to_dates))."'";
						}
						else
						{
							$pre_to_date="";
							$installment_to_date="";
							$paid_to_date=" and DATE(added_date)<='".date('Y-m-d')."'";
							$paid_to_date_i=" and DATE(i.added_date)<='".date('Y-m-d')."'";
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
							$select_directory='order by i.invoice_id desc';                     
							$where_cm='';
							if($_SESSION['where']!='')
							{
								$where_cm=" and i.cm_id='".$_SESSION['cm_id']."'";
							}
							$branch_id='';
                       		 
                       		"<br/>".$sql_query= "SELECT DISTINCT(i.enroll_id) FROM invoice i,enrollment e WHERE 1 and i.enroll_id=e.enroll_id ".$where_gst_i." ".$search_cm_id." ".$where_cm." ".$pre_keyword_i." ".$paid_from_date_i." ".$paid_to_date_i." and (i.cgst_tax_in_per >0 or i.sgst_tax_in_per >0) ".$select_directory." "; 
							$db=mysql_query($sql_query);
							$no_of_records=mysql_num_rows($db);
							
							if($no_of_records)
							{
								$bgColorCounter=1;
								//$_SESSION['show_records'] = 10;
								$query_string='&keyword='.$keyword.'&from_date='.$_REQUEST['from_date'].'&to_date='.$_REQUEST['to_date'].'&gst_student='.$gst_keyword.'&branch_name='.$_REQUEST['branch_name'];
								$query_string1=$query_string.$date_query;
							   // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
								$pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
								$all_records= $pager->paginate();
								?>

   

				<form method="post"  name="frmTakeAction"  action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>">
                     <input type="hidden" name="formAction" id="formAction" value=""/>
                      <tr class="grey_td" >
                        <td width="4%" align="center"><strong>Sr. No.</strong></td>
                        <td width="12%" align="center"><strong>Student Name</strong></td>
                        <td width="15%" align="center"><strong>Course Name</strong></td>
                        <td width="15%" align="center"><strong>New and Installment	</strong></td>
						<td width="15%" align="center"><strong>GST in %</strong></td>
						<td width="15%" align="center"><strong>GST Value</strong></td>
						<td width="15%" align="center"><strong>Admission date</strong></td>
                        <!--<td width="10%" align="center"><strong>Monthly Expected</strong></td>
                        <td width="14%" align="center"><strong>Installments</strong></td>-->
                      </tr>

                            <?php
							$total_paid=0;
							$total_gst_new=0;
							$monthly_expected=0;
							$total_down_cgst=0;
							$total_down_sgst=0;
							$total_down=0;
							$total_ins_cgst=0;
							$total_ins_sgst=0;
							$total_ins=0;
							$no=1;
                            while($val_query=mysql_fetch_array($all_records))
                            {
								if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
								else
                                    $bgcolor=""; 
									$listed_record_id=$val_query['enroll_id'];
                                include "include/paging_script.php";
                                echo '<tr '.$bgcolor.'>';
                                
								$sel_name="select name,cust_gst_no,added_date from enrollment where 1 and enroll_id='".$val_query['enroll_id']."'";
								$ptr_name=mysql_query($sel_name);
                                $data_name=mysql_fetch_array($ptr_name);
								$gstno='';
								if($data_name['cust_gst_no'])
								{
									$gstno='<br/>GST no: '.$data_name['cust_gst_no'].'';
								}
								echo '<td align="center">'.$sr_no.'</td>';
								echo '<td align="center">'.$data_name['name'].''.$gstno.'</td>';
								
								$sel_total_course="select enroll_id,course_id,down_payment,discount,net_fees,admission_date from enrollment where 1 and enroll_id='".$val_query['enroll_id']."' ";
								$ptr_ref=mysql_query($sel_total_course);
								$totals_courses=mysql_num_rows($ptr_ref);
								$totals_cntt=mysql_num_rows($ptr_ref);
                                echo '<td ><b>';
								while($data_total=mysql_fetch_array($ptr_ref))
								{
									$select_course = "select course_name from courses where course_id = '".$data_total['course_id']."'  ";
									$query=mysql_query($select_course);
									$val_course= mysql_fetch_array($query);
									
									echo '<b>'.$val_course['course_name'].'</b><br><img src="images/indian-rupee-16.ico">'.$data_total['net_fees'].'/-<br/>Down Payment- '.$data_total['down_payment'].'<br> Discount- '.$data_total['discount'].'<br/>Date: '.$data_total['admission_date'].'';
									
									if($totals_courses = $totals_courses-1 )
									echo '<hr />';
								}
								echo '</td>';
								//==========================NEW AND INSTALLMENT===============================================================
								$sel_inst_amnt="select enroll_id,paid,course_id,down_payment,admission_date,invoice_no from enrollment where 1 and enroll_id='".$val_query['enroll_id']."'";
								$ptr_ins_amnt=mysql_query($sel_inst_amnt);
								if($total_inst=mysql_num_rows($ptr_ins_amnt))
								{
									$amount=0;
									echo '<td>';
									while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
									{
										"<br />".$select_installments =" SELECT * FROM invoice where enroll_id ='".$data_inst_amnt['enroll_id']."' and course_id='".$data_inst_amnt['course_id']."' ".$paid_from_date." ".$paid_to_date." and amount>0 and (cgst_tax_in_per >0 or sgst_tax_in_per >0) ".$paid_from_date." ".$paid_to_date."";
										$ptr_installment = mysql_query($select_installments);
										if(mysql_num_rows($ptr_installment))
										{
											$amount=0;
											$ins=1;
											echo "<br/> ".$data_installment['type'];
											while($data_installment =mysql_fetch_array($ptr_installment))
											{
												if($data_installment['type']=="down_payment")
												{
													echo "<span style='color:blue'><strong>Down Payment</strong></span><br/>";
													echo $data_inst_amnt['down_payment'].'/- '.$data_inst_amnt['admission_date']."<br>";
												}
												else
												{
													if($ins==1)
													{
														echo "<br/><span style='color:orange'><strong>Installment</strong></span>";
													}
													if($data_installment['amount'] >0)
													{
														$sel_paymode="select payment_mode from payment_mode where payment_mode_id='".$data_installment['paid_type']."'";
														$ptr_paymode=mysql_query($sel_paymode);
														$data_paymode=mysql_fetch_array($ptr_paymode);
														
														$amount +=$data_installment['amount'];
														$col_paid ='<font color="#006600">';
														$dt=strtotime($data_installment['added_date']);
														$datess=date("Y-m-d", $dt);
														echo "<br/>".$data_installment['amount'].'/- '.$datess.' : '.$data_paymode['payment_mode'];
														$total_paid=$total_paid+$data_installment['amount'];
													}
													$ins++;
												}
											}
										}
										//echo "<br/><strong></strong>";
										//if($total_inst = $total_inst-1 )
										//echo '<hr />';
									}
									echo '</td>';
								}
								else
								{
									echo '<td align="center">--</td>';
								}
								
								
								//=================================GST in %=======================================================================
								$sel_inst_amnt="select amount,cgst_tax_in_per,cgst_tax,sgst_tax_in_per,sgst_tax,type from invoice where 1 and enroll_id='".$val_query['enroll_id']."' and amount>0 and (cgst_tax_in_per >0 or sgst_tax_in_per >0) ".$paid_from_date." ".$paid_to_date."";
								$ptr_ins_amnt=mysql_query($sel_inst_amnt);
								if($total_inst=mysql_num_rows($ptr_ins_amnt))
								{
									$in=1;
									echo '<td>';
									while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
									{
										if($data_inst_amnt['type']=="down_payment")
										{
											echo "<br/><span style='color:blue'><strong >Down Payment GST</strong></span><br/>";
											if($data_inst_amnt['cgst_tax_in_per'] > 0)
											{
												echo 'CGST ('.$data_inst_amnt['cgst_tax_in_per'].'%)';
											}
											if($data_inst_amnt['sgst_tax_in_per'] > 0)
											{
												echo ' + SGST ('.$data_inst_amnt['sgst_tax_in_per'].'%)';
											}
											echo '</br>';
											//echo $data_inst_amnt['down_payment'].'/- '.$data_inst_amnt['admissio n_date']."<br>";
										}
										else
										{
											if($in==1)
											{
												echo '<br/>';
												echo "<span style='color:orange'><strong >Installmet GST</strong></span>";
											}
											
											if($data_inst_amnt['cgst_tax_in_per'] > 0)
											{
												echo '<br/>CGST ('.$data_inst_amnt['cgst_tax_in_per'].'%)';
											}
											if($data_inst_amnt['sgst_tax_in_per'] > 0)
											{
												echo ' + SGST ('.$data_inst_amnt['sgst_tax_in_per'].'%)';
											}
											$in++;
										}
									}
									echo '</td>';
								}
								else
								{
									echo '<td align="center">--</td>';
								}
								//===============================================GST VALUE==================================================================
								$gst_amount=0;
								$down_total=0;
								"<br/>".$sel_inst_amnt="select amount,cgst_tax_in_per,cgst_tax,sgst_tax_in_per,sgst_tax,type,cf_gst_amnt from invoice where 1 and enroll_id='".$val_query['enroll_id']."' and amount>0 and (cgst_tax_in_per >0 or sgst_tax_in_per >0) ".$paid_from_date." ".$paid_to_date."";
								$ptr_ins_amnt=mysql_query($sel_inst_amnt);
								if($total_inst=mysql_num_rows($ptr_ins_amnt))
								{
									$ins=1;
									echo '<td>';
									while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
									{
										$gst_amount=0;
										if($data_inst_amnt['type'] =="down_payment")
										{
											echo "<br/><span style='color:blue'><strong >Down Payment GST</strong></span></br>";
											$down_cgst=0;
											$down_sgst=0;
											if($data_inst_amnt['cgst_tax'] > 0)
											{
												echo $down_cgst=intval($data_inst_amnt['cgst_tax']);
											}
											if($data_inst_amnt['sgst_tax'] > 0)
											{
												echo ' + ';
												echo $down_sgst=intval($data_inst_amnt['sgst_tax']);
											}
											echo ' = <strong>';
											echo $down_total=intval($down_cgst + $down_sgst);
											$total_down_cgst +=$down_cgst;
											$total_down_sgst +=$down_sgst;
											$total_down +=$down_total;
											echo'</strong>';
											echo '</br>';
											//echo $data_inst_amnt['down_payment'].'/- '.$data_inst_amnt['admissio n_date']."<br>";
										}
										else if($data_inst_amnt['cf_gst_amnt']>0)
										{
											echo "<br/><span style='color:violet'><strong >CF Loan GST</strong></span></br>";
											$cf_gst_amnt=0;
											if($data_inst_amnt['cf_gst_amnt'] > 0)
											{
												echo $cf_gst_amnt=intval($data_inst_amnt['cf_gst_amnt']);
											}
											
											echo ' = <strong>';
											echo $down_total_gst=$cf_gst_amnt;
											$total_down +=$down_total_gst;
											echo'</strong>';
											echo '</br>';
										}
										else
										{
											if($ins==1)
											{
												echo '</br>';
												echo "<span style='color:orange'><strong >Installmet GST</strong></span>";
											}
											$ins_total=0;
											$ins_cgst=0;
											$ins_sgst=0;
											if($data_inst_amnt['cgst_tax'] > 0)
											{
												echo "<br/>".$ins_cgst=intval($data_inst_amnt['cgst_tax']);
											}
											if($data_inst_amnt['sgst_tax'] > 0)
											{
												echo ' + ';
												echo $ins_sgst=intval($data_inst_amnt['sgst_tax']);
											}
											echo ' = <strong>';
											echo $ins_total=intval($ins_cgst + $ins_sgst);
											$total_ins_cgst +=$ins_cgst;
											$total_ins_sgst +=$ins_sgst;
											$total_ins +=$ins_total;
											echo'</strong>';
											echo '</br>';
											$ins++;
										}
										
										/*"<br />".$select_installments = " SELECT * FROM invoice where enroll_id ='".$data_inst_amnt['enroll_id']."' and course_id='".$data_inst_amnt['course_id']."' and invoice_id !='".$data_inst_amnt['invoice_no']."' and amount > 0 ";
										$ptr_installment = mysql_query($select_installments);
										if(mysql_num_rows($ptr_installment))
										{
											echo "<br/><strong >Installment GST</strong></br>";
											while($data_installment = mysql_fetch_array($ptr_installment))
											{
												if($data_installment['cgst_tax'] >0 || $data_installment['sgst_tax'] >0)
												{
													$inst_cgst=0;
													$inst_sgst=0;
													if($data_installment['cgst_tax'] > 0)
													{
														echo $inst_cgst=$data_installment['cgst_tax'];
													}
													if($data_installment['sgst_tax'] > 0)
													{
														echo ' + ';
														echo $inst_sgst=$data_installment['sgst_tax'];
													}
													
													echo ' = <strong>';
													echo $inst_total=intval($inst_cgst + $inst_sgst);
													echo'</strong>';
													//echo $data_installment['amount'].'/- '.$datess.' : '.$data_paymode['payment_mode']."<br>";
													//$total_paid=$total_paid+$data_installment['amount'];
												}
											}
										}
										$gst_amount=intval($down_total+$inst_total);
										$total_gst +=$gst_amount;
										echo "<br/><br/><strong>Total GST- ".$gst_amount."<strong><br/>";
										if($total_inst = $total_inst-1 )
										echo '<hr />';*/
									}
									echo '</td>';
								}
								else
								{
									echo '<td align="center">--</td>';
								}
								$sep=explode(" ",$data_name['added_date']);
								$sep_date=explode("-",$sep[0]);
								$date=$sep_date[2]."/".$sep_date[1]."/".$sep_date[0];
								echo "<td align='center'>".$date."</td>";
								   
								/*$sel_inst_amnt="select course_id,enroll_id,balance_amt from enrollment where 1 and ref_id='".$val_query['enroll_id']."' || enroll_id='".$val_query['enroll_id']."'";
								$ptr_ins_amnt=mysql_query($sel_inst_amnt);
								if($total_inst=mysql_num_rows($ptr_ins_amnt))
								{
									
									echo '<td>';
									while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
									{
										$expected=0;
										"<br />".$select_installments = " SELECT * FROM installment where enroll_id ='".$data_inst_amnt['enroll_id']."' and course_id='".$data_inst_amnt['course_id']."' ".$installment_from_date." ".$installment_to_date." ";
										$ptr_installment = mysql_query($select_installments);
										if(mysql_num_rows($ptr_installment))
										{
											$expected=0;
											while($data_installment = mysql_fetch_array($ptr_installment))
											{
											 	$expected = $expected + $data_installment['installment_amount'];	
												$monthly_expected= $monthly_expected + $data_installment['installment_amount'];
											}
										}
										echo "<strong>".$expected."<strong>";
										if($total_inst = $total_inst-1 )
										echo '<hr />';
									}
									
									echo '</td>';
								}
								else
								{
									echo '<td align="center">--</td>';
								}
								   
								   
								   
								$sel_inst_amnt="select course_id,enroll_id,balance_amt from enrollment where 1 and ref_id='".$val_query['enroll_id']."' || enroll_id='".$val_query['enroll_id']."'";
								$ptr_ins_amnt=mysql_query($sel_inst_amnt);
								if($total_inst=mysql_num_rows($ptr_ins_amnt))
								{
									echo '<td>';
									while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
									{
										
										"<br />".$select_installments = " SELECT * FROM installment where enroll_id ='".$data_inst_amnt['enroll_id']."' and course_id='".$data_inst_amnt['course_id']."' ".$installment_from_date." ".$installment_to_date." ";
										$ptr_installment = mysql_query($select_installments);
										if(mysql_num_rows($ptr_installment))
										{
											while($data_installment = mysql_fetch_array($ptr_installment))
											{
												$col_paid ='<font color="#006600">';
												if($data_installment[status] =='not paid')
												$col_paid ='<font color="#FF3333">';
												if($data_installment['installment_date'] < date("Y-m-d"))
												$past_rec='<img src="images/overdue.gif" />';
												else
												$past_rec='';
											 	echo $data_installment[installment_amount].'/- '.$data_installment[installment_date].' : '.$col_paid.$data_installment[status].$past_rec."</font><br>";	
											}
										}
										echo "<strong>Total Remaining- ".$data_inst_amnt['balance_amt']."<strong><br/>";
										if($total_inst = $total_inst-1 )
									echo '<hr />';
									}
										echo '</td>';
								}
								else
								{
									echo '<td align="center">--</td>';
								}
                               */
                                echo '</tr>';
								$no++;
								$bgColorCounter++;
							}

                                ?>

                                <tr class="grey_td">

    <td colspan="15">
    	<table cellspacing="0" cellpadding="0" width="100%"  style="border:1 px solid #CCC; border-collapse:collapse">
        	<tr class="grey_td">
                <td width="31%" colspan="3" align="center"><strong>Total</strong></td>
                <td width="15%" align="left"><span style='color:blue'><strong>Down Payment</strong></span><br/>CGST- <?php echo $total_down_cgst; ?><br/>SGST- <?php echo $total_down_sgst; ?><br/><span style='color:blue'><strong>Total- <?php echo $total_down; ?></strong></span></td>
				<td width="15%" align="left"><span style='color:orange'><strong>Installments</strong></span><br/>CGST- <?php echo $total_ins_cgst; ?><br/>SGST- <?php echo $total_ins_sgst; ?><br/><span style='color:orange'><strong>Total- <?php echo $total_ins; ?></strong></span></td>
				<td width="15%" align="left"><span style='color:red'><strong>Total</strong></span><br/>CGST- <?php echo $total_down_cgst+$total_ins_cgst; ?><br/>SGST- <?php echo $total_down_sgst+$total_ins_sgst; ?><br/><span style='color:red'><strong>Total- <?php echo $total_down+$total_ins; ?></strong></span></td>
				<td width="15%"></td>
            </tr>
    	</table>
    </td>

    </tr>
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

