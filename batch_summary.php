<?php include 'inc_classes.php'; 
include "admin_authentication.php";?>
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<title>Dashboard</title>
	<?php //include "include/headHeader.php";?>
	<?php //include "include/functions.php"; ?>
	<!-- Tell the browser to be responsive to screen width -->
  	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  	<!-- Bootstrap 3.3.7 -->
  	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  	<!-- Font Awesome -->
  	<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  	<!-- Ionicons -->
  	<link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  	<!-- Theme style -->
  	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  	<!-- AdminLTE Skins. Choose a skin from the css/skins
  	     folder instead of downloading all of them to reduce the load. -->
  	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  	<!-- Morris chart -->
  	<link rel="stylesheet" href="bower_components/morris.js/morris.css">
  	<!-- jvectormap -->
  	<link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
  	<!-- Date Picker -->
  	<link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  	<!-- Daterange picker -->
  	<link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  	<!-- bootstrap wysihtml5 - text editor -->
  	<link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
 	<!-- iCheck for checkboxes and radio inputs -->
  	<link rel="stylesheet" href="plugins/iCheck/all.css">
  	<!-- Bootstrap Color Picker -->
  	<link rel="stylesheet" href="bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  	<!-- Select2 -->
  	<link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">

  	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  	<!--[if lt IE 9]>
  	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  	<![endif]-->

  	<!-- Google Font -->
  	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
  th {
	  text-align:center;
	  }
	td {
		text-align:center;
	}
  </style>
<script>
function change_topic(day,batch_id)
{
	if(confirm("Are you sure, you want to change Day / Topic for this day?"))
	{
		var date=document.getElementById('curr_date').value;
		var data1="action=change_day&day="+day+"&course_batch_id="+batch_id+"&date="+date;
		//alert(data1);
		$.ajax ({
			url: "ajax_home.php", type: "post", data: data1, cache: false,
			success: function (html)
			{
				//alert(html);
				document.getElementById('topic_content_'+batch_id).innerHTML=html;
			}
		});
	}
	else
	{
		return false;
	}
}
</script>
</head>
<body class="hold-transition skin-blue sidebar-mini" style="background-image:url(images/bg-1.jpg); background-repeat:no-repeat;background-size: auto;">
<div class="wrapper">
<?php include "include/header.php"; ?>
<?php //include "include/menuLeft.php"; ?>
<?php //include "dashboard.php";?>
<?php //include "include/footer.php";?>

<div class="content-wrapper" style="margin-left:0px !important">
    <!-- Content Header (Page header) -->
	<section class="content-header">
      <!--<h1>
        Dashboard
        <small>Control panel</small>
      </h1>-->
      <form method="get" name="search">
      <h3>
        <center><?php if($_REQUEST['branch_name']!='') { echo '<span style="color:#f39c12; font-weight:600">'.$_REQUEST['branch_name'].' Branch - </span>';} else echo '<span style="color:#f39c12">ISAS ALL CENTRES - </span>'; echo '<span style="color:#3c8dbc;">'.date('D').' - '.date('d-M-Y').'</span>'; ?></center>
        <input type="hidden" name="curr_date" id="curr_date" value="<?php echo date('Y-m-d'); ?>" />
      </h3>
      <div>
      	<?php 
		if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
		{
			?>
			<select name="branch_name" id="branch_name" style="width:160px" class="form-control select2 select2-hidden-accessible" >
				<option value="">Select Branch</option>
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
            &nbsp;&nbsp;&nbsp;
            <input type="submit" name="search" value="Search" title="Search" class="btn btn-success" >
            
			<?php
		}
		?>
      </div>
      <!--<ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>-->
      </form>
    </section>
    <section class="content">
    	<!--=============================================Hair========================================================-->
        <?php
		$sel_cate="select * from course_domain_category where 1 order by sequence_no asc";
		$ptr_cate=mysql_query($sel_cate);
		if(mysql_num_rows($ptr_cate))
		{
			while($data_cat=mysql_fetch_array($ptr_cate))
			{
				$cat_id=$data_cat['cat_id'];
				$cat_name=$data_cat['cat_name'];
				$cat_name_small=strtolower($data_cat['cat_name']);
				?>
				<div class="row">
					<!-- /.col -->
					<?php
					if($_POST['save_changes_'.$cat_id.''])
					{
						$agree=$_POST['agree'];
						if($agree !='')
						{
							$total_student=$_POST['total_student_'.$agree.''];
							$attendenceDate=date('Y-m-d');
							$topic_id=$_POST['topic_id_'.$agree.''];
							$curr_day=$_POST['day_'.$agree.''];
							$admin_id=$_POST['admin_id_'.$agree.''];
							for($i=1;$i<=$total_student;$i++)
							{
								$enroll_id=$_POST['enrollid_'.$agree.'_'.$i];
								$course_id=$_POST['courseid_'.$agree.'_'.$i];
								$attendence=$_POST['attendence_'.$agree.'_'.$i.''];
								
								$uniform=$_POST['uniform_'.$agree.'_'.$i.''];
								$latemark=$_POST['latemark_'.$agree.'_'.$i.''];
								$mobile=$_POST['mobile_'.$agree.'_'.$i.''];
								$sms=$_POST['sms_'.$agree.'_'.$i.''];
								
								$sel_batch_id="select batch_id,cm_id from course_batch_mapping where c_b_id='".$agree."'";
								$ptr_batch_id=mysql_query($sel_batch_id);
								$data_batch=mysql_fetch_array($ptr_batch_id);
								
								$insert_logsheet1="INSERT INTO `student_attendence` (`course_batch_id`,`course_id`,`topic_id`, `enroll_id`,`batch_id`,`attendence`, `attendence_date`, `uniform`, `latemark`,`mobile_submit`, `sms_send`,`admin_id`,`cm_id`,`added_date`) VALUES ('".$agree."','".$course_id."','".$topic_id."','".$enroll_id."','".$data_batch['batch_id']."','".$attendence."','".$attendenceDate."','".$uniform."','".$latemark."','".$mobile."','".$sms."','".$admin_id."','".$data_batch['cm_id']."','".date('Y-m-d H:i:s')."')";                          
								$ptr_query=mysql_query($insert_logsheet1);
							}
							$update="update batch_timetable set status='Completed' where c_b_id='".$agree."' and date='".$attendenceDate."' and day='".$curr_day."'";
							$up_query=mysql_query($update);
							
							?>
							<div class="alert alert-success alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-check"></i> Save!</h4>
							Attendence Save Successfully.
							</div>
							<?php
						}
					}
					
						$where_staff_id='';
						$search_cm_id='';
						$branch_name='';
						if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
						{
							if($_REQUEST['branch_name']!='')
							{
								$branch_name=$_REQUEST['branch_name'];
								$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_cm_id=mysql_query($select_cm_id);
								$data_cm_id=mysql_fetch_array($ptr_cm_id);
								$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
								//$search_cm_id_s=" and s.cm_id='".$data_cm_id['cm_id']."'";
							}
							else
							{
								$search_cm_id='';
								//$search_cm_id_s='';
							}
						}
						else
						{
							$where_staff_id=" and staff_id='".$_SESSION['admin_id']."'";
						}
					
					
					$sel_batch="select * from course_batch_mapping where 1 and DATE(`start_date`)<='".date('Y-m-d')."' and DATE(`end_date`)>='".date('Y-m-d')."' and course_domain_id='".$cat_id."' ".$search_cm_id." ".$_SESSION['where']." order by c_b_id desc ";
					$ptr_batch=mysql_query($sel_batch);
					if(mysql_num_rows($ptr_batch))
					{
						?>
						<h3 class="box box-title box-primary" align="center" style="background:#00c0ef; border-radius:0px !important; color:#FFF"><?php echo $cat_name; ?></h3>
						<div class="box box-default box-solid">
						<div class="box-header with-border" style="padding-left:22px; padding-right:22px" >
							<table width="100%">
							<tr><td width="5%"><h4 class="box-title">Sr. No</h4></td><td width="10%"><h4 class="box-title">Batch ID</h4></td><td width="20%"><h4 class="box-title">Course Name</h4></td><td width="15%"><h4 class="box-title">Batch Date</h4></td><td width="15%"><h4 class="box-title">Batch Time</h4></td><td width="15%"><h4 class="box-title">No. of Students</h4></td><td width="20"><h4 class="box-title">Faculty Name</h4></td></tr>
							</table>
						</div>
						</div>
						<form method="post" name="frm_<?php echo $cat_id; ?>">
						<?php
						$it=1;
						while($data_batch=mysql_fetch_array($ptr_batch))
						{
							$sel_course="select course_name from courses where course_id='".$data_batch['course_id']."'";
							$ptr_course=mysql_query($sel_course);
							$data_course=mysql_fetch_array($ptr_course);
							
							$sel_time="select batch_time from batch_time where batch_time_id='".$data_batch['batch_time_id']."'";
							$ptr_time=mysql_query($sel_time);
							$data_time=mysql_fetch_array($ptr_time);
							
							$sel_staff="select name from site_setting where admin_id='".$data_batch['staff_id']."'";
							$ptr_staff=mysql_query($sel_staff);
							$data_staff=mysql_fetch_array($ptr_staff);
							
							$str_date=explode("-",$data_batch['start_date']);
							$start_date=$str_date[2].'/'.$str_date[1].'/'.$str_date[0];
							
							$en_date=explode("-",$data_batch['end_date']);
							$end_date=$en_date[2].'/'.$en_date[1].'/'.$en_date[0];
							
							$select_att ="select * from `student_attendence` where 1 and course_batch_id='".$data_batch['c_b_id']."' and attendence_date='".date('Y-m-d')."'";
							$pr_att=mysql_query($select_att);
							if(mysql_num_rows($pr_att))
							{
								$class='box box-success collapsed-box box-solid';
							}
							else
								$class='box box-warning collapsed-box box-solid';
								
							$sel_studen="select s_c_b_id from student_course_batch_map where c_b_id='".$data_batch['c_b_id']."'";
							$ptr_std=mysql_query($sel_studen);
							$total_std=mysql_num_rows($ptr_std);
							
							$course_batch_id=$data_batch['c_b_id'];
							
							$sel_timetable="select batch_timetable_map_id from batch_timetable where c_b_id='".$course_batch_id."' and date='".date('Y-m-d')."'";
							$ptr_timetable=mysql_query($sel_timetable);
							$data_exist=mysql_num_rows($ptr_timetable);
							if(!mysql_num_rows($ptr_timetable))
							{
								$class='box box-danger collapsed-box box-solid';
							}
							?>
							
							<div class="col-md-12">
							  <div class="<?php echo $class; ?>">
								<div class="box-header with-border">
									<table width="100%">
									<tr><td width="5%"><?php echo $it; ?></td><td width="10%"><h4 class="box-title"><?php echo $data_batch['batch_name'] ?></h4></td><td width="20%"><h4 class="box-title"><?php echo $data_course['course_name'] ?></h4></td><td width="15%"><h4 class="box-title"><?php echo $start_date.'&nbsp;&nbsp;to&nbsp;&nbsp;'.$end_date; ?></h4></td><td width="15%"><h4 class="box-title"><?php echo $data_time['batch_time'];?></h4></td><td width="15%"><h4 class="box-title"><?php echo $total_std; ?></h4></td><td width="20"><h4 class="box-title"><?php echo $data_staff['name']; ?></h4></td></tr>
									</table>
								  <div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
									</button>
								  </div>
								  <!-- /.box-tools -->
								</div>
								<!-- /.box-header -->
								<div class="box-body">
									<div class="box" style="border-top-color:#FFF !important">
										<div class="box-body table-responsive no-padding">
										<?php
										if(mysql_num_rows($ptr_timetable))
										{
											$sql_records= "SELECT * FROM student_course_batch_map where c_b_id=".$course_batch_id." ".$_SESSION['where']." order by s_c_b_id asc";
											$sql_query=mysql_query($sql_records);
											$no_of_records=mysql_num_rows($sql_query);
											if($no_of_records)
											{
												$select_atte="select admin_id from `student_attendence` where course_batch_id='".$course_batch_id."' and attendence_date='".date('Y-m-d')."'";
												$pr_atte=mysql_query($select_atte);
												$data_atte=mysql_fetch_array($pr_atte);
												
												?>
												<table class="table table-hover">
												<tr bgcolor="#F7F7F7">
												<th colspan="2" align="center">
                                                
                                                <input type="hidden" name="total_student_<?php echo $course_batch_id; ?>"  id="total_student_<?php echo $course_batch_id; ?>" value="<?php echo $no_of_records; ?>" />
												<?php
												$sel_timet="Select batch_timetable_map_id,day,date,topic_id,topic_content,cm_id,staff_id from batch_timetable where c_b_id='".$course_batch_id."' and date ='".date('Y-m-d')."'";
												$ptr_timet=mysql_query($sel_timet);
												$data_timet=mysql_fetch_array($ptr_timet);
												  
												//echo 'Day &nbsp;'.$data_timet['day']; 
												?>
												<!--<input type="hidden" name="day_<?php //echo $course_batch_id; ?>" id="day_<?php //echo $course_batch_id; ?>" value="<?php //echo $data_timet['day']; ?>" >-->
												<select class="form-control" name="day_<?php echo $course_batch_id; ?>" id="day_<?php echo $course_batch_id; ?>" onChange="change_topic(this.value,<?php echo $course_batch_id; ?>)">
												<option value="">Select Day</option>
												<?php
												$sel_timet="Select batch_timetable_map_id,day,date,topic_id,topic_content from batch_timetable where c_b_id='".$course_batch_id."' group by day order by day";
												$ptr_timetable=mysql_query($sel_timet);
												while($data_time=mysql_fetch_array($ptr_timetable))
												{
													$sel='';
													if($data_time['date']==date('Y-m-d'))
													{
														$sel='selected';
													}
													?>
													<option value="<?php echo $data_time['day']; ?>" <?php echo $sel; ?>>Day <?php echo $data_time['day']; ?></option>
													<?php
												}
												?>
												</select>
												</th>
												<th colspan="3" id="topic_content_<?php echo $course_batch_id ?>">
												<?php
												$sel_topict="Select topic_id,date from batch_timetable where c_b_id='".$course_batch_id."' and date='".date('Y-m-d')."'";
												$ptr_topict=mysql_query($sel_topict);
												while( $data_topict=mysql_fetch_array($ptr_topict))
												{
													$sel_topic="select topic_name from topic where topic_id='".$data_topict['topic_id']."'";
													$ptr_topic=mysql_query($sel_topic);
													$data_topic_name=mysql_fetch_array($ptr_topic);
												  	echo $data_topic_name['topic_name'].'<br/>';
												}
												?>
												<input type="hidden" name="topic_id_<?php echo $course_batch_id; ?>" id="topic_id_<?php echo $course_batch_id; ?>" >
												<!--<select class="form-control" name="topic_id_<?php //echo $course_batch_id; ?>" id="topic_id" onChange="change_topic(this.value,<?php //echo $course_batch_id; ?>)">
												<option value="">Select Topic</option>
												<?php
												/*$sel_top="Select topic_id,date from batch_timetable where c_b_id='".$course_batch_id."'";
												$ptr_top=mysql_query($sel_top);
												while($data_top=mysql_fetch_array($ptr_top))
												{
													$sel_topic="select topic_name from topic where topic_id='".$data_top['topic_id']."'";
													$ptr_topic=mysql_query($sel_topic);
													$data_topic=mysql_fetch_array($ptr_topic);
													 
													$sel='';
													if($data_top['date']==date('Y-m-d'))
													{
														$sel='selected';
													}
													?>
													<option value="<?php echo $data_top['topic_id']; ?>" <?php echo $sel; ?>><?php echo $data_topic['topic_name']; ?></option>
													<?php
												}*/
												?>
												</select>-->
												</th>
												<th colspan="1">
                                                <select class="form-control" name="admin_id_<?php echo $course_batch_id; ?>" id="admin_id_<?php echo $course_batch_id; ?>">
												<option value="">Select Staff Name</option>
                                                	<?php
													$sel_admin="Select name,admin_id from site_setting where cm_id='".$data_timet['cm_id']."' and system_status='Enabled'";
													$ptr_admin=mysql_query($sel_admin);
													while($data_admin=mysql_fetch_array($ptr_admin))
													{
														$sel='';
														if($data_atte['admin_id']=='')
														{
															if($data_admin['admin_id']==$data_timet['staff_id'])
															{
																$sel='selected';
															}
														}
														else
														{
															if($data_admin['admin_id']==$data_atte['admin_id'])
															{
																$sel='selected';
															}
														}
														?>
														<option value="<?php echo $data_admin['admin_id']; ?>" <?php echo $sel; ?>><?php echo $data_admin['name']; ?></option>
														<?php
													}
													?>
                                                </select>
												</th>
                                                <th></th>
                                                <th><a href="view_batch_timetable.php?record_id=<?php echo $course_batch_id; ?>" target="_blank"><span class="glyphicon glyphicon-file"></span><br/><span class="glyphicon-class">Show Batch Timetable</span></a></th>
											</tr>
											<tr>
												  <th align="center">Sr. No.</th>
												  <th align="center">Student Name</th>
												  <th align="center">Course Name</th>
												  <th align="center">Installment</th>
												  <th align="center">Attendence</th>
												  <th align="center">Not in Uniform</th>
												  <th align="center">Is Latemark</th>
												  <th align="center">Mobile Not Submited</th>
												  <th align="center">Send SMS</th>
												</tr>
												<?php
												$j=1;
												$data_chk='';
												while($val_record=mysql_fetch_array($sql_query))
												{
													
													$installment_from_date=" and DATE(installment_date) >='".date('Y-m-d')."'";//'".date('Y-m-d',strtotime('-30 days'))."'
													$installment_to_date=" and DATE(installment_date)<='".date('Y-m-d')."'";
													
													$select_name="select enroll_id,course_id,name from enrollment where enroll_id='".$val_record['enroll_id']."' ";
													$ptr_name=mysql_query($select_name);
													$data_name = mysql_fetch_array($ptr_name);
													
													$select_topic_name="select course_name,course_id from courses where course_id='".$data_name['course_id']."' ";
													$ptr_topic_name=mysql_query($select_topic_name);
													$data_topic_name=mysql_fetch_array($ptr_topic_name);
													
													$select_attendence="select * from `student_attendence` where  enroll_id='".$val_record['enroll_id']."' and course_batch_id='".$val_record['c_b_id']."' and attendence_date='".date('Y-m-d')."'";
													$pr_attendence=mysql_query($select_attendence);
													if(mysql_num_rows($pr_attendence))
													{
														$data_chk='yes';
													}
													$data_logsheet=mysql_fetch_array($pr_attendence);
													
													$listed_record_id =$val_record['s_c_b_id'];
													
													$enroll_id=$val_record['enroll_id'];
													$paid_totas=0;
													
													$checked='';
													if($data_logsheet['selected_topic_id'] !=0)
													{
														$checked='checked="checked"';
													}
													echo '<tr>';
													echo '<td align="center">'.$j.'</td>';
													echo '<td align="center">'.$data_name['name'].'<input type="hidden" name="enrollid_'.$course_batch_id.'_'.$j.'" value="'.$enroll_id.'"></td>';
													echo '<td align="center">'.$data_topic_name['course_name'].'<input type="hidden" name="courseid_'.$course_batch_id.'_'.$j.'" value="'.$data_topic_name['course_id'].'"></td>'; 
													
													echo '<td>';
													$select_installments="SELECT * FROM installment where enroll_id ='".$val_record['enroll_id']."' ".$installment_from_date." ";
													$ptr_installment= mysql_query($select_installments);
													if($tot_insts=mysql_num_rows($ptr_installment))
													{
														$is=1;
														while($data_installment=mysql_fetch_array($ptr_installment))
														{
															$col_paid ='<font color="red">';
															/*if($data_installment['status'] =='not paid')
																$col_paid ='<font color="#FF3333">';*/
															/*if($data_installment['installment_date'] < date("Y-m-d"))
															{
																//$past_rec='<img src="images/overdue.gif" width="60" height="15" >';
																$col_paid ='<font color="#FF3333">';
															}
															else
																$past_rec='';*/
															echo $col_paid.$data_installment['installment_amount']." - ".$data_installment['installment_date']."</font><br/>";															$is++;
														}
														//if($tot_insts != $is) echo '<hr />'; else	echo '';
													}
													echo '</td>';
													
													echo '<td align="center">';?>
													<input type="radio" checked="checked" class="minimal" name="attendence_<?php echo $course_batch_id.'_'.$j ; ?>" value="present" <?php if($data_logsheet['attendence'] =="present") echo 'checked="checked"' ;?>> P &nbsp;&nbsp;<input type="radio" class="minimal-red" name="attendence_<?php echo $course_batch_id.'_'.$j ; ?>" value="absent" <?php if($data_logsheet['attendence'] =="absent") echo 'checked="checked"' ?>> A <br />
													
													<?php
													echo'</td>';
													$chek='';
													if($data_logsheet['uniform']=='no')
													{
														$chek='checked="checked"';
														
													}
													echo '<td align="center">';
													echo '<input type="checkbox" '.$chek.' class="minimal-red" id="uniform_'.$course_batch_id.'_'.$j.'" name="uniform_'.$course_batch_id.'_'.$j.'" value="no" />';
													echo '</td>';
														 
													$chekLate='';
													if($data_logsheet['latemark']=='no')
													{
														$chekLate='checked="checked"';
													}
													
													echo '<td align="center">';
													echo '<input type="checkbox" '.$chekLate.' class="minimal-red" id="latemark_'.$course_batch_id.'_'.$j.'" name="latemark_'.$course_batch_id.'_'.$j.'" value="no" />';
													echo '</td>';
													
													$chekMob='';
													if($data_logsheet['mobile_submit']=='no')
													{
														$chekMob='checked="checked"';
													}
													echo '<td align="center">';
													echo '<input type="checkbox" '.$chekMob.' id="mobile_'.$course_batch_id.'_'.$j.'" class="minimal-red" name="mobile_'.$course_batch_id.'_'.$j.'" value="no" />';
													echo '</td>';
													
													echo '<td align="center">';
													echo '<select class="form-control select2" name="sms_'.$course_batch_id.'_'.$j.'">';
													?>
													<option value="">Select option</option>
													<option value="yes"<?php if($data_logsheet["sms_send"] =="yes") echo 'selected="selected"' ?> >Yes</option>
													<option value="no" <?php if($data_logsheet["sms_send"] =="no") echo 'selected="selected"' ?>>No</option>
													</select>
													<?php
													echo'</td>';
													echo '</tr>';									
												   $j++;
												}
												if($data_chk=='yes')
												{
													?>
													<tr>
														<td colspan="10" align="right"><input type="button" class=".btn btn-success" name="save_changes_<?php echo $cat_id;?>"  id="save_changes_<?php echo $cat_id;?>" value="Attendence Completed" disabled /></td>
													</tr>
													<!--<input type="hidden" name="total_student"  id="total_student" value="<?php //echo ($j-1); ?>" />-->
													</table>
													<?php
												}
												else
												{
													?>
													<tr>
														<td colspan="10" align="right"><input type="radio" class="flat-red" name="agree" id="agree" value="<?php echo $course_batch_id; ?>" > <span style="font-size:16px"> &nbsp;&nbsp;&nbsp; I agreee  </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class=".btn btn-success" name="save_changes_<?php echo $cat_id;?>"  id="save_changes_<?php echo $cat_id;?>" value="Save" /> </td>
													</tr>
													<!--<input type="hidden" name="total_student"  id="total_student" value="<?php //echo ($j-1); ?>" />-->
													</table>
													<?php
												}
											}
										}
										else
										{
											?>
                                            <table class="table table-hover">
												<tr bgcolor="#F7F7F7">
												  <th colspan="6" align="center">Today Is Holiday For this Batch..!</th>
                                                </tr>
                                            </table>
                                            <?php
										}
										?>
										</div>
									<!-- /.box-body -->
									</div>
								</div>
								<!-- /.box-body -->
							  </div>
							  <!-- /.box -->
							</div>
							<?php
							$it++;
						}
						?>
						</form>
						<?php
					}
					?>
					<!-- /.col -->
				</div>
				<?php
			}
		}
		?>
    </section>
</div>
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="bower_components/raphael/raphael.min.js"></script>
<script src="bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>


<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- iCheck 1.0.1 -->
<script src="plugins/iCheck/icheck.min.js"></script>

<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
   
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

  })
</script>
</body>
</html>