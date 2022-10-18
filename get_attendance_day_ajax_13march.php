<?php include 'inc_classes.php';
 ?>


<?php
$select_exc = "select * from pr_import_attendance where month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' AND staff_id='".$_REQUEST['staff']."'";
                            $ptr_fs = mysql_query($select_exc);
                            $present_days=0;
                            $val_query = mysql_fetch_array($ptr_fs);
                            
							
						// ------- Working Days ------------
					
								$select_exc_work = "select * from pr_leave_management where branch_name='".$_REQUEST['branch_name']."' AND month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' ";
								// $ptr_fs = mysql_query($select_exc);
								$working_days=mysql_fetch_array($db->query($select_exc_work));

						// ------- Working Days END ------------
						  
						// ------- Advance Deduction ------------
							
							$select_exc_adv = "select s.* from pr_staff_advance_salary_management m, pr_advance_installments s where s.staff_advance_salary_id=m.staff_advance_salary_id and MONTH(s.i_date)='".$_REQUEST['month']."' and YEAR(s.i_date)='".$_REQUEST['year']."' and m.staff_id='".$_REQUEST['staff']."' AND m.advance_type='Salary Advance' order by  s.staff_advance_salary_id asc ";
							$det = $db->fetch_array($db->query($select_exc_adv));
							  
					    // ------- Advance Deduction  END------------
						
						// ------- Expense Addition ------------
						  
							$emp = "select * from site_setting where attendence_id='".$_REQUEST['staff']."'";
							$emp1 = $db->fetch_array($db->query($emp));
							$currentMonth =$_REQUEST['year'].'-'.$_REQUEST['month'].'-01';
                            $prv_month=Date('m', strtotime('-1 month',strtotime($currentMonth)));
						    $prv_year=Date('Y', strtotime('-1 month',strtotime($currentMonth)));
							$select_exc1 = "select * from expense where MONTH(added_date)='".$prv_month."' AND YEAR(added_date)='".$prv_year."' AND employee_id='".$emp1['admin_id']."' AND payment_mode_id='8' ";
							$det1 = $db->fetch_array($db->query($select_exc1));
							  
					    // ------- Expense Addition END------------
										
						// ------- Service Incentive ------------
						  
							$inc_month = "select * from pr_incentive_calculation where branch_name='".$_REQUEST['branch_name']."'";
							$inc = $db->fetch_array($db->query($inc_month));
							$currentMonth =$_REQUEST['year'].'-'.$_REQUEST['month'].'-01';
                            $prv_month1=Date('m', strtotime('-'.$inc['incentive_paid_month'].' month',strtotime($currentMonth)));
							$prv_year1=Date('Y', strtotime('-'.$inc['incentive_paid_month'].' month',strtotime($currentMonth)));
							$select_exc2 = "select * from pr_staff_service_incentive where month='".$prv_month1."' AND year='".$prv_year1."' AND staff_id='".$emp1['admin_id']."' ";
							$det2 = $db->fetch_array($db->query($select_exc2));
							  
					    // ------- Service Incentive END------------
							   
					    // ------- Product Incentive ------------
			
							$currentMonth =$_REQUEST['year'].'-'.$_REQUEST['month'].'-01';
                            $prv_month3=Date('m', strtotime('-'.$inc['incentive_paid_month'].' month',strtotime($currentMonth)));
							$prv_year3=Date('Y', strtotime('-'.$inc['incentive_paid_month'].' month',strtotime($currentMonth)));
							$select_exc3 = "select * from pr_staff_product_incentive where month='".$prv_month3."' AND year='".$prv_year3."' AND staff_id='".$_REQUEST['staff']."' ";
							$det3 = $db->fetch_array($db->query($select_exc3));
							  
					    // ------- Product Incentive END------------
						
						// ------- Event Incentives ------------
						      $currentMonth =$_REQUEST['year'].'-'.$_REQUEST['month'].'-01';
                              $prv_month4=Date('m', strtotime('-'.$inc['incentive_paid_month'].' month',strtotime($currentMonth)));
							  $prv_year4=Date('Y', strtotime('-'.$inc['incentive_paid_month'].' month',strtotime($currentMonth)));
							  $ad="SELECT * FROM pr_staff_event_management where MONTH(event_date_to)='".$prv_month4."' AND YEAR(event_date_to)='".$prv_year4."' AND staff_id='".$_REQUEST['staff']."' ";
							  $event_inc = $db->fetch_array($db->query($ad));
							 
							 
							  
						// -------  Event Incentives END------------
						
						// ------- Course Incentive ------------
						  
							$inc_month = "select * from pr_incentive_calculation where branch_name='".$_REQUEST['branch_name']."'";
							$inc = $db->fetch_array($db->query($inc_month));
							$currentMonth =$_REQUEST['year'].'-'.$_REQUEST['month'].'-01';
                            $prv_month5=Date('m', strtotime('-'.$inc['incentive_paid_month'].' month',strtotime($currentMonth)));
							$prv_year5=Date('Y', strtotime('-'.$inc['incentive_paid_month'].' month',strtotime($currentMonth)));
							$select_exc5 = "select * from pr_staff_course_incentive where month='".$prv_month5."' AND year='".$prv_year5."' AND staff_id='".$emp1['attendence_id']."' ";
							$det5 = $db->fetch_array($db->query($select_exc5));
							  
						// ------- Course Incentive END------------
						
						
						// -------Staff Salary Details --------
							 
							 if($_REQUEST['type']=="leave")
							 {
								 $pd="SELECT total_till_date FROM pr_import_attendance where month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' AND staff_id='".$_REQUEST['staff']."' ORDER BY attendance_id DESC LIMIT 0,1";
							 $p_days = $db->fetch_array($db->query($pd));
							 
							  $sum_late_marks="SELECT SUM(late_marks) as late_mark FROM pr_import_attendance WHERE month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' AND staff_id='".$_REQUEST['staff']."'";
							  $sum_late_marks1 = $db->fetch_array($db->query($sum_late_marks));
							  $late_mark=$sum_late_marks1['late_mark'];
							 
							  $late_mark_count=floor($late_mark/3);
							  $lm=$late_mark_count/2;
							  
							  $sum_extra_days="SELECT SUM(extra_days) as extra_day FROM pr_import_attendance WHERE month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' AND staff_id='".$_REQUEST['staff']."'";
							  $sum_extra_days1 = $db->fetch_array($db->query($sum_extra_days));
							  
                            // $present_days=$p_days['total_till_date'];
							 $total_days=$val_query['days'];
							 $leave_days=$working_days['no_of_working_days']-$p_days['total_till_date'];
						
							 $present_days=$p_days['total_till_date']; 
							 }
							 
							 else							 
							 {
							 
							 $pd="SELECT * FROM pr_staff_leave_management where month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' AND staff_id='".$_REQUEST['staff']."'";
							 $p_days = $db->fetch_array($db->query($pd));
							 
							
                            // $present_days=$p_days['total_till_date'];
							 $total_days=$p_days['number_of_days_in_month'];
							 $leave_days=$p_days['leave_days'];
							 $final_paid_days=$p_days['final_paid_days'];

                             //$extra_days=$p_days['extra_days'];	
							 $extra_leave_type=$p_days['extra_leave_type'];	
							 $present_days=$p_days['present_days']; 
							 }
							 $staff_salary_detail = "select * from pr_add_salary_details where staff_id='".$_REQUEST['staff']."'";     
							 $staff_salary = $db->fetch_array($db->query($staff_salary_detail));
							 $per_day=$staff_salary['total_salary']/$working_days['no_of_working_days'];
							 $payable_salary=$per_day*$final_paid_days;
							 $after_proffesional_tax=$payable_salary-$staff_salary['proffessional_tax'];
							 $after_tds=$after_proffesional_tax-$staff_salary['tds'];
							 $after_advance=$after_tds-$det['i_amount']; 
							 $after_expence_addition=$after_advance+$det1['total_price'];
							// $extra_days_payment_amount1=$_REQUEST['extra_days_payment']*$per_day;
							// $extra_days_payment_amount=$extra_days_payment_amount1*$extra_days;
							 $total=$det2['grand_total']+$det3['grand_total']+$event_inc['amount']+$_REQUEST['other_incentive']+$det5['grand_total']+$after_expence_addition+($_REQUEST['adjustment']);
							
						// -------Staff Salary Details END--------
							 
						// -------previous Leave Details ------------
						     $current_Month1 =date('Y').'-'.$_REQUEST['month'].'-01';
                             $last_month=Date('m', strtotime('-1 month',strtotime($current_Month1)));
							 $last_year=Date('Y', strtotime('-1 month',strtotime($current_Month1)));
							 $leave_detail = "select * from pr_previous_leave_management where staff_id='".$_REQUEST['staff']."' AND month='".$last_month."' AND year='".$last_year."' order by previous_leave_id desc limit 0,1";     
							 $leave = $db->fetch_array($db->query($leave_detail));
							 $lev = mysql_query($leave_detail);
							 $leav_count=mysql_num_rows($lev);
							 $previous_balance_leaves=$leave['previous_balance_leaves'];
							 $monthly_leave=$leave['monthly_leave'];
							 
						// -------previous Leave Details END------------
							  
							  
						// ------- for Salary -- Leave Details ------------
							 
							$leaves = "select * from pr_staff_leave_management where staff_id='".$_REQUEST['staff']."' AND month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' "; 
							$pre_leaves = $db->fetch_array($db->query($leaves));
							 $lev1 = mysql_query($leaves);
							 $sal_leav_count=mysql_num_rows($lev1);
							
						// ------- for Salary --  Leave Details END------------	  
							 
							echo $leave_days.">>".$present_days.">>".$staff_salary['total_salary'].">>".$after_proffesional_tax.">>".$per_day.">>".$after_advance.">>".$after_expence_addition.">>".$total.">>".$after_tds.">>".$previous_balance_leaves.">>".$monthly_leave.">>".$leav_count.">>".$det['i_amount'].">>".$det1['total_price'].">>".$det2['grand_total'].">>".$det3['grand_total'].">>".$event_inc['amount'].">>".$det5['grand_total'].">>".$det1['expense_id'].">>".$payable_salary.">>".$val_query['days'].">>".$working_days['no_of_working_days'].">>".$sal_leav_count.">>".$final_paid_days.">>".$extra_days.">>".$extra_leave_type.">>".$extra_days_payment_amount.">>".$lm.">>".$sum_extra_days1['extra_day'];
			?>

