<?php include 'inc_classes.php'; 
include "admin_authentication.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>My Notes</title>
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
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <?php include "include/header-main.php"; ?>
  <!-- Left side column. contains the logo and sidebar -->
  <?php include "include/menu_left.php"; ?>
  <!-- Content Wrapper. Contains page content -->
    <!-- Left side column. contains the logo and sidebar -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Notes Details
        <!--<small>Version 2.0</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <div class="col-md-12" style="display:none">
          <div class="box">
            <!--<div class="box-header with-border">
              <h3 class="box-title">Monthly Recap Report</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>-->
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row" >
                <div class="col-md-8">
                  <p class="text-center">
                    <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>
                  </p>

                  <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <canvas id="salesChart" style="height: 180px;"></canvas>
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
                
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
      
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- Main row -->
      <?php
	  $sel_app="select * from enrollment where 1 and enroll_id='".$_SESSION['enroll_id']."' or ref_id='".$_SESSION['enroll_id']."'";
	  $ptr_app=mysql_query($sel_app);
	  $t=1;
	  while($data_app=mysql_fetch_array($ptr_app))
	  {
		  $select_course="select * from courses where course_id='".$data_app['course_id']."'";
		  $ptr_course=mysql_query($select_course);
		  $data_course_n=mysql_fetch_array($ptr_course);
		  
		  $sel_staff="select name from site_setting where 1 and admin_id='".$data_app['assigned_to']."'";
		  $ptr_staff=mysql_query($sel_staff);
		  $data_staff=mysql_fetch_array($ptr_staff);
		  ?>
		  <div class="row">
			<!-- Left col -->
			<div class="col-md-12">
			  <!-- TABLE: LATEST ORDERS -->
			  <div class="box box-info box-success collapsed-box">
				<div class="box-header with-border">
				  <h3 class="box-title"><?php echo $data_course_n['course_name']; ?></h3>
				  <div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<!--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
				  </div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
				  <div class="table-responsive">
					<table class="table no-margin">
					  <thead>
					  <tr>
						<th>Sr. No.</th>
						<th>Course Name</th>
                        <th>File Name</th>
						<th>View / Download</th>
					  </tr>
					  </thead>
					  <tbody>
						<?php
						$select_course_p= "select * from courses where course_id='".$data_course_n['course_id']."' ";
						$val_course=mysql_query($select_course_p);
						$data_course_p=mysql_fetch_array();
						$is_parent=$data_course_p['is_parent'];
						
						if($is_parent=='y')
						{
							$sel_map="SELECT * FROM courses_map WHERE course_parent_id ='".$data_course_n['course_id']."' ";
							$ptr_courses=mysql_query($sel_map);
							if($total_course=mysql_num_rows($ptr_courses))
							{
								//echo '<tr bgcolor="#d7edf9"><td colspan="4" align="center"><strong>Sr. No.</strong></td><td colspan="3" align="center"><b>Course Name</b></td><td colspan="2" align="center"><strong>Course Logsheet</strong></td><td colspan="2" align="center"><strong>Course Status</strong></td><td align="center"><strong>Is Batch Scheduled</strong></td><td align="center"><strong>Batch Start Date</strong></td></tr>';
								$c1=1;
								while($data_map=mysql_fetch_array($ptr_courses))
								{
									$sel_course="select course_name,course_id from courses where course_id='".$data_map['course_id']."'";
									$ptr_course=mysql_query($sel_course);
									$data_course=mysql_fetch_array($ptr_course);
									
									$sel_map1="SELECT * FROM courses_map WHERE course_parent_id ='".$data_map['course_id']."' ";
									$ptr_courses1=mysql_query($sel_map1);
									if($total_course=mysql_num_rows($ptr_courses1))
									{
										echo '<tr class="grey_td">
										<td align="right">'.$c1.'</td>
										<td><b>'.$data_course['course_name'].'</b></td>
										</tr>';
										
										$c2=1;
										while($data_map1=mysql_fetch_array($ptr_courses1))
										{
											$sel_course1="select course_name,course_id from courses where course_id='".$data_map1['course_id']."'";
											$ptr_course1=mysql_query($sel_course1);
											$data_course1=mysql_fetch_array($ptr_course1);
											
											echo '<tr><td colspan="4" align="right">'.$c2.'</td>
											<td><b>'.$data_course1['course_name'].'</b></td>
											<td colspan="2"><center><a href="student_logsheet.php?record_id='.$listed_record_id.'&course_id='.$data_course1['course_id'].'"><img src="images/logsheet.png" border="0" title="View Logsheet" height="25px" width="25px"></a></center></td>
											<td colspan="2" align="center">Started</td><td align="center">Yes</td>';
											$c2++;
										}
									}
									else
									{
										echo '<tr ><td colspan="2" align="right">'.$c1.'</td><td colspan="5"><b>'.$data_course['course_name'].'</b></td><td colspan="2"><center><a href="student_logsheet.php?record_id='.$listed_record_id.'&course_id='.$data_course['course_id'].'"><img src="images/logsheet.png" border="0" title="View Logsheet" height="25px" width="25px"></a></center></td><td colspan="2" align="center">Started</td><td align="center">Yes</td></tr>';
									}
									$c1++;
								}
							}
						}
						else
						{
							//echo '<tr bgcolor="#d7edf9"><td colspan="4" align="center"><strong>Sr. No.</strong></td><td colspan="3" align="center"><b>Course Name</b></td><td colspan="2" align="center"><strong>Course Logsheet</strong></td><td colspan="2" align="center"><strong>Course Status</strong></td><td align="center"><strong>Is Batch Scheduled</strong></td><td align="center"><strong>Batch Start Date</strong></td></tr>';
							
							$sel_course2="select course_name,course_id from courses where course_id='".$data_course_n['course_id']."'";
							$ptr_course2=mysql_query($sel_course2);
							$data_course2=mysql_fetch_array($ptr_course2);
							
							echo '<tr><td colspan="4" align="center">'.$it.'</td><td colspan="3" ><b>'.$data_course2['course_name'].'</b></td><td colspan="2"><center><a href="student_logsheet.php?record_id='.$listed_record_id.'&course_id='.$data_course2['course_id'].'"><img src="images/logsheet.png" border="0" title="View Logsheet" height="25px" width="25px"></a></center></td><td colspan="2" align="center">Started</td><td align="center">Yes</td></tr>';
						}
						
						
						/*$t=1;
						$sel_batch_details="select DISTINCT(batch_id) as batch_id from student_course_batch_map where 1 and enroll_id='".$_SESSION['enroll_id']."'";
						$ptr_batch_details=mysql_query($sel_batch_details);
						while($data_batch_details=mysql_fetch_array($ptr_batch_details))
						{
							$sel_batch="select * from course_batch_mapping where 1 and batch_name='".$data_batch_details['batch_id']."' and DATE(start_date) <='".date('Y-m-d')."' and DATE(end_date) >='".date('Y-m-d')."'";
							$ptr_batch=mysql_query($sel_batch);
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
								?>
								<tr>
									<td><?php echo $t; ?></td>
									<td><?php echo $data_batch['batch_name']; ?></td>
									<td><?php echo $data_course['course_name']; ?></td>
									<td><?php echo $start_date.'&nbsp;&nbsp;to&nbsp;&nbsp;'.$end_date; ?></td>
									<td><?php echo $data_time['batch_time'];?></td>
									<td><?php echo $data_staff['name']; ?></td>
								</tr>
								<?php
								$t++;
							}
						}*/
						?>
					  </tbody>
					</table>
				  </div>
				  <!-- /.table-responsive -->
				</div>
				<!-- /.box-body -->
				<div class="box-footer clearfix">
				  <!--<a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
				  <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>-->
				</div>
				<!-- /.box-footer -->
			  </div>
			  <!-- /.box -->
			</div>
			<!-- /.col -->
		  </div>
		<?php
	  }
	  ?>
      <!--<div class="row">
        <div class="col-md-4">
          <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Inventory</span>
              <span class="info-box-number">5,200</span>

              <div class="progress">
                <div class="progress-bar" style="width: 50%"></div>
              </div>
              <span class="progress-description">
                    50% Increase in 30 Days
                  </span>
            </div>
          </div>
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="ion ion-ios-heart-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Mentions</span>
              <span class="info-box-number">92,050</span>

              <div class="progress">
                <div class="progress-bar" style="width: 20%"></div>
              </div>
              <span class="progress-description">
                    20% Increase in 30 Days
                  </span>
            </div>
          </div>
          <div class="info-box bg-red">
            <span class="info-box-icon"><i class="ion ion-ios-cloud-download-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Downloads</span>
              <span class="info-box-number">114,381</span>

              <div class="progress">
                <div class="progress-bar" style="width: 70%"></div>
              </div>
              <span class="progress-description">
                    70% Increase in 30 Days
                  </span>
            </div>
          </div>
          <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="ion-ios-chatbubble-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Direct Messages</span>
              <span class="info-box-number">163,921</span>

              <div class="progress">
                <div class="progress-bar" style="width: 40%"></div>
              </div>
              <span class="progress-description">
                    40% Increase in 30 Days
                  </span>
            </div>
          </div>
          
        </div>
      </div>-->
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include "include/footer-main.php"; ?>
</div>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS -->
<script src="bower_components/chart.js/Chart.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>