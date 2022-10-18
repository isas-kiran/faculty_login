<?php include 'inc_classes.php'; 
include "admin_authentication.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Loans & Request</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/iCheck/all.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
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
        Expenses
        <!--<small>Version 2.0</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
	<?php
	if(isset($_POST['submit']))
	{
		$request_for=$_POST['request_for'];
		$description=$_POST['description'];
		$amount=$_POST['amount'];
		$no_of_term=$_POST['no_of_term'];
		$date=$_POST['date'];
		$request_to=$_POST['request_to'];
		$admin_id =$_SESSION['admin_id'];
		
		$insert_salary="insert into pr_loan_advance (`request_for`,`amount`,`description`,`no_of_term`,`request_date`,`request_to`,`status`,`admin_id`,`cm_id`,`added_date`) values('".$request_for."','".$amount."','".$description."','".$date."','".$request_to."','Pending','".$admin_id."','".$_SESSION['cm_id']."','".date('Y-m-d H:i:s')."')";
		$ptr_ins=mysql_query($insert_salary);
	}
	?>
    <!-- Main content -->
    <section class="content">
      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <!--<div class="box-header with-border">
          <h3 class="box-title">Select2</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>-->
        <!-- /.box-header -->
        <form name="loan_form" method="post" >
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Request For</label>
                <select class="form-control select2" name="request_for" id="request_for" style="width: 100%;">
                  <option selected="selected">Select Type</option>
                  <option>Salary Advance</option>
                  <option>Loan</option>
                  <option>Other</option>
                </select>
              </div>
              <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" name="description" id="description" rows="4" placeholder="Enter ..."></textarea>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-6">
              <div class="form-group">
                  <label>Amount</label>
                  <input type="text" class="form-control" name="amount" id="amount" placeholder="Enter Amount">
              </div>
              <div class="form-group">
                  <label>No. Of Terms</label>
                  <input type="text" class="form-control" name="no_of_term" id="no_of_term" placeholder="Enter No. of Installment">
              </div>
              <div class="form-group">
                <label>Date</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="date" id="datepicker">
                </div>
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>Request To</label>
                <select class="form-control select2" name="request_to" id="request_to" style="width: 100%;">
                  <option selected="selected">Select Name</option>
                  <?php
				  $sel_staff="select name,admin_id from site_setting where 1 and system_status='Enabled' and (type='S' or type='A' or type='Z' or type='LD')";
				  $ptr_Staff=mysql_query($sel_staff);
				  while($date_staff=mysql_fetch_array($ptr_Staff))
				  {
					  echo '<option value="'.$date_staff['admin_id'].'">'.$date_staff['name'].'</option>';
				  }
				  ?>
                </select>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-12">
            	<input type="submit" name="submit" id="submit" value="Submit" class="btn btn-block btn-success">
            </div>
          </div>
          <!-- /.row -->
        </div>
        </form>
        <!-- /.box-body -->
        <!--<div class="box-footer">
          Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
          the plugin.
        </div>-->
      </div>
      <!-- /.box -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-12">
          <!-- TABLE: LATEST ORDERS -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Outstandings</h3>

              <!--<div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>-->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Sr. No.</th>
                    <th>Request For</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>No of Term</th>
                    <th>Request Date</th>
                    <th>Request To</th>
                    <th>Status</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
				  $sel_app="select * from pr_loan_advance where 1 and cm_id='".$_SESSION['cm_id']."' and admin_id='".$_SESSION['admin_id']."'";
				  $ptr_app=mysql_query($sel_app);
				  $t=1;
				  while($data_app=mysql_fetch_array($ptr_app))
				  {
					  $sel_staff="select name from site_setting where 1 and admin_id='".$data_app['request_to']."'";
					  $ptr_staff=mysql_query($sel_staff);
					  $data_staff=mysql_fetch_array($ptr_staff);
					  ?>
                      <tr>
                        <td><?php echo $t; ?></td>
                        <td><?php echo $data_app['request_for']; ?></td>
                        <td><?php echo $data_app['amount']; ?></td>
                        <td><?php echo $data_app['description']; ?></td>
                        <td><?php echo $data_app['no_of_term']; ?></td>
                        <td><?php echo $data_app['request_date']; ?></td>
                        <td><?php echo $data_staff['name']; ?></td>
                        <td><span class="label label-warning"><?php echo $data_app['status']; ?></span></td>
                      </tr>
                      <?php
					  $t++;
				  }
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
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

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

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>
</body>
</html>