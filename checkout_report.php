<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Checkout Report</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='151'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
<script type="text/javascript" src="../js/common.js"></script> 
<!--added by Tejassee---->
<link rel="stylesheet" href="js/chosen.css" />
<script src="js/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">

$(document).ready(function()
{   
	
	$("#brands_id").chosen({allow_single_deselect:true});
	$("#employee_id").chosen({allow_single_deselect:true});
    $("#pdt_id").chosen({allow_single_deselect:true});
	
});
</script>
<script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
 <!--end ---->
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
    function select_employee(branch_name)
    {
	var data1="action=employee&branch_name="+branch_name;	
	//alert(data1);
	$.ajax({
	url: "get_employee.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
       
		if(html !='')
		{
            //alert(html);
			document.getElementById("emp_id").innerHTML=html;
			$("#employee_id").chosen({allow_single_deselect:true});
		}
	},
       error:function(exception){alert('Exception:'+exception);}
	});
    }

    function show_product(product_id){

        var data1="action=getproduct&product_id="+product_id;	
	//alert(data1);
	$.ajax({
	url: "get_product.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
       
		if(html !='')
		{
           // alert(html);
			document.getElementById("pd_id").innerHTML=html;
			$("#pdt_id").chosen({allow_single_deselect:true});
		}
	},
       error:function(exception){alert('Exception:'+exception);}
	});

    }
    </script>
    <script type="text/javascript">
       
       $(document).ready(function()
       {            
           $('.datepicker').datepicker({ changeMonth: true,changeYear: true,dateFormat:"dd/mm/yy", showButtonPanel: true, closeText: 'Clear'});
           $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
           {
               res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
           }
           
   
       });
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
<?php
$sep_url_string='';
$sep_url= explode("?",$_SERVER['REQUEST_URI']);
if($sep_url[1] !='')
{
$sep_url_string="?".$sep_url[1];
}
?>
    
  <tr class="head_td">
    <td colspan="9">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                
               	<?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
				{
					?>
				 	<td width="15%">
					<select name="branch_name" id="branch_name" class="input_select_login" onchange="select_employee(this.value)" style="width: 150px; ">
						<option value="">-Branch Name-</option>
						<?php 
							$sel_branch="select branch_id,branch_name from branch";
							$ptr_sel=mysql_query($sel_branch);
							while($data_branch=mysql_fetch_array($ptr_sel))
							{
								$sel='';
								if($data_branch['branch_name']==$_REQUEST['branch_name'])
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
                <td width="15%" id="emp_id">
					<select name="employee_id" id="employee_id"  class="input_select_login"  style="width: 150px;" onchange="show_product(this.value)">
						<option value="">Select Employee</option>
						<?php
						$sel_emp="select name,admin_id from site_setting where 1 ".$_SESSION['where']." and system_status='Enabled'";
                        $ptr_emp=mysql_query($sel_emp);
						while($data_emp=mysql_fetch_array($ptr_emp))
						{
							$selected='';
							if($data_emp['admin_id'] == $_REQUEST['employee_id'])
							{
								$selected='selected="selected"';
							}
							echo '<option '.$selected.' value="'.$data_emp['admin_id'].'">'.$data_emp['name'].'</option>';
						}
						
						?>
					</select>
				</td>
                <td width="15%">
                <select name="brand_id"  id="brands_id" class="input_select_login" style="width: 150px;">
                        <option value="">Select brand</option> 
                          <?php  
                          $sql_dest ="select brand_name, brand_id from product_brand where 1 order by brand_id asc";//".$_SESSION['user_id']."
                          $ptr_edes = mysql_query($sql_dest);
                          while($data_dist = mysql_fetch_array($ptr_edes))
                          { 
	                         // $selecteds = '';
                            //   if($data_dist['brand_id']==$row_record['brand_id'])
                            //   $selecteds = 'selected="selected"';	                                 
                              echo "<option value='".$data_dist['brand_id']."' ".$selecteds.">".$data_dist['brand_name']."</option>";
                          }
                          ?>
                        </select>
                </td>
                <td width="15%" id="pd_id">
                <select name="product_name" class="input_select_login" id="pdt_id"  style="width: 150px;">
                        <option value="">Select Product</option> 
                          <?php  
                          $sql_dest ="select product_name, product_id from product where 1 order by product_id asc";//".$_SESSION['user_id']."
                          $ptr_edes = mysql_query($sql_dest);
                          while($data_dist = mysql_fetch_array($ptr_edes))
                          { 
	                         // $selecteds = '';
                            //   if($data_dist['brand_id']==$row_record['brand_id'])
                            //   $selecteds = 'selected="selected"';	                                 
                              echo "<option value='".$data_dist['product_id']."' ".$selecteds.">".$data_dist['product_name']."</option>";
                          }
                          ?>
                        </select>
                </td>

                <td width="15%"><input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>"></td>
                <td width="15%"><input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>"></td>
                        
                
                <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
                <?php
				if($_SESSION['type']=='S'  || $edit_access=='yes')
				{
					?>
					<td> <a href="checkout_export.php<?php echo $sep_url_string; ?>"><img src="images/excel.png" height="30px" width="30px"/></a></td>  
					<?php
				}
				?>
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
						$cm_ids=$_SESSION['cm_id'];
						if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
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
						if($_REQUEST['employee_id'])
						{
							$emp_id=$_REQUEST['employee_id'];
							$employee_id=" and employee_id ='".$emp_id."'";
						}
						else
						{
							$employee_id=""; 
                        }
                        if($_REQUEST['brand_id'])
						{
							$emp_id=$_REQUEST['brand_id'];
							$brand_id=" and p.brand ='".$emp_id."'";
						}
						else
						{
							$brand_id=""; 
                        }
                        if($_REQUEST['product_name'])
						{
							$p_id=$_REQUEST['product_name'];
                            $product_id="and cpm.product_id ='".$p_id."'";
                            
                            $p_id1=$_REQUEST['product_name'];
							$product_id1="and product_id ='".$p_id1."'";
						}
						else
						{
                            $product_id=""; 
                            $product_id1="";
                        }

                       
                        
                        if($_REQUEST['from_date']!="")
						{
							$sep=explode("/",$_REQUEST['from_date']);
							$from_date=$sep[2]."-".$sep[1]."-".$sep[0];
                          	$from_date=" and added_date >='".date('Y-m-d',strtotime($from_date))."'";
						}
						if($_REQUEST['to_date']!="")
						{
							$sep=explode("/",$_REQUEST['to_date']);
							$to_date=$sep[2]."-".$sep[1]."-".$sep[0];
                            $to_date=" and added_date <='".date('Y-m-d',strtotime($to_date))."'";
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

                        if($_GET['orderby']=='pcategory_name' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='pcategory_name'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                                                 
                            $sql_query= "select DISTINCT(employee_id) from checkout_product_map where 1 ".$_SESSION['where']." ".$search_cm_id." ".$employee_id."  ".$from_date." ".$to_date." order by employee_id asc"; 
                       		//echo $sql_query;
                        	$no_of_records=mysql_num_rows($db->query($sql_query));
                        	if($no_of_records)
                        	{
                            	$bgColorCounter=1;
                            	//$_SESSION['show_records'] = 10;
                            	$query_string='&keyword='.$keyword.'&employee_id='.$_REQUEST['employee_id'].'&from_date='.$_GET['from_date'].'&to_date='.$_GET['to_date'].'&branch_name='.$_GET['branch_name'].'&product_name='.$_GET['product_name'];
                            	$query_string1=$query_string.$date_query;
                           		// $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            	$pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            	$all_records= $pager->paginate();
                            	?>
    			<form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                     <input type="hidden" name="formAction" id="formAction" value=""/>
                      <tr class="grey_td" >
                      	
                        <td width="3%" align="center"><strong>Sr. No.</strong></td>
                        <td width="8%" align="center"><strong>Employee Name</strong></td>
                        <td width="10%" align="center"><strong>Product Name</strong></td>
                        <td width="10%" align="center" colspan="3"><strong>Consumable Quantity</strong></td>
                        <td width="10%" align="center" colspan="3"><strong>Available Quantity</strong></td>
                        
                      </tr>
                      <tr class="grey_td" >
                      	
                          <td width="3%" align="center"></td>
                          <td width="8%" align="center"></td>
                          <td width="10%" align="center"></td>
                          <td width="3%" align="center"><strong>stock</strong></td>
                          <td width="3%" align="center"><strong>Consumable </strong></td>
                          <td width="3%" align="center"><strong>Shelf</strong></td>
                          <td width="3%" align="center"><strong>stock</strong></td>
                          <td width="3%" align="center"><strong>Consumable</strong></td>
                          <td width="3%" align="center"><strong>Shelf </strong></td>
                          
                        </tr>
                            <?php

                            while($val_query=mysql_fetch_array($all_records))
                            {
								$sel_name="select name from site_setting where admin_id='".$val_query['employee_id']."'";
								$ptr_name=mysql_query($sel_name);
								if(mysql_num_rows($ptr_name))
								{
									$data_names=mysql_fetch_array($ptr_name);
									
									
									if($bgColorCounter%2==0)
										$bgcolor='class="grey_td"';
									else
										$bgcolor="";                
									$listed_record_id=$val_query['pcategory_id']; 
									include "include/paging_script.php";
									echo '<tr '.$bgcolor.' >';
										 
									echo '<td width="3%" align="center">'.$sr_no.'</td>';  
									
									
										 
									echo '<td width="8%" align="center">'.$data_names['name'].'</td>';
									
									echo '<td width="10%" style="padding-top:10px;padding-bottom:10px">';
									
                                    "<br/>".$select_product_ids="select DISTINCT(cpm.product_id) from checkout_product_map cpm,product p where cpm.employee_id='".$val_query['employee_id']."' ".$product_id." ".$brand_id." and cpm.product_id=p.product_id";
  
                                   // $select_product_ids="select DISTINCT(product_id) from checkout_product_map where employee_id='".$val_query['employee_id']."' ".$product_id." order by product_id asc";
									$query_product_ids=mysql_query($select_product_ids);
									$count_prod_ids=mysql_num_rows($query_product_ids);
                                    $a=1;
                                   
									while($fetch_prod_ids=mysql_fetch_array($query_product_ids))
									{
										$sel_product="select product_name from product where product_id ='".$fetch_prod_ids['product_id']."' ".$brand_id." ";
										$ptr_product=mysql_query($sel_product);
                                        $data_product=mysql_fetch_array($ptr_product);
                                        if($a % 2 == 0){
                                        echo'<div style="background-color:#F6F6F7;">';
										echo $data_product['product_name'];
                                        echo '<hr style="color:#E2E2E2;">';
                                        echo'</div>';
										//if($a!=$count_prod_ids)
                                        // echo '<hr>';
                                    }else{
                                        echo'<div style="">';
										echo $data_product['product_name'];
                                        echo '<hr style="color:#E2E2E2;">';
                                        echo'</div>';
                                    }
										$a++;
									}                               
                                   
                                
									echo '</td>';
									
								   echo '<td width="3%" style="padding-top:10px;padding-bottom:10px" align="center">';
                                   //$select_product_ids="select DISTINCT(cpm.product_id) from checkout_product_map cpm,product p where cpm.employee_id='".$val_query['employee_id']."' ".$product_id." ".$brand_id." and cpm.product_id=p.product_id";
  
                                   "<br/>".$select_product_ids1="select DISTINCT(cpm.product_id) from checkout_product_map cpm,product p where cpm.employee_id='".$val_query['employee_id']."' ".$product_id." ".$brand_id." and cpm.product_id=p.product_id";
                                   $query_product_ids1=mysql_query($select_product_ids1);
									$count_prod_ids1=mysql_num_rows($query_product_ids1);
									$a=1;
									while($fetch_prod_ids1=mysql_fetch_array($query_product_ids1))
									{
										$select_product_qty="select SUM(issue_qty) as issue_qty from checkout_product_map where employee_id='".$val_query['employee_id']."' and product_id='".$fetch_prod_ids1['product_id']."'";
										$query_product_qty=mysql_query($select_product_qty);
										$count_prod_qty=mysql_num_rows($query_product_qty);
                                        if($a % 2 == 0){
										while($fetch_prod_qty=mysql_fetch_array($query_product_qty))
										{
											
                                            if($fetch_prod_qty['issue_qty'] != ''){
                                                echo'<div style="background-color:#F6F6F7;">';
                                                echo $fetch_prod_qty['issue_qty'];
                                                echo '<hr style="color:#E2E2E2;">';
                                                echo'</div>';
                                               
                                                }else{
                                                    echo'<div style="background-color:#F6F6F7;">0</div>';
                                                    echo '<hr style="color:#E2E2E2;">';
                                                }
											
                                        }
                                    }else{
                                        while($fetch_prod_qty=mysql_fetch_array($query_product_qty))
										{
										

                                        if($fetch_prod_qty['issue_qty'] != ''){
                                            echo'<div style="">';
                                            echo $fetch_prod_qty['issue_qty'];
                                            echo '<hr style="color:#E2E2E2;">';
                                            echo'</div>';
                                           
                                            }else{
                                                echo'<div style="">0<hr style="color:#E2E2E2;"></div>';
                                               // echo '<hr>';
                                            }
                                        }
                                    }
										
										//if($a!=$count_prod_ids1)
											// echo '<hr>';
											
											$a++;
									}
									
                                    echo '</td>';
                                    
                                   echo' <td width="3%" style="padding-top:10px;padding-bottom:10px" align="center">';
                                   //$select_product_ids="select DISTINCT(cpm.product_id) from checkout_product_map cpm,product p where cpm.employee_id='".$val_query['employee_id']."' ".$product_id." ".$brand_id." and cpm.product_id=p.product_id";
                                   "<br/>".$select_product_ids1="select DISTINCT(cpm.product_id) from checkout_product_map cpm,product p where cpm.employee_id='".$val_query['employee_id']."' ".$product_id." ".$brand_id." and cpm.product_id=p.product_id";
                                  $query_product_ids1=mysql_query($select_product_ids1);
                                   $count_prod_ids1=mysql_num_rows($query_product_ids1);
                                   $a=1;
                                   while($fetch_prod_ids1=mysql_fetch_array($query_product_ids1))
                                   {
                                       $select_product_qty="select SUM(issue_qty) as issue_qty from checkout_product_map where employee_id='".$val_query['employee_id']."' and product_id='".$fetch_prod_ids1['product_id']."' and type='consumable'";
                                       $query_product_qty=mysql_query($select_product_qty);
                                       $count_prod_qty=mysql_num_rows($query_product_qty);
                                       
                                       if($a % 2 == 0){
										while($fetch_prod_qty=mysql_fetch_array($query_product_qty))
										{
											
                                            if($fetch_prod_qty['issue_qty'] != ''){
                                                echo'<div style="background-color:#F6F6F7;">';
                                                echo $fetch_prod_qty['issue_qty'];
                                                echo '<hr style="color:#E2E2E2;">';
                                                echo'</div>';
                                               
                                                }else{
                                                    echo'<div style="background-color:#F6F6F7;">0<hr style="color:#E2E2E2;"></div>';
                                                   // echo '';
                                                }
											
                                        }
                                    }else{
                                        while($fetch_prod_qty=mysql_fetch_array($query_product_qty))
										{
										

                                        if($fetch_prod_qty['issue_qty'] != ''){
                                            echo'<div style="">';
                                            echo $fetch_prod_qty['issue_qty'];
                                            echo '<hr style="color:#E2E2E2;">';
                                            echo'</div>';
                                           
                                            }else{
                                                echo'<div style="">0<hr style="color:#E2E2E2;"></div>';
                                               // echo '<hr>';
                                            }
                                        }
                                    }
                                       
                                      // if($a!=$count_prod_ids1)
                                          
                                          //  echo '<hr>';
                                         
                                          
                                           $a++;
                                   }
                                   
                                   echo '</td>';
                                   echo' <td width="3%" style="padding-top:10px;padding-bottom:10px" align="center">';
                                   "<br/>".$select_product_ids1="select DISTINCT(cpm.product_id) from checkout_product_map cpm,product p where cpm.employee_id='".$val_query['employee_id']."' ".$product_id." ".$brand_id." and cpm.product_id=p.product_id";
                                   $query_product_ids1=mysql_query($select_product_ids1);
                                   $count_prod_ids1=mysql_num_rows($query_product_ids1);
                                   $a=1;
                                   while($fetch_prod_ids1=mysql_fetch_array($query_product_ids1))
                                   {
                                       $select_product_qty="select SUM(issue_qty) as issue_qty from checkout_product_map where employee_id='".$val_query['employee_id']."' and product_id='".$fetch_prod_ids1['product_id']."' and type='shelf'";
                                       $query_product_qty=mysql_query($select_product_qty);
                                       $count_prod_qty=mysql_num_rows($query_product_qty);
                                       
                                       if($a % 2 == 0){
										while($fetch_prod_qty=mysql_fetch_array($query_product_qty))
										{
											
                                            if($fetch_prod_qty['issue_qty'] != ''){
                                                echo'<div style="background-color:#F6F6F7;">';
                                                echo $fetch_prod_qty['issue_qty'];
                                                echo '<hr style="color:#E2E2E2;">';
                                                echo'</div>';
                                               
                                                }else{
                                                    echo'<div style="background-color:#F6F6F7;">0<hr style="color:#E2E2E2;"></div>';
                                                    //echo '';
                                                }
											
                                        }
                                    }else{
                                        while($fetch_prod_qty=mysql_fetch_array($query_product_qty))
										{
										

                                        if($fetch_prod_qty['issue_qty'] != ''){
                                            echo'<div style="">';
                                            echo $fetch_prod_qty['issue_qty'];
                                            echo '<hr style="color:#E2E2E2;">';
                                            echo'</div>';
                                           
                                            }else{
                                                echo'<div style="">0<hr style="color:#E2E2E2;"></div>';
                                               // echo '<hr>';
                                            }
                                        }
                                        
                                    }
                                       
                                       //if($a!=$count_prod_ids1)   
                                           $a++;
                                   }
                                   
                                   echo '</td>';
                                   echo' <td width="3%" style="padding-top:10px;padding-bottom:60px" align="center">';
                                   "<br/>".$select_product_ids1="select DISTINCT(product_id) from product_user_map where user_id='".$val_query['employee_id']."' ".$product_id1." order by product_id asc";
                                  
                                   //$select_product_ids1="select DISTINCT(product_id) from product_user_map where user_id='".$val_query['employee_id']."' ";
                                   $query_product_ids1=mysql_query($select_product_ids1);
                                   $count_prod_ids1=mysql_num_rows($query_product_ids1);
                                   $a=1;
                                   while($fetch_prod_ids1=mysql_fetch_array($query_product_ids1))
                                   {
                                       $select_product_qty="select SUM(quantity) as quantity from product_user_map where user_id='".$val_query['employee_id']."' and product_id='".$fetch_prod_ids1['product_id']."'";
                                       $query_product_qty=mysql_query($select_product_qty);
                                       $count_prod_qty=mysql_num_rows($query_product_qty);
                                       
                                       while($fetch_prod_qty=mysql_fetch_array($query_product_qty))
                                       {
                                           
                                        if($a % 2 == 0){

                                          if($fetch_prod_qty['quantity'] != ''){
                                            echo'<div style="background-color:#F6F6F7;">';
                                            echo $fetch_prod_qty['quantity'];
                                            echo '<hr style="color:#E2E2E2;">';
                                            echo'</div>';
                                            
                                           }else{
                                               echo'<div style="background-color:#F6F6F7;">0<hr style="color:#E2E2E2;"></div>';
                                              
                                           }

                                        }else{

                                            if($fetch_prod_qty['quantity'] != ''){
                                                echo'<div style="">';
                                                echo $fetch_prod_qty['quantity'];
                                                echo '<hr style="color:#E2E2E2;">';
                                                echo'</div>';
                                               
                                               }else{
                                                   echo'<div style="">0<hr style="color:#E2E2E2;"></div>';
                                                   //echo '<hr>';
                                               }


                                        }

                                       }
                                    //    if($count_prod_ids1 < $a){
                                    //     echo'<div style="">0</div>';
                                    //     echo '<hr>';
                                    //    }
                                      //echo $count_prod_ids1;
                                           $a++;
                                   }
                                   
                                   echo '</td>';

                                   echo' <td width="3%" style="padding-top:10px;padding-bottom:60px" align="center">';
                                   "<br/>".$select_product_ids1="select DISTINCT(product_id) from product_user_map where user_id='".$val_query['employee_id']."' ".$product_id1." order by product_id asc ";
                                  $query_product_ids1=mysql_query($select_product_ids1);
                                   $count_prod_ids1=mysql_num_rows($query_product_ids1);
                                   $a=1;
                                   while($fetch_prod_ids1=mysql_fetch_array($query_product_ids1))
                                   {
                                     $select_product_qty="select SUM(quantity_in_consumable) as quantity_in_consumable from product_user_map where user_id='".$val_query['employee_id']."' and product_id='".$fetch_prod_ids1['product_id']."'";
                                       $query_product_qty=mysql_query($select_product_qty);
                                       $count_prod_qty=mysql_num_rows($query_product_qty);
                                       
                                       while($fetch_prod_qty=mysql_fetch_array($query_product_qty))
                                       {
                                           
                                          // echo $fetch_prod_qty['quantity'];
                                          // echo '<hr>';
                                            if($a % 2 == 0){
                                          if($fetch_prod_qty['quantity_in_consumable'] != ''){
                                            echo'<div style="background-color:#F6F6F7;">';
                                            echo $fetch_prod_qty['quantity_in_consumable'];
                                            echo '<hr style="color:#E2E2E2;">';
                                            echo'</div>';
                                           
                                           }else{
                                               echo'<div style="background-color:#F6F6F7;">0 <hr style="color:#E2E2E2;"></div>';
                                              
                                           }
                                        }else{

                                            if($fetch_prod_qty['quantity_in_consumable'] != ''){
                                                echo'<div style="">';
                                                echo $fetch_prod_qty['quantity_in_consumable'];
                                                echo '<hr style="color:#E2E2E2;">';
                                                echo'</div>';
                                               
                                               }else{
                                                   echo'<div style="">0 <hr style="color:#E2E2E2;"></div>';
                                                  
                                               }

                                        }
                                       }                          
                                           $a++;
                                   }
                                   
                                   echo '</td>';
                          
                                   echo' <td width="3%" style="padding-top:10px;padding-bottom:60px" align="center">';
                                   "<br/>".$select_product_ids1="select DISTINCT(product_id) from product_user_map where user_id='".$val_query['employee_id']."' ".$product_id1." order by product_id asc ";
                                   $query_product_ids1=mysql_query($select_product_ids1);
                                   $count_prod_ids1=mysql_num_rows($query_product_ids1);
                                   $a=1;
                                   while($fetch_prod_ids1=mysql_fetch_array($query_product_ids1))
                                   {
                                       $select_product_qty="select SUM(quantity_in_shelf) as quantity_in_shelf from product_user_map where user_id='".$val_query['employee_id']."' and product_id='".$fetch_prod_ids1['product_id']."'";
                                       $query_product_qty=mysql_query($select_product_qty);
                                       $count_prod_qty=mysql_num_rows($query_product_qty);
                                       
                                       while($fetch_prod_qty=mysql_fetch_array($query_product_qty))
                                       {
                                           
                                          // echo $fetch_prod_qty['quantity'];
                                          // echo '<hr>';
                                          if($a % 2 == 0){
                                          if($fetch_prod_qty['quantity_in_shelf'] != ''){
                                            echo'<div style="background-color:#F6F6F7;">';
                                            echo $fetch_prod_qty['quantity_in_shelf'];
                                            echo '<hr style="color:#E2E2E2;">';
                                            echo'</div>';
                                           
                                           }else{
                                               echo'<div style="background-color:#F6F6F7;">0<hr style="color:#E2E2E2;"></div>';
                                               //echo '<hr>';
                                           }
                                        }else{

                                            if($fetch_prod_qty['quantity_in_shelf'] != ''){
                                                echo'<div style="">';
                                                echo $fetch_prod_qty['quantity_in_shelf'];
                                                echo '<hr style="color:#E2E2E2;">';
                                                echo'</div>';
                                               
                                               }else{
                                                   echo'<div style="">0<hr style="color:#E2E2E2;"></div>';
                                                   echo '';
                                               }

                                        }
                                       }
                                       
                                      
                                           $a++;
                                   }
                                   
                                   echo '</td>';
								   
									echo '</tr>';
																	
									$bgColorCounter++;
								}
                            }    
                                ?>
  
  
  <tr class="head_td">
    <td colspan="8">
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
