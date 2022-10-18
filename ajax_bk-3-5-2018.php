<?php include 'inc_classes.php';
 
    $action = $_POST['action'];
	if($action=='custome_course_submit')
    {	
		$branch_name=$_POST['branch_name'];
        $data_record['admin_id'] = $_SESSION['admin_id'];
        $data_record['category_id'] = $_POST['category_id'];
        $data_record['course_name'] = $_POST['course_name'];
        $data_record['course_description'] = $_POST['course_desc'];
        $data_record['course_duration'] = $_POST['course_duration'];
        $data_record['course_price'] = $_POST['course_fee'];
        $data_record['added_date'] = date('Y-m-d H:i:s');
        $courses_id=$db->query_insert("courses", $data_record);
        //------send notification on inquiry addition-----
		
			$notification_args['reference_id'] = $courses_id;
			$notification_args['on_action'] = 'course_added';
			$notification_status = addNotifications($notification_args);
			
			$subject = "New Custom Course Added by ".$name." on ".$GLOBALS['domainName']."";
			$message .= '
			<table cellpadding="3" align="left" cellspacing="3" width="75%">
			 <tr>
				<td width="35%"><strong>Course Name</strong></td>
				<td>:</td>
				<td width="65%"><a href="http://www.isasbeautyschool.com/faculty_login/add_course.php?record_id='.$courses_id.'">'.$name.'</a></td>
				
			</tr>';
			
			$sel_category= "select category_id,category_name from course_category where category_id='".$data_record['category_id']."'";
			$ptr_cate=mysql_query($sel_category);
			$data_cate=mysql_fetch_array($ptr_cate);
			
			$message .= '
			
			 <tr>
				<td width="35%"><strong>Course Category</strong></td>
				<td>:</td>
				<td width="65%">'.$data_cate['category_name'].'</td>
				
			</tr>';
			$message .= '
			
			 <tr>
				<td width="35%"><strong>Course Duration</strong></td>
				<td>:</td>
				<td width="65%">'.$data_record['course_duration'].'</td>
				
			</tr>';
			$message .= '
			
			 <tr>
				<td width="35%"><strong>Course Fees</strong></td>
				<td>:</td>
				<td width="65%">'.$data_record['course_price'].'</td>
				
			</tr>';
			$message .= '
			
			 <tr>
				<td width="35%"><strong>Course Descreption</strong></td>
				<td>:</td>
				<td width="65%">'.$data_record['course_description'].'</td>
				
			</tr>
			 </table>';
													
			$sendMessage=$GLOBALS['box_message_top'];
			$sendMessage.=$message;
			$sendMessage.=$GLOBALS['box_message_bottom'];
			$from_id='support<support@'.$GLOBALS['domainName'].'>';
			$headers= 'MIME-Version: 1.0' . "\n";
			$headers.='Content-type: text/html; charset=utf-8' . "\n";
			$headers.='From:'.$from_id;
			//echo $to.$sendMessage;
			
			if($_SERVER['HTTP_HOST']!="localhost" && $_SERVER['HTTP_HOST']!="localhost:81")//|| $_SERVER['HTTP_HOST']=="hindavi-1"
			 {
				 $select_email_id = " select email from site_setting where (cm_id='".$_SESSION['cm_id']."' or admin_id='".$_SESSION['admin_id']."' or branch_name='".$branch_name."') and (type='A' or type='C') and email !='' ";
			$ptr_emails = mysql_query($select_email_id);
				while($data_emails = mysql_fetch_array($ptr_emails))
				{
					mail($data_emails['email'], $subject, $sendMessage, $headers);
				}
			 }
			
	  //-----------------------------------------------
        ?>
        <select id="course_id" name="course_id" onChange="ajax_course(this.value);">
            <option value="select">Select</option>
            <?php
            $course_category = " select category_name,category_id from course_category ";
            $ptr_course_cat = mysql_query($course_category);
            while($data_cat = mysql_fetch_array($ptr_course_cat))
            {
                echo " <optgroup label='".$data_cat['category_name']."'>";

                $get="SELECT course_id,course_name FROM courses where category_id='".$data_cat['category_id']."' order by course_id";
                $myQuery=mysql_query($get);
                while($row = mysql_fetch_assoc($myQuery))
                {
                ?>
            <option value = "<?php echo $row['course_id']?>" <?php if($courses_id == $row['course_id']) echo 'selected="selected"';?>> <?php echo $row['course_name'] ?> </option>
                <?php 
                }
                echo " </optgroup>";
            }?>
            <option value="custome">Customized Course</option>
        </select>
        <?php
    }
	

//===============================================================ADD KIT===========================================================================================
if($action=='custome_customer_submit')
{	$branch_name=$_POST['branch_name'];
	if($_SESSION['type']=='S')
	{
		$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
		$ptr_branch=mysql_query($sel_branch);
		$data_branch=mysql_fetch_array($ptr_branch);
		$cm_id=$data_branch['cm_id'];
		$branch_name1=$branch_name;
		$data_record['cm_id']=$cm_id;
		$data_record['branch_name']=$branch_name1;
	}	
	else
	{
		$branch_name1=$_SESSION['branch_name'];
		$data_record['cm_id']=$_SESSION['cm_id'];
		$data_record['branch_name']=$branch_name1;
	}
	
	$data_record['cust_name'] = $_POST['customer_name'];
	$data_record['mobile1'] = $_POST['mobile'];
	$data_record['email'] = $_POST['email'];
	
	$sel_cust_id="select cust_id from customer where cust_name='".$data_record['cust_name']."' and cm_id='".$data_record['cm_id']."'";
	$ptr_cust_id=mysql_query($sel_cust_id);
	if(!mysql_num_rows($ptr_cust_id))
	{
		if($data_record['mobile1'] !='')
		{
			$sel_mobile_ext="select mobile1,email from customer where mobile1 ='".$data_record['mobile1']."' and cm_id='".$data_record['cm_id']."' ";
			$ptr_mobile_ext=mysql_query($sel_mobile_ext);
			if(!mysql_num_rows($ptr_mobile_ext))
			{
				$data_cust=mysql_fetch_array($ptr_mobile_ext);
				$data_record['added_date'] = date('Y-m-d H:i:s');
				$customer_id=$db->query_insert("customer", $data_record);
				//------send notification on inquiry addition-----		
				/*$notification_args['reference_id'] = $courses_id;
				$notification_args['on_action'] = 'course_added';
				$notification_status = addNotifications($notification_args);
				*/
				?>
				<select name="customer_id" id="customer_id" style="width:200px;" required onChange="getMembership(this.value)">
				 <option value="">Select Customer</option> 
				  <?php  
					$sql_cust = "select cust_name, cust_id from customer where 1 ".$_SESSION['where']." order by cust_name asc";
					$ptr_cust = mysql_query($sql_cust);
					while($data_cust = mysql_fetch_array($ptr_cust))
					{ 
						$selecteds = '';
						if($data_cust['cust_id']==$customer_id)
						$selecteds = 'selected="selected"';	
						echo "<option value='".$data_cust['cust_id']."' ".$selecteds.">".$data_cust['cust_name']."</option>";
			
					}
					?>
					<!--<option value="custome" style="font-style:oblique">New Customer</option> -->
				 </select>
				<?php
			}
			else
			{
				echo "mobile";
			}
		}
		else
		{
			echo "blank";
		}
	}
	else
	{
		echo "cust_id";
	}
}
//===============================================================ADD KIT===========================================================================================
if($action=='custome_kit_submit')
    {	
	
		$item_name=$_POST['item_name'];
        $data_record['item_price'] = $_POST['item_price'];
        $data_record['item_name'] = $_POST['item_name'];
        
        $insert_img="insert into items (`item_name`,`item_price`,`added_date`) values('".$data_record['item_name']."','".$data_record['item_price']."','".date('Y-m-d H:i:s')."')";
		$ptr_img=mysql_query($insert_img);
		$item_id=mysql_insert_id();
		
		$data_record_kit['kit_name'] =$item_name;
		$data_record_kit['added_date'] = date('Y-m-d H:i:s');
		$item_qty = $_POST['item_qty'];
		$record_id=$db->query_insert("kit", $data_record_kit);
		$kit_id=mysql_insert_id();
		
		
		$insert_for_unit = "insert into kit_items_map (`kit_id`,`item_id`,`item_qty`,`added_date`) values('".$kit_id."','".$item_id."','".$item_qty."','".date('Y-m-d H:i:s')."')";
		$ptr_insert_unit = mysql_query($insert_for_unit);
		 
	  //-----------------------------------------------
        ?>
        <select  multiple="multiple" id="user_id" name="kit_id[]" style="box-shadow: 3px 3px 3px #888888; width:250px;">                        
			<?php 
                
                $select_kit = "select * from kit order by kit_id asc";
                $ptr_kit = mysql_query($select_kit);
                $i=0;
                while($data_kit = mysql_fetch_array($ptr_kit))
                { 
                    $selecteds = '';
                   
                   if($record_id !='' || $record_id)
                   {
                        $selc = " select kit_id FROM `student_kit_map` where enroll_id =$record_id and kit_id= '".$data_kit['kit_id']."'";
                        $ptr_sle = mysql_query($selc);
                        $selecteds='';
                        if(mysql_num_rows($ptr_sle))
                        echo "<br/>".	$selecteds = 'selected="selected"';
                   }
                        
                        echo '<option value="'.$data_kit['kit_id'].'" '.$selecteds.' >'.$data_kit['kit_name'].' </option>';  
                        
                     
                $i++;
                }
                ?>
                    
        </select>
        <?php
    }
//=================================================================================================================================================================================
			if($action=='show_course')
			{
            $course_id=$_POST['course_id'];
			$service_taxes=$_POST['service_taxes'];
            $sel_class = "select * from courses where course_id='".$course_id."' ";
            $execute_class = mysql_query($sel_class);
            ?>	
              	<?php
			    
                $courses_data= mysql_fetch_array($execute_class);
                $course_price =trim($courses_data['course_price']); 
				$course_duration = trim($courses_data['course_duration']);
				$tax=($service_taxes*$course_price)/100;
				$course_with_tax=intval($course_price+$tax);
				echo $course_duration.'###'.$course_with_tax;
					
				  
			}
//============================================================SHOW CATEGORY===================================================================================
//=================================================================================================================================================================================
			if($action=='show_course_gst')
			{
            $course_id=$_POST['course_id'];
			//$service_taxes=$_POST['service_taxes'];
			$cgst_taxes=$_POST['cgst_taxes'];
			$sgst_taxes=$_POST['sgst_taxes'];
            $sel_class = "select * from courses where course_id='".$course_id."' ";
            $execute_class = mysql_query($sel_class);
            ?>	
			<?php
            $courses_data= mysql_fetch_array($execute_class);
            $course_price =trim($courses_data['course_price']); 
            $course_duration = trim($courses_data['course_duration']);
            $cgst_tax=($cgst_taxes*$course_price)/100;
            $sgst_tax=($sgst_taxes*$course_price)/100;
            $course_with_tax=intval($course_price+$cgst_tax+$sgst_tax);
            //$tax=($service_taxes*$course_price)/100;
            //$course_with_tax=intval($course_price+$tax);
            echo $course_duration.'###'.$course_with_tax;
					
				  
			}
//============================================================SHOW CATEGORY===================================================================================
			if($action=='show_category_name')
			{
				$category=$_POST['category'];
				$sel_class = "select * from voucher";
				$execute_class = mysql_query($sel_class);
				echo '<table width="100%"><tr><td width="52%" align="center">Select Deal Name</td><td width="45%"><select name="voucher">';
				while($data_voucher=mysql_fetch_array($execute_class))
				{
					$sel='';
					if($record_id)
					{
						if($row_record['voucher']==$data_voucher['deal_name'])
						{
							echo $sel='selected="selected"';
						}
					}
					echo '<option '.$sel.' value="'.$data_voucher['voucher_id'].'">'.$data_voucher['deal_name'].'</option>';
				}
				echo '</select></td></tr></table>';
			}
//============================================================================================================================================================
//============================================================SHOW PACKAGE===================================================================================
			if($action=='show_package')
			{
				$package_id=$_POST['package_id'];
				if($package_id !='')
				{
					$sel_class = "select * from package where package_id='".$package_id."'";
					$execute_class = mysql_query($sel_class);
					$data_package= mysql_fetch_array($execute_class);
					echo '<table width="100%"><tr><td width="" >Package Name :</td><td width="">'.$data_package['package_name'].'</td></tr><tr><td width="" >Start Date :</td><td width="">'.$data_package['start_date'].'</td></tr><tr><td width="">End Date :</td><td width="">'.$data_package['end_date'].'</td></tr><tr><td width="">Price :</td><td width="">'.$data_package['cost_to_center'].' <input type="hidden" name="package_price" id="package_price" value="'.$data_package['cost_to_center'].'"></td></tr></table>';
					echo"###".$data_package['cost_to_center'];
				}
			}
//============================================================================================================================================================
//============================================================SHOW CUSTOMER===================================================================================
			if($action=='show_customers_category')
			{
				$category=trim($_POST['category']);
				$customer_id=$_POST['customer_id'];
				$membership_id=$_POST['membership_id'];
				$package_id=$_POST['package_id'];
				$voucher_id=$_POST['voucher_id'];
				if($category !='')
				{
					if($category =='Membership')
					{
						$memb_id='';
						if($membership_id !='')
						{
							$memb_id="|| cust_id='".$customer_id."'";
						}
					
						echo'<table width="100%"><tr><td width="15%">Search by Mobile no.</td><td width="50%">';
						?>
						<select id="realtxt" name="realtxt" onChange="searchSel(this.value)">
                    <option value="">Select Mobile No.</option>
                    <?php  
					
                        $sql_cust = "select mobile1,cust_id,email from customer where 1 ".$_SESSION['where']." order by cust_id asc";
                        $ptr_cust = mysql_query($sql_cust);
                        while($data_cust = mysql_fetch_array($ptr_cust))
                        { 
								
                                $selecteds = '';
                                if($data_cust['cust_id']==$row_record['customer_id'])
                                $selecteds = 'selected="selected"';	
                            echo "<option value='".$data_cust['mobile1']."' ".$selecteds.">".$data_cust['mobile1']."</option>";
        
                        }
                        ?>
                    </select>
                    <?php
						echo'</td></tr><tr><td width="15%">Select customer.</td><td width="50%" id="sel_cust"><select name="cust_id" id="cust_id"><option value="" onchange="show_mobile_no(this.value)"> Select Customers</option>';
						echo $select_category = "select cust_id,cust_name,mobile1 from customer where 1  and (membership='' ||  membership ='no' ".$memb_id." ) and end_date > '".date('Y-m-d')."' ".$_SESSION['where']." order by cust_id desc";
						$ptr_category = mysql_query($select_category);
						while($data_category = mysql_fetch_array($ptr_category))
						{
							if($data_category['cust_id'] == $customer_id)
								echo '<option value='.$data_category['cust_id'].' selected="selected">'.$data_category['cust_name'].'</option>';
							else
							echo '<option value='.$data_category['cust_id'].'>'.$data_category['cust_name'].'</option>';
						}
						echo'</select></td><td width="10%"></td></tr><tr><td width="15%" valign="top">Select Membership<span class="orange_font">*</span></td><td width="50%">
						<select name="membership_id" id="membership_id"  onChange="getMembership(this.value)"><option value=""> Select Membership</option>';
                            $select_category = "select membership_id,membership_name from membership where 1 ".$_SESSION['where']." order by membership_id desc";
                            $ptr_category = mysql_query($select_category);
							while($data_category = mysql_fetch_array($ptr_category))
                            {
                                if($data_category['membership_id'] == $membership_id)
                                    echo '<option value='.$data_category['membership_id'].' selected="selected">'.$data_category['membership_name'].'</option>';
                                else
                                    echo '<option value='.$data_category['membership_id'].'>'.$data_category['membership_name'].'</option>';
                            }
                            
                         echo'</select></td></tr><tr><td width="20%" valign="top" colspan="3"><div id="membership_div_id"/><table style="width:100%"><tr><td width="6%">Membership Details</td>
						 <td width="23%">Discount(in %) : <span id="memb_disc"></span><input type="hidden" name="memb_discs" id="memb_discs" value=""/></td></tr><tr><td width="6%"></td><td width="23%">Days : <span id="dayss"></span><input type="hidden" name="days" id="days" value="" /><input type="hidden" name="categories" id="categories" value="" /></td></tr><tr><td width="6%"></td><td width="23%">Price : <span id="memb_price"></span><input type="hidden" name="memb_prices" id="memb_prices" value="" /></td></tr></table></div></td></tr></table>';
					}
					else if($category =='Package')
					{
						echo'<table width="100%"><tr><td>Search by Mobile no.</td><td>';
						?>
						<select id="realtxt" name="realtxt" onChange="searchSel(this.value)">
                        <option value="">Select Mobile No.</option>
                        <?php  
                        
                            $sql_cust = "select mobile1,cust_id,email from customer where 1 ".$_SESSION['where']." order by cust_id asc";
                            $ptr_cust = mysql_query($sql_cust);
                            while($data_cust = mysql_fetch_array($ptr_cust))
                            { 
                                    
                                    $selecteds = '';
                                    if($data_cust['cust_id']==$row_record['customer_id'])
                                    $selecteds = 'selected="selected"';	
                                echo "<option value='".$data_cust['mobile1']."' ".$selecteds.">".$data_cust['mobile1']."</option>";
            
                            }
                            ?>
                        </select>
                        <?php
						echo'</td></tr><tr><td width="15%" valign="top">Select Customer <span class="orange_font">*</span></td><td width="50%" id="sel_cust"><select name="cust_id" id="cust_id" onchange="show_mobile_no(this.value)"><option value="">Select Customers</option>';
						$select_category = "select cust_id,cust_name,mobile1 from customer where 1  ".$_SESSION['where']." order by cust_id desc";
						$ptr_category = mysql_query($select_category);
						while($data_category = mysql_fetch_array($ptr_category))
						{
							if($data_category['cust_id'] == $customer_id)
								echo '<option value='.$data_category['cust_id'].' selected="selected">'.$data_category['cust_name'].'</option>';
							else
								echo '<option value='.$data_category['cust_id'].'>'.$data_category['cust_name'].'</option>';
							//echo '<input type="hidden" name="mobile_no" id="mobile_no" value="'.$data_category['mobile1'].'" >';
						}
						echo'</select></td><td width="10%"></td></tr><tr><td width="15%" valign="top">Select Package<span class="orange_font">*</span></td><td width="50%">
						<select name="package_id" id="package_id" onChange="getPackage(this.value)"><option value="">Select Package</option>';
						echo $select_category = "select package_id,package_name,start_date,end_date,amount,redeam_amount from package where 1 ".$_SESSION['where']." order by package_id desc";
						$ptr_category = mysql_query($select_category);
						while($data_category = mysql_fetch_array($ptr_category))
						{
							if($data_category['package_id'] == $package_id)
								echo '<option value='.$data_category['package_id'].' selected="selected">'.$data_category['package_name'].'</option>';
							else
								echo '<option value='.$data_category['package_id'].'>'.$data_category['package_name'].'</option>';
						}
						echo'</select></td><td width="10%"></td></tr><tr><td width="20%" valign="top" colspan="3"><div id="package_div_id" /><table style="width:100%"><tr><td width="6%">Pacakage Details</td>
						<td width="23%">Pacakage Name : <span id="package_name"></span><input type="hidden" name="package_names" id="package_names" value="" /></td></tr><tr><td width="6%"></td><td width="23%">Start Date : <span id="package_start_date"></span><input type="hidden" name="package_start_dates" id="package_start_dates" value="" /><input type="hidden" name="days" id="days" value=""/></td></tr><tr><td width="6%"></td><td width="23%">End Date : <span id="package_end_date"></span><input type="hidden" name="package_end_dates" id="package_end_dates" value="" /></td></tr><tr><td width="6%"></td><td width="23%">Quantity : <span id="pkg_qty"></span><input type="hidden" name="pkg_qtys" id="pkg_qtys" value="" /></td></tr><tr><td width="6%"></td><td width="23%">Price : <span id="pkg_price"></span><input type="hidden" name="pkg_prices" id="pkg_prices" value="" /><input type="hidden" name="categories" id="categories" /></td></tr></table></div></td></table>';
					}
					else if($category =='Voucher')
					{
						echo'<table width="100%"><tr><td>Search by Mobile no.</td><td>';
						?>
						<select id="realtxt" name="realtxt" onChange="searchSel(this.value)">
                        <option value="">Select Mobile No.</option>
                        <?php  
                        
                            $sql_cust = "select mobile1,cust_id,email from customer where 1 ".$_SESSION['where']." order by cust_id asc";
                            $ptr_cust = mysql_query($sql_cust);
                            while($data_cust = mysql_fetch_array($ptr_cust))
                            { 
                                    
                                    $selecteds = '';
                                    if($data_cust['cust_id']==$row_record['customer_id'])
                                    $selecteds = 'selected="selected"';	
                                echo "<option value='".$data_cust['mobile1']."' ".$selecteds.">".$data_cust['mobile1']."</option>";
            
                            }
                            ?>
                        </select>
                        <?php
						echo'</td></tr><tr><td width="15%" valign="top">Select Customer <span class="orange_font">*</span></td><td width="50%" id="sel_cust"><select name="cust_id" id="cust_id" onchange="show_mobile_no(this.value)"><option value=""> Select Customers</option>';
						$select_category = "select cust_id,cust_name,mobile1 from customer where 1  ".$_SESSION['where']." order by cust_id desc";
						$ptr_category = mysql_query($select_category);
						while($data_category = mysql_fetch_array($ptr_category))
						{
							if($data_category['cust_id'] == $customer_id)
								echo '<option value='.$data_category['cust_id'].' selected="selected">'.$data_category['cust_name'].'</option>';
							else
								echo '<option value='.$data_category['cust_id'].'>'.$data_category['cust_name'].'</option>';
							//echo '<input type="hidden" name="mobile_no" id="mobile_no" value="'.$data_category['mobile1'].'" >';
						}
						echo'</select></td><td width="10%"></td></tr><tr><td width="15%" valign="top">Select Voucher<span class="orange_font">*</span></td><td width="50%">
						<select name="voucher_id" id="voucher_id" onChange="getVoucher(this.value)"><option value="">Select Voucher</option>';
						$select_category = "select voucher_id,deal_name from voucher where end_date > ".date("Y-m-d")." ".$_SESSION['where']." order by voucher_id desc";
						$ptr_category = mysql_query($select_category);
						while($data_category = mysql_fetch_array($ptr_category))
						{
							if($data_category['voucher_id'] == $voucher_id)
								echo '<option value='.$data_category['voucher_id'].' selected="selected">'.$data_category['deal_name'].'</option>';
							else
								echo '<option value='.$data_category['voucher_id'].'>'.$data_category['deal_name'].'</option>';
						}
						echo'</select></td><td width="10%"></td></tr><tr><td width="20%" valign="top" colspan="3"><div id="voucher_div_id" /><table style="width:100%"><tr><td width="6%">Voucher Details</td>
						<td width="23%">Voucher Name : <span id="voucher_name"></span><input type="hidden" name="vouchers_name" id="vouchers_name" value="" /></td></tr><tr><td width="6%"></td><td width="23%">Start Date : <span id="voucher_start_date"></span><input type="hidden" name="vouchers_start_date" id="vouchers_start_date" value="" /></td></tr><tr><td width="6%"></td><td width="23%">End Date : <span id="voucher_end_date"></span><input type="hidden" name="vouchers_end_date" id="vouchers_end_date" value="" /><input type="hidden" name="days" id="days" value=""/></td></tr><tr><td width="6%"></td><td width="23%">Seling Price : <span id="voucher_price"></span><input type="hidden" name="vouchers_price" id="vouchers_price" value="" /></td></tr><tr><td width="6%"></td><td width="23%">Redeemable Price :<span id="redeem_price"></span><input type="hidden" name="redeems_price" id="redeems_price" value="" /></td></tr><tr><td width="6%"></td><td width="23%">Total Quantity : <span id="total_quantity"></span><input type="hidden" name="total_quantities" id="total_quantities" value="" /><input type="hidden" name="categories" id="categories" /></td></tr></table></div></td></tr><tr><td colspan="3"></td></tr></table>';
					}
				}
			}
//============================================================================================================================================================
//============================================================SHOW Mobile no===================================================================================
			if($action=='show_mobile_no')
			{
				$cust_id=$_POST['cust_id'];
				if($cust_id !='')
				{
					$sel_class = "select mobile1 from customer where cust_id='".$cust_id."'";
					$execute_class = mysql_query($sel_class);
					$data_package= mysql_fetch_array($execute_class);
					?>
                    <select id="realtxt" name="realtxt" onChange="searchSel(this.value)">
                    <option value="">Select Mobile No.</option>
                    <?php  
                        $sql_cust = "select mobile1,cust_id from customer where 1 ".$_SESSION['where']." order by cust_id asc";
                        $ptr_cust = mysql_query($sql_cust);
                        while($data_cust = mysql_fetch_array($ptr_cust))
                        { 
                            $selecteds = '';
                            if($data_cust['mobile1']==$data_package['mobile1'])
                           		$selecteds = 'selected="selected"';	
								
                            echo "<option value='".$data_cust['mobile1']."' ".$selecteds.">".$data_cust['mobile1']."</option>";
                        }
                        ?>
                    </select>
                    <?php
				}
			}
//============================================================================================================================================================

//=============================================================EXPENSE CATEGORY==============================================================================
			if($action=='show_expense_cat')
			{
				$category_id=$_POST['category_id'];
				$expense_type_id=$_POST['expense_type_id'];
				$sel_expense = "select * from expense_type where category_id='".$category_id."'";
				$ptr_expense = mysql_query($sel_expense);
				echo '<table width="93%"><tr><td width="10%" align="center">Select Expense Type</td><td width="45%"><select name="expense_type" id="expense_type" style="width: 200px;">';
				while($data_expense=mysql_fetch_array($ptr_expense))
				{
					$sel='';
					if($expense_type_id)
					{
						if($expense_type_id ==$data_expense['expense_type_id'])
						{
							echo $sel='selected="selected"';
						}
					}
					echo '<option '.$sel.' value="'.$data_expense['expense_type_id'].'">'.$data_expense['expense_type'].'</option>';
				}
				echo '</select></td></tr></table>';
			}
//============================================================================================================================================================
			if($action=='show_course_enrolled')
			{
            	$course_id=$_POST['course_id'];
				$service_taxes=$_POST['service_taxes'];
            	$sel_class = "select * from courses where course_id='".$course_id."' ";
            	$execute_class = mysql_query($sel_class);
            	
                $courses_data= mysql_fetch_array($execute_class);
                $course_price =trim($courses_data['course_price']); 
				$course_duration = trim($courses_data['course_duration']);
				$tax=($service_taxes*$course_price)/100;
				$course_with_tax=intval($course_price+$tax);
				echo $course_duration.'###'.$course_with_tax;
			}
		
//==========================================================================================================================================================
//============================================================================================================================================================
			if($action=='show_course_enrolled_gst')
			{
            	$course_id=$_POST['course_id'];
				$cgst_taxes=$_POST['cgst_taxes'];
				$sgst_taxes=$_POST['sgst_taxes'];
            	$sel_class = "select * from courses where course_id='".$course_id."' ";
            	$execute_class = mysql_query($sel_class);
            	
                $courses_data= mysql_fetch_array($execute_class);
                $course_price =trim($courses_data['course_price']); 
				$course_duration = trim($courses_data['course_duration']);
				
				$cgst_tax=($cgst_taxes*$course_price)/100;
				$sgst_tax=($sgst_taxes*$course_price)/100;
				
				$course_with_tax=intval($course_price+$cgst_tax+$sgst_tax);
				echo $course_duration.'###'.$course_with_tax;
			}
		
//==========================================================================================================================================================
			if($action=='show_account')
			{
				$bank_id=$_POST['bank_id'];
				$sel_bank = "select account_no from bank where bank_id='".$bank_id."' ";
				$execute_bank = mysql_query($sel_bank);
				$account_no= mysql_fetch_array($execute_bank);
				echo $account_no['account_no'];
			}
//=========================================================================================================================================================
//==================================================CHECk VOCHER ID========================================================================================================
			if($action=='check_voucher_id')
			{
				$cust_id=$_POST['cust_id'];
				$record_id=$_POST['record_id'];
				$sel_voucher = "select DISTINCT(s.voucher_id) from sales_package_voucher_memb s, voucher v where s.cust_id='".$cust_id."' and s.category='Voucher' and s.voucher_id!='0' and s.status='active' and s.quantity > 0 and DATE(s.end_date) > '".date('Y-m-d')."' and s.voucher_id=v.voucher_id order by v.category desc ";
				$execute_voucher = mysql_query($sel_voucher);
				if(mysql_num_rows($execute_voucher))
				{
					echo "hi";
					$i=1;
					while($data_voucher= mysql_fetch_array($execute_voucher))
					{
						if($i==1)
						{
							$vouchers.="and voucher_id='".$data_voucher['voucher_id']."'";
						}
						else
						{
							$vouchers.="or voucher_id='".$data_voucher['voucher_id']."'";
						}
						$i++;
					}
				}
				else
				{
					$vouchers="and voucher_id=''";
				}
				echo "###";
				$sel_voucher= "select * from voucher where 1 ".$vouchers."";
				$ptr_voucher= mysql_query($sel_voucher);
				//echo '<table width="100%"><tr><td width="23%">Select Deal Name</td><td ><select name="voucher_deal_id" id="voucher_deal_id" onChange="show_voucher_details(this.value)">';
				while($data_voucher=mysql_fetch_array($ptr_voucher))
				{
					$sel_voucher_deal_id="select voucher_deal_id from customer where cust_id='".$cust_id."' ";
					$ptr_voucher_deal_id=mysql_query($sel_voucher_deal_id);
					$data_voucher_deal_id=mysql_fetch_array($ptr_voucher_deal_id);
					$sel='';
					if($data_voucher['voucher_id']==$data_voucher_deal_id['voucher_deal_id'])
					{
						$sel='selected="selected"';
					}
					echo '<option '.$sel.' value="'.$data_voucher['voucher_id'].'">'.$data_voucher['deal_name'].'</option>';
				}
				//echo '</select></td></tr></table>';
			}
//=========================================================================================================================================================
//==================================================CHECk Package ID========================================================================================================
			if($action=='check_package_id')
			{
				$cust_id=$_POST['cust_id'];
				$record_id=$_POST['record_id'];
				$sel_package = "select DISTINCT(package_id) from sales_package_voucher_memb where cust_id='".$cust_id."' and category='Package' and package_id!='0' and status='active' and DATE(end_date) > '".date('Y-m-d')."' ";
				$execute_package = mysql_query($sel_package);
				if(mysql_num_rows($execute_package))
				{
					echo "hi";
					$i=1;
					while($data_package= mysql_fetch_array($execute_package))
					{
						if($i==1)
						{
							$package.="and package_id='".$data_package['package_id']."'";
						}
						else
						{
							$package.="or package_id='".$data_package['package_id']."'";
						}
						$i++;
					}
				}
				echo "###";
				$sel_pacakages= "select * from package where 1 ".$package."";
				$ptr_pacakages= mysql_query($sel_pacakages);
				echo '<table width="99%"><tr><td width="24%">Select Package Name</td><td ><select name="packagess_deal_id" id="packagess_deal_id" onChange="show_package_details(this.value)">';
				while($data_packages=mysql_fetch_array($ptr_pacakages))
				{
					/*$sel_package_id="select package_id from customer where cust_id='".$cust_id."' ";
					$ptr_package_id=mysql_query($sel_package_id);
					$data_package_id=mysql_fetch_array($ptr_package_id);
					$sel='';
					if($data_packages['package_id']==$data_package_id['package_id'])
					{
						$sel='selected="selected"';
					}*/
					echo '<option  value="'.$data_packages['package_id'].'">'.$data_packages['package_name'].'</option>';
				}
				echo '</select></td></tr></table>';
			}
//==========================================================================END Package===============================================================================
//==================================================CHECk LOYALTY POINTS==============================================================================================
			if($action=='check_loyalty_points')
			{
				$cust_id=$_POST['cust_id'];
				$record_id=trim($_POST['record_id']);
				$branch_name=$_POST['branch_name'];
				echo 'hi ###';
				if($record_id !='')
				{
					$sele_max='select redeme_points,redemptoin_value from customer_service where customer_service_id ="'.$record_id.'"';
					$ptr_max=mysql_query($sele_max);
					if(mysql_num_rows($ptr_max))
					{
						$data_max=mysql_fetch_array($ptr_max);
						$redeme_points=$data_max['redeme_points'];
						$redemptoin_value=intval($data_max['redemptoin_value']);
						
						echo '<table width="99%" style="color:green;font-style:800;" ><tr><td width="25%">Reward Points</td><td><input type="text" readonly class="input_text" onKeyup="show_redeme_points(this.value)" name="redeme_points" id="redeme_points" value="'.$redeme_points.'"></td></tr><tr><td width="25%">Redemption value</td><td><input type="text" readonly class="input_text" name="redemptoin_value" id="redemptoin_value" value="'.$redemptoin_value.'"></td></tr></table>';
						echo '### <span style="color:green;font-size:12px;font-weight:800">You have successfully Redeme '.$redeme_points.' Points </span>';
					}
				}
				else
				{
					$sel_rewards = "select rewards_point from customer where cust_id='".$cust_id."' and rewards_point >0 ";
					$ptr_rewards = mysql_query($sel_rewards);
					if(mysql_num_rows($ptr_rewards))
					{
						$data_rewards= mysql_fetch_array($ptr_rewards);
						$rewards_point=$data_rewards['rewards_point'];
						$cm_id1='';
						if($_SESSION['type']=='S')
						{
							$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
							$ptr_branch=mysql_query($sel_branch);
							$data_branch=mysql_fetch_array($ptr_branch);
							$cm_id=$data_branch['cm_id'];
						}	
						else
						{
							$cm_id=$_SESSION['cm_id'];
						}
						
						$sele_max='select reward_value from reward_value_config where 1 and '.$data_rewards['rewards_point'].'>=reward_point_redeme and cm_id='.$cm_id.' ';
						$ptr_max=mysql_query($sele_max);
						if(mysql_num_rows($ptr_max))
						{
							$data_max=mysql_fetch_array($ptr_max);
							$reward_value=$data_max['reward_value'];
							$reward_amount=intval($rewards_point*$reward_value);
							
							echo '<table width="99%" style="color:green;font-style:800;" ><tr><td width="25%">Reward Points</td><td><input type="text" class="input_text" name="redeme_points" onKeyup="show_redeme_points(this.value)" id="redeme_points" value="'.$rewards_point.'"></td></tr><tr><td width="25%">Redemption value</td><td><input type="text" class="input_text" name="redemptoin_value" id="redemptoin_value" value="'.$reward_amount.'"></td></tr></table>';
							echo '### <span style="color:green;font-size:12px;font-weight:800">You have successfully Redeme '.$rewards_point.' Points</span>';
						}
						else
							echo ' ### <span style="color:red;font-size:12px;font-weight:800">Rewards point is not sufficient to redeme or you enter more. Please earn More Rewards Point</span>';
					}
					else
						echo ' ### <span style="color:red;font-size:12px;font-weight:800">You have No Rewards Point</span>';
				}
			}
			if($action=='redeme_loyalty_points')
			{
				$cust_id=$_POST['cust_id'];
				$redeme_point=trim($_POST['redeme_point']);
				$branch_name=$_POST['branch_name'];
				if($cust_id !='' && $redeme_point >0)
				{
					echo "hi ###";
					$cm_id1='';
					if($_SESSION['type']=='S')
					{
						$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
						$ptr_branch=mysql_query($sel_branch);
						$data_branch=mysql_fetch_array($ptr_branch);
						$cm_id=$data_branch['cm_id'];
					}	
					else
					{
						$cm_id=$_SESSION['cm_id'];
					}
					$sel_rewards = "select rewards_point from customer where cust_id='".$cust_id."' and rewards_point >= '".$redeme_point."' ";
					$ptr_rewards = mysql_query($sel_rewards);
					if(mysql_num_rows($ptr_rewards))
					{
						$sele_max='select reward_value from reward_value_config where 1 and '.$redeme_point.'>=reward_point_redeme and cm_id='.$cm_id.' ';
						$ptr_max=mysql_query($sele_max);
						if(mysql_num_rows($ptr_max))
						{
							$data_max=mysql_fetch_array($ptr_max);
							$reward_value=$data_max['reward_value'];
							echo $reward_amount=intval($redeme_point*$reward_value);
							echo '### <span style="color:green;font-size:12px;font-weight:800">You have successfully Redeme '.$redeme_point.' Points</span>';
						}
						else
							echo ' ### <span style="color:red;font-size:12px;font-weight:800">Rewards points are not sufficient to redeme.</span>';
					}
					else
						echo ' ### <span style="color:red;font-size:12px;font-weight:800">Rewards point is not sufficient to redeme OR you enter more than you have.</span>';
				}
			}
//===============================================================END Loyalty Points==========================================================================================
//==========================================================================================================================================================
			if($action=='show_product_qty')
			{
				$product_id=$_POST['product_id'];
				$sel_quantity = "select quantity,price from product where product_id='".$product_id."' ";
				$execute_quantity = mysql_query($sel_quantity);
				$data_quantity= mysql_fetch_array($execute_quantity);
				echo trim($data_quantity['quantity']."-".$data_quantity['price']);
			}
//=========================================================================================================================================================
//==========================================================================================================================================================
			if($action=='show_product_estimation')
			{
				$product_id=$_POST['product_id'];
				"\n".$sel_quantity = "select quantity,price from product where product_id='".$product_id."' ";
				$execute_quantity = mysql_query($sel_quantity);
				$data_quantity= mysql_fetch_array($execute_quantity);
				$product_price=$data_quantity['price'];
				$product_qty=$data_quantity['quantity'];
				$cgst_per=0;
				$sgst_per=0;
				"\n".$select_product="select cgst_tax_in_per,cgst_tax,sgst_tax_in_per,sgst_tax,igst_tax_in_per,igst_tax,sin_product_total,sin_product_price from inventory_product_map where product_id='".$product_id."' order by map_id desc limit 0,1";
				$ptr_product=mysql_query($select_product);
				if(mysql_num_rows($ptr_product))
				{
					$data_product=mysql_fetch_array($ptr_product);
					$product_price=trim($data_product['sin_product_price']);
					$cgst_per=$data_product['cgst_tax_in_per'];
					$sgst_per=$data_product['sgst_tax_in_per'];
					"\n".$igst_per=$data_product['igst_tax_in_per'];
					
					if($cgst_per >0 && $sgst_per >0)
					{
						$totalgst=intval($cgst_per+$sgst_per);
						$new_total_tax=floatval(($totalgst+100)/100);
						//"\n".$product_price = floatval($product_price / $new_total_tax);
					}
					else if($igst_per >0)
					{
						$gst=intval($igst_per/2);
						$cgst_per=$gst;
						$sgst_per=$gst;
						$totalgst=intval($cgst_per+$sgst_per);
						$new_total_tax=floatval(($totalgst+100)/100);
						//$product_price = floatval($product_price / $new_total_tax);
					}
				}
				echo "\n".trim($product_qty."-".$product_price."-".$cgst_per."-".$sgst_per);
			}
//=========================================================================================================================================================
			if($action=='add_enquiry')
			{
				$firstname=$_POST['firstname'];
				$middlename=$_POST['middlename'];
				$lastname=$_POST['lastname'];
				$user=$_POST['user'];
				$pass=$_POST['pass1'];
				$cm_id= $_POST['cm_id'];
				$birth_date=$_POST['dob'];
				$gender=$_POST['gender'];
				$maritalstatus=$_POST['maritalstatus'];
				$address=$_POST['address'];
				$mobile1=$_POST['mobile1'];
				$mobile2=$_POST['mobile2'];
				$landline_no=$_POST['landline_no'];
				$email_id=$_POST['email_id'];
				$education=$_POST['education'];
				$course_interested=trim($_POST['course_id']);
				$enquiry_date=date('y-m-d');
				
				$total_fees=$_POST['total_fees'];
				$batch=$_POST['batch'];
				
				$course= $_POST['course_id'];
				//$course_fees= $_POST['total_fees'];
				$discount_coupon_code = $_POST['discount_coupon_code'];
				$discount_coupon_price = $_POST['discount_coupon_price'];
				$discount= $_POST['concession'];
				$discount_type= $_POST['discount_type'];
				$paid= $_POST['down_payment'];
				$paid_type=$_POST['paid_type'];
				$bank_name= $_POST['bank_name'];
				$chaque_no= $_POST['chaque_no']; 
				$chaque_date= $_POST['chaque_date'];
				$payment_type= $_POST['payment_type'];
				$installment_on= $_POST['installment_on'];
				$net_fees= $_POST['net_fees'];
				$fees= $_POST['fees'];
				$service_tax= $_POST['service_tax'];
				$down_payment= $_POST['down_payment'];
				$first_installment= $_POST['numDep'];
				$final_amt= $_POST['final_amt'];
				$enquiry_src=$_POST['enquiry_src'];
				
				
				
				$inquiry_for=$_POST['inquiry_for'];
				$address=$_POST['address'];
		   
				if($birth_date !='//')
				{
				
					$sep_date = explode('/',$birth_date);
					$birth_date = $sep_date[2].'-'.$sep_date[0].'-'.$sep_date[1];
				}
				
				if($firstname !='' && $lastname !='' && $email_id !='' && $cm_id !='' &&  $course !='')
					{
					
					$data_record['firstname'] = $firstname;
					$data_record['middlename'] = $middlename;
					$data_record['lastname'] = $lastname;
					$data_record['birth_date'] = $birth_date; 
					$dta_record['gender'] = $gender;
					$data_record['maritalstatus'] = $maritalstatus;
					$data_record['adress'] = $address;
					$data_record['mobile1'] = $mobile1;
					$data_record['mobile2'] = $mobile2;
					$data_record['landline_no'] = $landline_no;
					$data_record['email_id'] = $email_id;
					$data_record['education'] = $education;
					$data_record['course_interested'] = $course_interested;	
					$data_record['total_fees'] = $fees;
					$data_record['enquiry_date'] = $enquiry_date;
					$data_record['no_of_installment']=$first_installment;
					$data_record['batch'] = $batch;
					$data_record['enquiry_source'] = $enquiry_src;
					$data_record['enquiry_taken'] = $enquiry_taken;
					$data_record['discount_coupon_code']=$discount_coupon_code;
					$data_record['discount_coupon_price']=$discount_coupon_price;
					$data_record['inquiry_for'] = $inquiry_for;
					$data_record['not_status']='signs_on';
					$data_record['added_date'] =date('Y-m-d H:i:s');
					if($course !='')
					{
						 $select_existing_course_id = " select course_id,course_name from courses where course_id='$course' ";
						$ptr_course_id = mysql_query($select_existing_course_id);
						
						if(mysql_num_rows($ptr_course_id))
						{
						$data_course_id = mysql_fetch_array($ptr_course_id);
						 $course_id = $data_course_id['course_id'];
						 $course_interested = $data_course_id['course_name'];
						}
						
					}
					
					$sel_branch = "select branch_name from site_setting where cm_id='".$cm_id."' ";
					$execute_cm_id = mysql_query($sel_branch);
					$data_cm_id=mysql_fetch_array($execute_cm_id);
  
                                       
	echo $insert= "INSERT INTO inquiry (`firstname`,`middlename`,`lastname`,`birth_date`,`gender`,`maritalstatus`,`address`,`mobile1`,`mobile2`,`landline_no`,
		`email_id`,`education`,`course_interested`,`course_id`,`total_fees`,`enquiry_date`,`batch`,`enquiry_source`,`enquiry_taken`,`inquiry_for`,`added_date`,`cm_id`,`enquiry_from`) 
VALUES ('$firstname','$middlename','$lastname','$birth_date','$gender','$maritalstatus','$address','$mobile1','$mobile2','$landline_no','$email_id','$education','$course_interested', '$course','$fees','".date('Y-m-d H:i:s')."','$batch',
'$enquiry_src','','$inquiry_for','".date('Y-m-d H:i:s')."','".$cm_id."','online')";
$ptr_query=mysql_query($insert);
 
echo $insert_regi = "INSERT INTO `stud_regi` (`admin_id`,`cm_id`, `name`,`username`,`pass`,  `dob`, `address`, `contact`, `mail`, `qualification`,  `added_date`, `status` ,`not_status`)
 VALUES ('$enquiry_taken','".$cm_id."', '".$firstname." ".$lastname."','$user','$pass', '$birth_date', '".$address."', '$mobile1', '".$email_id."', '$education', '".date('Y-m-d H:i:s')."', 'Enrolled','signs_on')";
 $ptr_reg = mysql_query($insert_regi);
$name=$firstname.' '.$middlename.' '.$lastname;


$chk_exist_student_logn = " select stud_login_id from stud_login where   username='$user' and pass='$pass' ";
								$ptr_chk_exists = mysql_query($chk_exist_student_logn);
								if(mysql_num_rows($ptr_chk_exists))
								{
									$data_login = mysql_fetch_array($ptr_chk_exists);
									$stud_login_id = $data_login['stud_login_id'];
								}
								else
								{
										$data_record_login['username'] =$user;
										$data_record_login['pass'] =$pass;
										//$data_record_login['enroll_id'] =$student_id;
										$stud_login_id=$db->query_insert("stud_login", $data_record_login); 
									
								}	

echo $insert_enroll= "INSERT INTO enrollment (`name`,`username`,`pass`,`student_id`,`dob`,`address`,`contact`,`mail`,`qualification`,`course_id`, `course_fees`,`discount_type`, `discount`,`discount_coupon_code`,`discount_coupon_price`,`paid`,`paid_type`,`net_fees`,`service_tax`,`total_fees`,`down_payment`,`no_of_installment`,`installment_on`, `balance_amt`,`added_date`, `cm_id`,`stud_login_id`,`inquiry_date`) 

VALUES  ('$name','$user','$pass','$ptr_query','$birth_date','$address','$mobile1','$email_id', '$education','$course', '$total_fees','$discount_type','$discount', '$discount_coupon_code','$discount_coupon_price','$paid','$paid_type','$net_fees', '$service_tax','$fees','$down_payment','$first_installment','$installment_on','$final_amt','".date('Y-m-d H:i:s')."','".$cm_id."','$stud_login_id','".date('Y-m-d')."')";
 $year= date('Y');
$enrollment_id1 = mysql_query($insert_enroll);			
$student_id= mysql_insert_id();						
 $month=date('M');
		
 $array = array('ISAS', $year,$month,$student_id);
 $comma_separated = implode("/", $array);
	   
$update_enroll_id=" update enrollment set installment_display_id='".$comma_separated."' where enroll_id='".$student_id."' ";
$updt_id=mysql_query($update_enroll_id);

$data_record_invoice['course_id']=$course;
$data_record_invoice['bank_name']=$bank_name;
$data_record_invoice['cheque_detail']=$chaque_no;
$data_record_invoice['chaque_date']=$chaque_date;	
$data_record_invoice['online_transc_details']='';
$data_record_invoice['amount']=$down_payment;
$data_record_invoice['balance_amt']=$final_amt;
$data_record_invoice['paid_type']=$payment_type;
$data_record_invoice['added_date']=date('y-m-d h:i:s');
$data_record_invoice['enroll_id']=$student_id;
if($payment_type=="online")
$data_record_invoice['status']='pending';
else
$data_record_invoice['status']='paid';	
$student_id_in=$db->query_insert("invoice", $data_record_invoice); 

								if($first_installment !=0)
							   	{
									
								 
									// echo "iam in first loop";
									$installment_date='';
									$instl = $_POST['installments'];
									$sep_instl = explode(',',$instl);
									$sep_date_installment = explode(',',$_POST['installment_date']);
									for($i=0;$i<count($sep_instl);$i++)
								 	{
									if($sep_instl[$i] !='')
									{
										//echo "iam in second loop";
										$sep_date =  explode('/',$sep_date_installment[$i]);
										$installment_date = $sep_date[2].'-'.$sep_date[0].'-'.$sep_date[1];
												
												
									echo "<br />". $insert_query = "  insert into installment(enroll_id, course_id, installment_amount, installment_date, status,installment_display_id, invoice_id,cm_id) values('$student_id ','".$course."','".$sep_instl[$i]."','$installment_date','not paid','".$comma_separated."',$student_id_in,'".$cm_id."') ";
									   
									   $insert_ptr = mysql_query($insert_query);
									   
									   ///============ Installment Histroy insert
									    $insert_query2 = "  insert into installment_history(enroll_id, course_id, installment_amount, installment_date, status,installment_display_id, invoice_id,cm_id) values('$student_id ','".$course."','".$sep_instl[$i]."','$installment_date','not paid','".$comma_separated."',$student_id_in,'".$cm_id."') ";
									   
									   $insert_ptr2 = mysql_query($insert_query2);
									   
									  /* $sel= "select * from invoice";
									   $ptr_sql=mysql_query($sel);
									   $sql_fetch=mysql_fetch_array($ptr_sql);	
									    $where_record=$sql_fetch['enroll_id']=$student_id;
									    //$data_record_invoice_up['installment_id']=$insert_ptr;
									    $inst_id=$db->query_update("invoice", $data_record_invoice_up,$where_record); 
										*/
									}
									 
								 } 
								
								}


                                                /*------------send a mail to admin about this---------------------*/
                                                $subject = "Online Enquiry from ".$firstname.' '.$lastname." on ".$GLOBALS['domainName']." for course $course_interested";
                                                $message= '
                                                <table cellpadding="3" align="left" cellspacing="3" width="75%">
												 <tr>
                                                    <td width="35%"><strong>Firstname</strong></td>
                                                    <td>:</td>
                                                    <td width="65%">'.$firstname.'</td>
                                                </tr>';
												if($middlename)
                                                $message.= '
                                                
                                                <tr>
                                                    <td width="35%"><strong>Middlename</strong></td>
                                                    <td>:</td>
                                                    <td width="65%">'.$middlename.'</td>
                                                </tr>';
                                               if($lastname)
												 
                                                $message.= '
                                                
                                                <tr>
                                                    <td width="35%"><strong>Lastname</strong></td>
                                                    <td>:</td>
                                                    <td width="65%">'.$lastname.'</td>
                                                </tr>';
												if($birth_date)
												$message.= '
												<tr>
												    <td><strong>Birth Date</strong></td>
													<td>:</td>
													<td>'.$birth_date.'<td>
												</tr>';
												if($gender)
												$message.= '
												<tr>
												    <td><strong>Gender</strong></td>
													<td>:</td>
													<td>'.$gender.'<td>
												</tr>';
												if($maritalstatus)
												$message.= '
												<tr>
												    <td><strong>Marital Status</strong></td>
													<td>:</td>
													<td>'.$maritalstatus.'<td>
												</tr>';
												if($address)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Address</strong></td>
                                                    <td>:</td>
                                                    <td>'.$address.'</td>
                                                </tr>';
												if($mobile1)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Mobile1</strong></td>
                                                    <td>:</td>
                                                    <td>'.$mobile1.'</td>
                                                </tr>';
												if($mobile2)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Mobile2</strong></td>
                                                    <td>:</td>
                                                    <td>'.$mobile2.'</td>
                                                </tr>';
												
                                                /*if($company)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Company</strong></td>
                                                    <td>:</td>
                                                    <td>'.$company.'</td>
                                                </tr>';*/
                                                
                                                if($landline_no)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Landline no</strong></td>
                                                    <td>:</td>
                                                    <td>'.$landline_no.'</td>
                                                </tr>';
												if($email_id)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Email</strong></td>
                                                    <td>:</td>
                                                    <td>'.$email_id.'</td>
                                                </tr>';
												 if($education)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Education</strong></td>
                                                    <td>:</td>
                                                    <td>'.$education.'</td>
                                                </tr>';
												 if($course_interested)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Course Interested</strong></td>
                                                    <td>:</td>
                                                    <td>'.$course_interested.'</td>
                                                </tr>';
												 if($customised_course)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Customised Course</strong></td>
                                                    <td>:</td>
                                                    <td>'.$customised_course.'</td>
                                                </tr>';
												 if($enquiry_date)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Enquiry Date</strong></td>
                                                    <td>:</td>
                                                    <td>'.$enquiry_date.'</td>
                                                </tr>';
												if($duration_studies)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Duration For Studies</strong></td>
                                                    <td>:</td>
                                                    <td>'.$duration_studies.'</td>
                                                </tr>';
												if($fees)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Total Fees</strong></td>
                                                    <td>:</td>
                                                    <td>'.$fees.'</td>
                                                </tr>';
												if($batch)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Prefer Batch</strong></td>
                                                    <td>:</td>
                                                    <td>'.$batch.'</td>
                                                </tr>';
												if($enquiry_source)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Enquiry Source</strong></td>
                                                    <td>:</td>
                                                    <td>'.$enquiry_source.'</td>
                                                </tr>';
												
												
												if($contact_for)
                                                $message.= '
                                                <tr>
                                                    <td><strong>contact For</strong></td>
                                         
										            <td>:</td>
                                                    <td>'.$contact_for.'</td>
                                                </tr>';
                                                $message.='<tr><td>Enquiry form filled from  </td><td>:</td><td>Online Form<td></tr>
                                                </table>';
												
													$sendMessage=$GLOBALS['box_message_top'];
													$sendMessage.=$message;
													$sendMessage.=$GLOBALS['box_message_bottom'];
													$from_id='support<support@'.$GLOBALS['domainName'].'>';
													$headers= 'MIME-Version: 1.0' . "\n";
													$headers.='Content-type: text/html; charset=utf-8' . "\n";
													$headers.='From:'.$from_id;
													//echo $to.$sendMessage;
													
													if($_SERVER['HTTP_HOST']!="localhost" && $_SERVER['HTTP_HOST']!="localhost:81")//|| $_SERVER['HTTP_HOST']=="hindavi-1"
   													 {
														 $select_email_id = " select  email as email_id from site_setting where cm_id='$cm_id' or admin_id='$cm_id' and (type='A' or type='C') and email !='' ";
													$ptr_emails = mysql_query($select_email_id);
													while($data_emails = mysql_fetch_array($ptr_emails))
													{
														mail($data_emails['email'], $subject, $sendMessage, $headers);
													}
													if(mail('sudhir.pawar@waakan.com', $subject, $sendMessage, $headers))
													{
														//echo 'sent';	
													}
													$subject_thanks =" Congratulatation! your registration inquiry is submitted successfully. ";
													$thanks_msg = " Thannk you $firstname $lastname for choosing ".$GLOBALS['domainName']." <br />Your Registration Enquiry for Course : $course_interested is submitted successfully. <br /><br /> ";
													
													$thanks_msg =$GLOBALS['box_message_top'].$thanks_msg.$GLOBALS['box_message_bottom'];
													mail($email_id,$subject_thanks,$thanks_msg,$headers);
													}
   		                                           
												//===============================Online Payment==============================================================   
												   
												   
													if($payment_type=="online")
													{
														?>
														<div style="display:none">
														<form method="post" name="customerData" action="http://www.isasbeautyschool.com/faculty_login/ccavRequestHandler1_online.php">
														<table width="40%" height="100" border='1' align="center" >
														
														</table>
															<table width="40%" height="100" border='1' align="center">
																<tr>
																	<td>Parameter Name:</td><td>Parameter Value:</td>
																</tr>
																<tr>
																	<td colspan="2"> Compulsory information*</td>
																</tr>
																<tr>
																	<td>TID	:</td><td><input type="hidden" name="tid" id="tid" value=" <? echo rand(0, 9999999999); ?>" readonly/></td>
																</tr>
																<tr>
																	<td>Merchant Id	:</td><td><input type="hidden" name="merchant_id" value="73035"/></td>
																</tr>
																<tr>
																	<td>Order Id	:</td><td><input type="hidden" name="order_id" value="<? echo $student_id_in; ?>"/></td>
																</tr>
																<tr>
																	<td>Amount	:</td><td><input type="hidden" name="amount" value="<? echo $down_payment; ?>"/></td>
																</tr>
																<tr>
																	<td>Currency	:</td><td><input type="hidden" name="currency" value="INR"/></td>
																</tr>
																<tr>
																	<td>Redirect URL	:</td><td><input type="hidden" name="redirect_url" value="http://www.isasbeautyschool.com/faculty_login/ccavResponseHandler_online.php"/></td>
																</tr><!--//http://wwww.isasbeautyschool.com/faculty_login/-->
																<tr>
																	<td>Cancel URL	:</td><td><input type="hidden" name="cancel_url" value="http://www.isasbeautyschool.com/faculty_login/ccavResponseHandler_online.php"/></td>
																</tr>
																<tr>
																	<td>Language	:</td><td><input type="hidden" name="language" value="EN"/></td>
																</tr>
																<tr>
																	<td colspan="2">Billing information(optional):</td>
																</tr>
																<tr>
																	<td>Billing Name	:</td><td><input type="hidden" name="billing_name" value="<? echo $name; ?>"/></td>
																</tr>
																<tr>
																	<td>Billing Address	:</td><td><input type="hidden" name="billing_address" value="<? echo $address; ?>"/></td>
																</tr>
																<tr>
																	<td>Billing City	:</td><td><input type="hidden" name="billing_city" value="<? echo $data_cm_id['branch_name']; ?>"/></td>
																</tr>
																<tr>
																	<td>Billing State	:</td><td><input type="hidden" name="billing_state" value="MH"/></td>
																</tr>
																<tr>
																	<td>Billing Zip	:</td><td><input type="hidden" name="billing_zip" value="412207"/></td>
																</tr>
																<tr>
																	<td>Billing Country	:</td><td><input type="hidden" name="billing_country" value="India"/></td>
																</tr>
																<tr>
																	<td>Billing Tel	:</td><td><input type="hidden" name="billing_tel" value="<? echo $mobile1; ?>"/></td>
																</tr>
																<tr>
																	<td>Billing Email	:</td><td><input type="hidden" name="billing_email" value="<? echo $email_id; ?>"/></td>
																</tr>
																<tr>
																	<td colspan="2">Shipping information(optional)</td>
																</tr>
																<tr>
																	<td>Shipping Name	:</td><td><input type="hidden" name="delivery_name" value="<? echo $name; ?>"/></td>
																</tr>
																<tr>
																	<td>Shipping Address	:</td><td><input type="hidden" name="delivery_address" value="<? echo $address; ?>"/></td>
																</tr>
																<tr>
																	<td>shipping City	:</td><td><input type="hidden" name="delivery_city" value="<? echo $data_cm_id['branch_name']; ?>"/></td>
																</tr>
																<tr>
																	<td>shipping State	:</td><td><input type="hidden" name="delivery_state" value="Andhra"/></td>
																</tr>
																<tr>
																	<td>shipping Zip	:</td><td><input type="hidden" name="delivery_zip" value="425001"/></td>
																</tr>
																<tr>
																	<td>shipping Country	:</td><td><input type="hidden" name="delivery_country" value="India"/></td>
																</tr>
																<tr>
																	<td>Shipping Tel	:</td><td><input type="hidden" name="delivery_tel" value="<? echo $mobile1; ?>"/></td>
																</tr>
																
																<tr>
																	<td>Vault Info.	:</td><td><input type="hidden" name="customer_identifier" value=""/></td>
																</tr>
																<tr>
																	<td>Integration Type:</td><td><input type="hidden" name="integration_type" value="iframe_normal"/></td>
																</tr>
																<tr>
																	<td></td>
																	<script>
																	document.customerData.submit();
																	</script>>
																	
																</tr>
															</table>
														  </form>
														  </div>
														  <?
													}
												   else
												   {
													   echo 'Inquiry send successfully. ';
													}
												// ================================End===================================================================== 
												   
                                                /*-------------------------------------------------------------------------*/
												
												}
												else
												echo " * Fields are compulsary ";
                                                
                                            }
											
		if($action=='sign_in')
			{
				$username=$_POST['username'];
                $pass=$_POST['pass'];
				$chk_exist = "select stud_login_id from stud_login where username='".$username."' and pass= '".$pass."'";
				$ptr_chk_exit = mysql_query($chk_exist);
				if(mysql_num_rows($ptr_chk_exit))
				{
					$data_usaer = mysql_fetch_array($ptr_chk_exit);
					echo $username.'###';
					$_SESSION['stud_login_id']=$data_usaer['stud_login_id'];
					$_SESSION['username']=$username;
					$_SESSION['pass']=$pass;
					
					$sel_all="select * from enrollment where stud_login_id=".$data_usaer['stud_login_id']."";
					$ptr_query_all=mysql_query($sel_all);
					$data_all=mysql_fetch_array($ptr_query_all);
					
					 $_SESSION['enroll_id1']=$data_all['enroll_id'];
					 $_SESSION['name1']=$data_all['name'];
					 $_SESSION['mail1']=$data_all['mail'];
					 $_SESSION['contact1']=$data_all['contact'];
					 $_SESSION['username1']=$data_all['username'];
					 $_SESSION['pass1']=$data_all['pass'];
					 $_SESSION['address1']=$data_all['address'];
					 $_SESSION['inquiry_date']=$data_all['inquiry_date'];
					 $_SESSION['installment_display_id']=$data_all['installment_display_id'];
					 $_SESSION['total_fees']=$data_all['total_fees'];
					 $_SESSION['down_payment']=$data_all['down_payment'];
					 $_SESSION['installment_on']=$data_all['installment_on'];
					 $_SESSION['no_of_installment']=$data_all['no_of_installment'];
					 $_SESSION['added_date']=$data_all['added_date'];
					 $_SESSION['course_id']=$data_all['course_id'];
					 $_SESSION['course_price']=$data_all['course_fees'];
					 
					 $sel_course_name="select course_name,course_price from courses where course_id='".$data_all['course_id']."'";
					 $ptr_course_name=mysql_query($sel_course_name);
					 $data_course_name=mysql_fetch_array($ptr_course_name);
					 
					 $_SESSION['course_name']=$data_course_name['course_name'];
					 
					 //============================== MY ACCOUNT==========================
					 ?>

	
        <div class="close"></div><!-- close button of the sign in form -->
        <ul id="form-section">
      		<table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>
                <table border="0" cellspacing="0" cellpadding="0">
                         <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid"><span style="color:#7CA32F;" onClick="show_myaccount()">My Account || </span></td>
                            <td class="tab2_right"></td>
                        </tr>
              
            	</table>
            	</td>
            	<td class="width5"></td>
                <td>
                <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid" ><span style="color:#7CA32F;" onClick="show_courses()">My Courses ||  </span></td>
                            <td class="tab2_right"></td>
                        </tr>
                </table>
                </td>
           		 <td class="width5"></td>
                 <td>
                <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid" ><span style="color:#7CA32F;" onClick="show_payment()">Payment History || </span></td>
                            <td class="tab2_right"></td>
                        </tr>
                </table>
                </td>
                <td class="width5"></td>
                 <td>
                <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="tab2_left"></td>
                            <td class="tab2_mid" ><span style="color:#7CA32F;" onClick="show_logsheet()">Logsheet </span></td>
                            <td class="tab2_right"></td>
                        </tr>
                </table>
                </td>
           		 <td class="width5"></td>
              </tr>
            </table>
            <div id="my_account" style="display:block">
             <?
			 /*echo $sql_site_setting="SELECT * FROM enrollment where stud_login_id = '".$_SESSION['stud_login_id']."' ";
                        $row_site_setting=$db->fetch_array($db->query($sql_site_setting));*/
			 ?>
            <table border="0" cellspacing="15" cellpadding="0" width="100%">
                      <tr>
                        <td colspan="3" class="orange_font">* Mandatory Fields</td>
                        </tr>
                      <tr>
                        <td width="20%">Name<span class="orange_font">*</span></td>
                        <td width="40%"><input type="text"  class="validate[required] input_text" name="name" id="name" value=" <?php if ($_POST['name']) echo $_POST['name']; else echo $data_all['name'];?> " /></td> 
                        <td width="40%"></td>
                      </tr>
                      <tr>
                        <td>Email<span class="orange_font">*</span></td>
                        <td><input type="text"  class="validate[required,custom[email]] input_text" name="email" id="email" value="<?php if ($_POST['email']) echo $_POST['email']; else echo $data_all['mail'];?>"/></td>
                        <td width="40%"></td> 
                      </tr>
                      <tr>
                        <td>Contact</td>
                        <td><input type="text"  class="input_text" name="contact" id="contact"  value="<?php if ($_POST['contact']) echo $_POST['contact']; else echo $data_all['contact'];?>" /></td>
                        <td width="40%"></td> 
                      </tr>
                      <tr>
                        <td>Username<span class="orange_font">*</span></td>
                        <td><input type="text"  class="validate[required,custom[email]] input_text" name="uname" id="uname" value="<?php if ($_POST['uname']) echo $_POST['uname']; else echo $data_all['username'];?>" /></td>
                        <td width="40%"></td> 
                      </tr>
                      <tr>
                        <td>Password</td>
                        <td><input type="text"  class="input_text" name="pass11" id="pass11" value="<?php if ($_POST['pass11']) echo $_POST['pass11']; else  echo $data_all['pass'];?>" /></td>
                        <td width="40%"></td> 
                      </tr>
                      
                      <tr>
                        <td valign="top">Address</td>
                        <td><textarea class="input_textarea" name="add" id="add"><?php echo $data_all['address'];?> </textarea></td>
                        <td width="40%" valign="top"></td> 
                      </tr>
                      </tr>
                      <tr>
                          <td>&nbsp;<input type="hidden" name="enroll_id" id="enroll_id" value="<?php echo $data_all['enroll_id']; ?>" /></td>
                          <td><input type="button" class="input_btn" value="Save" name="save" onClick="ajax_save();"/></td>
                          <td></td>
                      </tr>
                </table>
        
            </div>
            
            <div id="my_courses" style="display:none">
            <table width="990" height="84" align="center"  border="1px">
                                   
                                        <br />
                                        
                                    	<tr>
                                            <td><strong>Course Name : &nbsp;&nbsp;&nbsp;</strong><? echo $data_course_name['course_name']; ?></td>
                                            <td><strong>Admission Date : &nbsp;&nbsp;&nbsp;</strong><? echo  $data_all['inquiry_date']; ?></td>
                                        </tr>
                                        <tr style="padding-left:10px">
                                            <td><strong>Course Fee : &nbsp;&nbsp;&nbsp;</strong><? echo $data_all['course_fees']; ?></td>
                                          	<td><strong>Enrollment ID : &nbsp;&nbsp;&nbsp;</strong><? echo  $data_all['installment_display_id']; ?></td>
                                        </tr>
                                        

                                    </table>
            </div>
            <div id="my_payment" style="display:none">
            <table width="990" height="84" align="center"  border="1px">
                                    <?
                                    /*$select_enroll = " select * from enrollment where enroll_id='".$record_id."' ";
									  	$ptr_enroll=mysql_query($select_enroll);
										$data_enroll = mysql_fetch_array($ptr_enroll);
										
										$select_course = " select course_name from courses where course_id='".$data_enroll['course_id']."' ";
									  	$ptr_course=mysql_query($select_course);
										$data_course = mysql_fetch_array($ptr_course);
										*/
										?>
                                        <br />
                                    	<tr style="padding-left:10px">
                                        	
                                            <td><strong>Course Name :</strong></td><td><? echo $data_course_name['course_name']; ?></td>
                                            <td ><strong>Course Fees :</strong></td><td><? echo $data_all['course_fees']; ?></td>
                                        </tr>
                                         <tr>
                                        	<td><strong>Discount in <?php echo $data_all['discount_type']; ?> :</strong></td><td><? echo $data_all['discount']; ?></td>
                                            <td><strong>Service Tax :</strong></td><td><? echo $data_all['service_tax']; ?></td>
                                        </tr>
                                        <tr>
                                        	<td><strong>Total Fees :</strong></td><td><? echo $data_all['total_fees']; ?></td>
                                            <td><strong>Down Payment :</strong></td><td><? echo $data_all['down_payment']; ?></td>
                                        </tr>
                                        <tr>
                                        	<td><strong>Installment On :</strong></td><td><? echo $data_all['installment_on']; ?></td>
                                            <td><strong>No. Of Installment :</strong></td><td><? echo $data_all['no_of_installment']; ?></td>
                                        </tr>
                                        
                                    </table>
                                    <br />
                                    <?php if($_SESSION['no_of_installment'] !=''){ ?>
                                    <table align="center" border="1px " cellpadding="2" cellspacing="2" width="100%">
                                    	<tr><td colspan="4" align="center"><strong>Installments</strong></td></tr>
                                        <tr>
                                        <td>Installment Amount</td><td>Installment Date</td><td>Status</td>
                                        </tr>
                                        <?php 
										$sel_inst="select installment_amount, installment_date,status from installment where enroll_id=".$data_all['enroll_id']."";
										$ptr_inst=mysql_query($sel_inst);
										while($data_inst=mysql_fetch_array($ptr_inst))
										{
											?>
											 <tr>
											<td align="center"><?php echo $data_inst['installment_amount']; ?></td><td align="center"><?php echo $data_inst['installment_date']; ?></td><td align="center"><?php echo $data_inst['status']; ?></td>
											</tr>
                                  			<?php 
								  		}	?>
                                    </table>
                                    <?php }?>
                                    <br />
            <!-- =====================================================INVOICE SUMMERY START===========================================================================-->
<?php
								$sel_invoice= "SELECT * FROM invoice where enroll_id='".$data_all['enroll_id']."' order by invoice_id desc";
								$ptr_query_invoice=mysql_query($sel_invoice);
								$k=1;
								if(mysql_num_rows($ptr_query_invoice) !='')
								{
?>
                                       <table width="100%" align="center"  cellpadding="0" cellspacing="1" border="1px">
								<tr align="center" class="grey_td" ><td width="7%" class="tr-header"><strong>Sr.</strong></td><td width="11%" class="tr-header"><strong>Invoice No.</strong></td><td width="12%" class="tr-header"><strong>Inst. Paid</strong></td><td width="15%" class="tr-header"><strong>Balance Amount</strong></td><td width="20%"  class="tr-header"><strong>Installment</strong></td><td width="8%" class="tr-header"><strong> Date </strong></td><td width="6%" class="tr-header"><strong> Status </strong></td><td width="9%" class="tr-header"><strong>View</strong></td></tr><?php
								
								
									while($data_invoice=mysql_fetch_array($ptr_query_invoice))
									{
											$enroll_id=$data_invoice['enroll_id'];
											$paid_totas=0;
											echo '<tr class="'.$bgclass.'">';
											echo '<td align="center">'.$k.'</td>';
											echo "<td align='center'>".$data_invoice['invoice_id']."</td>";
											$name ='';
											$email_id = '';
											$phone_no ='';
						
											$paid=$data_all['paid'];
											
											$totsss=$data_all['course_fees']-$data_all['discount'];
											$bal_totas=$totsss-$data_all['paid']; 
											
										   echo '<td align="center">'.$data_invoice['amount'].'</td>'; 
										   echo '<td align="center">'.$data_invoice['balance_amt'].'</td>';
										   echo '<td align="center">';
									 $select_installments = " SELECT * FROM `installment` where enroll_id ='$enroll_id' and invoice_id = '".$data_invoice['invoice_id']."' and course_id='".$data_all['course_id']."'  ";
									$ptr_installment = mysql_query($select_installments);
									while($data_installment = mysql_fetch_array($ptr_installment))
									{
										 $col_paid ='<font color="#006600">';
										if($data_installment[status] =='not paid')
										$col_paid ='<font color="#FF3333">';
									 echo $data_installment[installment_amount].'/- '.$data_installment[installment_date].' : '.$col_paid.$data_installment[status]."</font><br>";	
									}
									
									
									echo '</td>';
											echo '<td align="center">';
											echo date("d-m-Y",strtotime($data_invoice['added_date']));
											echo'</td>';
											 echo '<td align="center">';
											echo $data_invoice['status'];
											echo'</td>';
											echo "<td align='center'>
											<img src='../../../faculty_login/images/view.jpeg' title='View Invoice' border='0' 
											onclick=\"window.open('../../../faculty_login/invoice-generate.php?record_id=".$data_invoice['invoice_id']."','View Invoice','scrollbars=yes','resizable=yes','width=900,height=600')\" style='cursor:pointer' >
											</td>";
											
											
											echo '</tr>';
										   $k++;
										}
									}
                                    ?>
                                        </table>
                                        <table align="right">
                                        <tr>
                                        <?
                                        if($data_all['balance_amt'] !=0)
										{
											
											/*echo '<td>';
											echo'<a href="add_payment_to_do.php?record_id='.$enroll_id.'"><strong><font size="+1">Add Payment</font></strong></a>'; 
											echo '</td>';
											echo '<td>';
											echo  '<a href="add_payment_to_do.php?record_id='.$enroll_id.'">
											<img src="images/add1-.png" border="0" title="Add Payment"></a>';
											echo '</td>';*/
										}
								?>
                                		</tr>
                                		</table>
                                    
    <!--=========================================================INVOICE SUMMERY END======================================================================================-->
                                    
                                    
            </div>
            <div id="my_logsheet" style="display:none">
            
            		<table width="990" height="84" align="center" border="1px">
                    <br/>
					
                        <tr style="padding-left:10px">
                            <td colspan="2"><strong>Course Name :&nbsp;&nbsp;&nbsp;</strong><? echo $data_course_name['course_name']; ?><input type="hidden" name="course_id" id="course_id" value="<? echo $data_all['course_id']?>" /></td>
                        </tr>
                        <tr>
                            <td><strong>Admission Date :&nbsp;&nbsp;&nbsp;</strong><? echo $data_all['added_date']; ?></td>
                            <td><strong>Enrollment ID :&nbsp;&nbsp;&nbsp;</strong><? echo $data_all['installment_display_id']; ?><input type="hidden" name="enroll_id_1" id="enroll_id_1" value="<? echo $data_all['enroll_id']?>" /></td>
                            
                        </tr>
                    </table>
                    <br/>
                    <table width="100%" align="center"  cellpadding="0" cellspacing="1"  border="1px">
                    <tr align="center" class="grey_td" >
                        <td width="6%" class="tr-header"><strong>Sr No.</strong></td>
                        
                        <td width="8%" class="tr-header"><strong>Week 1 Date</strong></td>
                        <td width="17%" class="tr-header"><strong>Theory Topic</strong></td>
                        <td width="8%"  class="tr-header"><strong>Total Hours</strong></td>
                       
                        <td width="12%" class="tr-header"><strong>Faculty Sign</strong></td>
                        <td width="12%" class="tr-header"><strong>Student Sign</strong></td>
                    </tr>
					<?php
					   
                            
                             $select_topic_id = "select t.topic_id as topic_id, t.topic_name as topic_name, t.duration as duration from topic_map t_c, topic t where t_c.course_id='".$data_all['course_id']."' and t_c.topic_id = t.topic_id ";
                            $ptr_topic_id=mysql_query($select_topic_id);
                            echo '<input type="hidden" name="total_topic" id="total_topic" value="'.mysql_num_rows($ptr_topic_id).'"/>';
							$j=1;
                            while($data_topic_id = mysql_fetch_array($ptr_topic_id))
                            {
                            
                            
                            
                            $sel_logsheet="select * from logsheet where enroll_id='".$data_all['enroll_id']."' and topic_id='".$data_topic_id['topic_id']."'";
                            $ptr_logsheet=mysql_query($sel_logsheet);
                            $data_logsheet=mysql_fetch_array($ptr_logsheet);
							 
							$enroll_id=$val_record['enroll_id'];
                            $paid_totas=0;
							
                          
							
							
							
                            echo '<tr class="">';
                            echo '<td align="center">'.$j.'</td>';
                            
                            echo '<td align="center">'.$data_logsheet['added_date'].'</td>'; 
                            echo '<td align="center">'.$data_topic_id['topic_name'].'<input type="hidden" name="topic_id" id="topic_id_'.$j.'" value="'.$data_topic_id['topic_id'].'"></td>'; 
                            echo '<td align="center">'.$data_topic_id['duration'].'</td>';
                            
                            if($data_logsheet['faculty_sign']=='completed')
                            {
                             echo '<td align="center">';
                             echo'<img src="../../../faculty_login/images/active_icon.png" width="30px" height="30px"><input type="hidden" id="action11" name="action_'.$j.'" value="completed" />';
                             echo '</td>';
                            }
                            else
                            {
                                
                                 echo '<td align="center">';
                               //  echo '<input type="checkbox" disabled id="action11" name="action_'.$j.'" value="completed" />';
                                 echo '</td>';
                            }
                            if(date('Y-m-d')> $data_logsheet['added_date'] && $data_logsheet['student_sign']=='completed')
							{
								
								$disabled='disabled="disabled"';
							}
							else
							{
								
								$disabled="";
							}
                            if($data_logsheet['student_sign']=='completed')
                            {
                             echo '<td align="center">';
                             echo'<input type="checkbox" id="action1_'.$j.'" '.$disabled.'  checked="checked" name="action1[]" value="completed" />';
                             echo '</td>';
                            }
                            else
                            {
                                echo '<td align="center">';
                                echo '<input type="checkbox" id="action1_'.$j.'" name="action1[]" value="completed" />';
                                echo'</td>';
                            }
                            
                            echo '</tr>';
                            
                           $j++;
                          
                        
                        }
                       
                        ?>
                         <table width="100%" align="center">
                                <tr  style="font-weight:bold; height:30px;">
                                    <td align="right" colspan="3">
                                   <input type="button" name="save_logsheet"  id="save_logsheet" value="Save" onclick="ajax_logsheet()"/> 
                                     </td>
                                    <td>
                                    <?php
                                  echo "  <input type='button' name='print' value='Print' title='Print logsheet' onclick=\"window.open('faculty_login/logsheet-generate.php?record_id=".$data_all['enroll_id']."&View Invoice','scrollbars=yes','resizable=yes','width=900,height=600')\" style='cursor:pointer' />"
                                  ?>
                                    </td>
                                </tr>
                         </table>
                         
               </table>
                           
            </div>
            </ul>
    
    <?PHP
					 //===================================================================
					 
				}
				else
				{
					 echo 0; //null
				}
				
			}
			if($action=='ajax_logout')
			{
				//unset($_SESSION['username']);
				session_destroy();
			}
			
                                        
		?>		  