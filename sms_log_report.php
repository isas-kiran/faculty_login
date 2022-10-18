<?php ini_set(max_execution_time,1000);
 include 'inc_classes.php';?>
<?php
$no_of_stats = 0;
if($_SESSION['NDEPART'] !='')
{
	$NDEPART= $_SESSION['NDEPART'];
	$sel_disnct_station2 = " AND NDEPART in ('".implode("','",$NDEPART)."') ";

}
$select_state = "select state_id,NOM_DEPART,NDEPART from departement where 1 $sel_disnct_station2 order by NOM_DEPART asc";
$ptr_state = mysql_query($select_state);                    
$no_of_stats = mysql_num_rows($ptr_state);
$select_mesure = "select CCHIM, NOPOL from nom_mesure  order by CCHIM ASC";
$ptr_mesure = mysql_query($select_mesure);
$no_of_parameters = 0;
$no_of_parameters = mysql_num_rows($ptr_mesure);
?>
<?php //include "admin_authentication.php";?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml"><head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>SMS Report</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />

<?php include "include/headHeader.php";?>

<?php include "include/functions.php"; ?>

<?php include "include/ps_pagination.php"; ?>

 	<link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <link type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="multifilter/demos/assets/prettify.css" />
    

    
  
   <style>
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        /*width: 800px;*/
        margin: 0 auto;
    }
 
    th input {
        width: 90%;
    }
	
	 tfoot input
	  {
		width: 100%;
		padding: 3px;
		box-sizing: border-box;
      }
   
	
	tfoot {display: table-header-group;}
	.table-wrapper{
		position:relative;
		max-height:1000px;
		overflow-y:hidden;
	}
	.dataTables_filter { visibility: hidden;}
	
	/* Let's get this party started */
::-webkit-scrollbar {
    width: 12px;
}
 
/* Track */
::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
    -webkit-border-radius: 10px;
    border-radius: 10px;
}
 
/* Handle */
::-webkit-scrollbar-thumb {
    -webkit-border-radius: 10px;
    border-radius: 10px;
    background: #90C8FF; 
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5); 
}
::-webkit-scrollbar-thumb:window-inactive {
	background: rgba(255,0,0,0.4); 
}

    </style>
  
<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="datatable/css/fixedColumns.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="datatable/css/buttons.dataTables.min.css">
  
   <script type="text/javascript" charset="utf8" src="datatable/js/jquery-1.11.3.min.js"></script>
  
   <script type="text/javascript" charset="utf8" src="js/jquery-1.12.4.js"></script>
   <script type="text/javascript" charset="utf8" src="datatable/js/jquery.dataTables.min.js"></script>
   <script type="text/javascript" charset="utf8" src="datatable/js/dataTables.fixedColumns.min.js"></script>
   
    
    <script type="text/javascript" charset="utf8" src="datatable/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="datatable/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="datatable/js/buttons.flash.min.js"></script>
    <script type="text/javascript" charset="utf8" src="datatable/js/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8" src="datatable/js/vfs_fonts.js"></script>
    <!--<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>-->
     <!--<script type="text/javascript" charset="utf8" src="datatable/js/buttons.print.min.js"></script>-->
     
     <!--<script type="text/javascript">
  jQuery(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example tfoot th').each( function (i) {
        var title = $('#example thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="'+title+'" data-index="'+i+'" />' );
    } );
	
	//var table = $('#example').DataTable({'scrollX':true, 'dom': 'lBfrtip','buttons': ['csv']});
	
	//var table = $('#example').DataTable( {'buttons': ['excel']} );
	
	var table = $('#example').DataTable( {
        dom: 'lBfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
	
	
  
    // DataTable
    var table = $('#example').DataTable( {
        scrollY:        "300px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        fixedColumns:   true
    } );
 
    // Filter event handler
    $( table.table().container() ).on( 'keyup', 'tfoot input', function () {
        table
            .column( $(this).data('index') )
            .search( this.value )
            .draw();
    } );
	
} );
 </script>-->
</head>

<body>

<?php include "include/header.php"; ?>

<!--info start-->

<div id="info">

<!--left start-->



<!--left end-->

<!--right start-->

<div id=""> <!--right_info-->

<table border="0" cellspacing="0" cellpadding="0" width="100%">

  <tr>

    <td class="top_left"></td>

    <td class="top_mid" valign="bottom"><?php include "include/cpcb_menu.php";?></td>

    <td class="top_right"></td>

  </tr>

   
  <tr>

    <td class="mid_left"></td>

    <td class="mid_mid" align="center">
    
    <div>
    <div  style="width:1250px;"><br /><br />
                <fieldset  style="text-align:left">
                    <legend > <span style="border:#F03;color:#FFFFFF; background-color:#90C748; font-size:16px; padding:5px"> Report Configuration</span> </legend>
                    <form  method="post" name="search" >
                    
                        <table width="100%;" cellpadding="0" cellspacing="0" class="table"  style="border:0 !important;margin-left:0px !important" border="0" align="left">
                            <tr>
                                 <td>From Date:</td><td><input type="text" class="for_date datepicker" name="start_date" id="start_date"  placeholder='select from date' style=""></input></td><td>To Date :</td><td><input type="text" class="for_date datepicker" name="end_date" id="end_date" placeholder='select to date' ></input></td>
                            </tr>
                            <tr>
                             
                           
                            </tr>
                            <tr>
                             
                                 
                                
                                </tr>
                               
                                <tr >
                                <td colspan="8" align="center">
                                
                                <table><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="set_report_type('industry_wise')" name="search" value="Search" class="input_btn" /><input type="hidden" name="report_type" id="report_type" value="" /></td></tr>
                                </table></td>
                            </tr>
                        </table>
                        
                       
                        
                    </form>
                    </fieldset>
                </div>
                
    <!--<form  method="post" name="search">
                        <table width="1100px;" cellpadding="0" cellspacing="0" class="table" style="border:0 !important;margin-left:0px !important" border="0">
                            <tr>
                                <td width="20%">
                                    <select  multiple="multiple" name="state_id[]" id="state_id" size="5" class="input_select" style="height:90px; width: 130px;" onchange="display_city(this.value);">
                                        <?php
                                       // $i = 0;
                                        /*while ($data_state = mysql_fetch_array($ptr_state)) 
                                        {
                                            $found = 'no';
                                            $state_idss = $_REQUEST['state_id'];
                                            if ($state_idss != '') 
                                            {
                                                if (count($state_idss)) 
                                                {
                                                    for ($z = 0; $z < count($state_idss); $z++) 
                                                    {
                                                        if ($state_idss[$z] == $data_state['NDEPART']) 
                                                        {
                                                            $found = 'yes';
                                                            break;
                                                        }
                                                    }
                                                }
                                                if ($found == 'yes')
                                                    $class = 'selected="selected"';
                                                else
                                                    $class = '';
                                            }
                                            echo '<option ' . $class . ' value="' . $data_state['NDEPART'] . '" $class >' . $data_state['NOM_DEPART'] . '</option>';
                                            $i++;
                                        }*/
                                        ?>
                                    </select>
                                </td>
                                <td width="20%"><span id="city_data"></span></td>
                                <td width="20%"><span id="industry_data"></span></td>
                                <td width="20%"><span id="industry_data_name"></span></td>
                                <td width="20%"><span id="location_data_name"></span></td>
                            </tr>
                            <tr>
                                <td width="20%"><span id="parameter"><?php
                                    /*echo '<select multiple="multiple" name="parameter_id[]" id="parameter_id" class="input_select" style="height:90px; width:130px;">';
                                    $s = 0;
                                    while ($data_mesure = mysql_fetch_array($ptr_mesure)) 
                                    {
                                        $found = 'no';
                                        $parameter_ids = $_REQUEST['parameter_id'];
                                        if ($parameter_ids != '') 
                                        {
                                            if (count($parameter_ids)) 
                                            {
                                                for ($z = 0; $z < count($parameter_ids); $z++) 
                                                {
                                                    if ($state_idss[$z] == $data_mesure['NOPOL']) 
                                                    {
                                                        $found = 'yes';
                                                        break;
                                                    }
                                                }
                                            }
                                            if ($found == 'yes')
                                                $class = 'selected="selected"';
                                            else
                                                $class = '';
                                        }
                                        echo '<option ' . $class . ' value="' . $data_mesure['NOPOL'] . '" >' . $data_mesure['CCHIM'] . '(' . $data_mesure['NOPOL'] . ')' . '</option>';
                                        $s++;
                                    }*/
                                    ?>
                                    </span>
                                </td>
                                
                                <td>
                                    <select name="origin[]" id="origin" multiple="multiple" class="input_select" style="height:90px; width:130px;">
                                     
                                      <option value="M">Ambient</option>
                                      <option value="E">Effluent</option>
                                      <option value="S">Emmision</option>
                                    </select>
                                    
                                       
                                    
                                </td>
                                
                               
                                <td><input type="button" onclick="set_report_type('')" name="search" value="Filter" class="input_btn" /></td>
                                <td><input type="button" onclick="set_report_type('industry_wise')" name="search" value="Industry Wise" class="input_btn" /><input type="hidden" name="report_type" id="report_type" value="" /></td>
                            </tr>
                        </table>
                    </form>-->
                    
                    </div>
                    
                

      <!--<table id="example" class="stripe row-border order-column display nowrap table table-condensed table-hover" width="100%" cellspacing="0">-->
        <!--<thead>
            <tr>
                <th style="color:red">SR. No.</th>
                <th style="color:red">NSIT</th>
                <th style="color:red">City</th>
                <th style="color:red">State</th>
                <th style="color:red">Industry name</th>
                <th style="color:red"> Station</th>
                <th style="color:red">Parameter</th>
                <th style="color:red">Category</th>
                <th style="color:red">Origin (for search: Emission-S / Ambient-M / Effluent-E)</th>
                <th style="color:red">Origins (for color search: G/O/R/Y)</th>
                <th style="color:red">Creation Date</th>
                <th style="color:red">Last Data Acquisition</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>SR. No.</th>
                <th>NSIT</th>
                <th>City</th>
                <th>State</th>
                <th>Industry name</th>
                <th>Station</th>
                <th>Parameter</th>
                <th>Category</th>
                <th>Origin(for search: S/M/E)</th>
                <th>Origins(for color search: G/O/R/Y)</th>
                <th>Creation Date</th>
                <th>Last Data Acquisition</th>
            </tr>
        </tfoot>-->
        <?php
		
		  
		
		/*$sel_disnct_station = "	
	SELECT mesure.nsit,mesure.TYPE_INSTAL,mesure.ORIGINE,mesure.NOPOL,station.isit_long,station.IDENTIFIANT,station.DATE_DEB_SCRUT,commune.nom_commune,departement.nom_depart,MAX(mesure.dernier_qh) AS dernier_qh FROM mesure,station,commune,departement where station.nsit=mesure.nsit and station.ndepart=departement.ndepart AND station.ninsee=COMMUNE.ninsee GROUP BY mesure.nsit,station.isit_long,commune.nom_commune,departement.nom_depart,mesure.TYPE_INSTAL, mesure.dernier_qh order by departement.nom_depart asc ,commune.nom_commune asc ";*/
		
		
		
		///========= FOR SESSION START =============
 
 /*if($_SESSION['NDEPART'] !='')
{
	//echo print_r($_SESSION['NDEPART']);
	$NDEPART= $_SESSION['NDEPART'];
$sel_disnct_station2 = " AND departement.NDEPART in ('".implode("','",$NDEPART)."') ";

}
 
 if($_SESSION['NINSEE'] !='')
{
$NINSEE= $_SESSION['NINSEE'];
$sel_disnct_NINSEE = " AND commune.NINSEE in ('".implode("','",$NINSEE)."') ";
}

if($_SESSION['TYPE_INSTAL'] !='')
{
$TYPE_INSTAL= $_SESSION['TYPE_INSTAL'];
$sel_disnct_TYPE_INSTAL = " AND mesure.TYPE_INSTAL in ('".implode("','",$TYPE_INSTAL)."') ";
}

if($_SESSION['AXE'] !='')
{
$AXE= $_SESSION['AXE'];
$sel_disnct_TYPE_AXE = " AND station.AXE in ('".implode("','",$AXE)."') ";
}*/

		
	 /*$sel_disnct_station = "SELECT mesure.NOM_COURT_MES, mesure.IDENTIFIANT, mesure.NOPOL, mesure.CMET, mesure.NSIT, mesure.ORIGINE, mesure.TYPE_INSTAL, mesure.GEST_SOURCE from mesure, station, departement, commune  where mesure.NSIT=station.NSIT and station.ndepart=departement.ndepart and station.NINSEE=COMMUNE.NINSEE $sel_disnct_station2 $sel_disnct_NINSEE  $sel_disnct_TYPE_INSTAL $sel_disnct_TYPE_AXE  ";
	 $mysq_qry = mysql_query($sel_disnct_station);*/
	?>
    <br clear="all" />
                <div  id="table_listing" style="width:1500px;">
               		<?php include_once 'sms-summary_report.php'; ?>
                
                </div>
        <!--<tbody>
        <?php
		/*$s=1;
		$t=0;
		while($station_id_data = mysql_fetch_array($mysq_qry))
		{
			$sel_max_dernier_qh="select MAX(dernier_qh) AS dernier_qh FROM mesure where NOM_COURT_MES='".$station_id_data['NOM_COURT_MES']."'";
			$que_max_dernier=mysql_query($sel_max_dernier_qh);
			$fetch_max_dernier=mysql_fetch_array($que_max_dernier);
			
			$station_data="select ISIT_LONG, IDENTIFIANT, DATE_DEB_SCRUT, NSIT, NDEPART, NINSEE, AXE from station where NSIT='".$station_id_data['NSIT']."'";
			$query_station_data=mysql_query($station_data);
			$fetch_station_data=mysql_fetch_array($query_station_data);
			
			$select_state="select NDEPART, NOM_DEPART from departement where NDEPART='".$fetch_station_data['NDEPART']."'";
			$fetch_states = mysql_fetch_array(mysql_query($select_state));
			
			$select_city="select NDEPART, NINSEE, NOM_COMMUNE from commune where NINSEE='".$fetch_station_data['NINSEE']."'";
			$fetch_city = mysql_fetch_array(mysql_query($select_city));
			
			$select_parameter = " select  NOPOL, CCHIM from nom_mesure where NOPOL='".$station_id_data['NOPOL']."' ";
			$ptr_parameter = mysql_query($select_parameter);
			$data_parameter = mysql_fetch_array($ptr_parameter);
			
			
			 $date2 = strtotime($fetch_max_dernier['dernier_qh']);
			//echo $now.'='.$date2."<br>";
			$station_arry[$t]['update_on'] = date("j-M-Y g:i a", $date2);
			$date_diff = $now - ($date2);
			//echo $date_diff."<br>";
			if ($date_diff <= 3600)
				$station_arry[$t]['tim'] = 'G';
			else
			if ($date_diff <= 14400 && $date_diff > 3600) //= 1 hr to 4 hr
				$station_arry[$t]['tim'] = 'Y';
			else
			if ($date_diff > 14400 && $date_diff < 1296000) //=== 15 days
				$station_arry[$t]['tim'] = 'O';
			else
				$station_arry[$t]['tim'] = 'R';
				
				
				$date2 = strtotime($fetch_max_dernier['dernier_qh']);
                $fetch_max_dernier['dernier_qh'] = date("j-M-Y g:i a", $date2);
			
			echo '<tr>';
			echo '<td>'.$s.'</td>';
			echo '<td>'.$station_id_data['NSIT'].'</td>';
			echo '<td>'.$fetch_city['NOM_COMMUNE'].'</td>';
			echo '<td>'.$fetch_states['NOM_DEPART'].'</td>';
			
			echo '<td>'.$fetch_station_data['AXE'].'</td>';
			echo '<td>'.$fetch_station_data['IDENTIFIANT'].'</td>';
			echo '<td>'.$data_parameter['CCHIM'].' ( '.$station_id_data['GEST_SOURCE'].' )</td>';
			echo '<td>'.$station_id_data['TYPE_INSTAL'].'</td>';
			
			echo '<td><img src="icon/'.$station_id_data['ORIGINE'].'/'.$station_arry[$t]['tim'].'.png" title="'.$station_id_data['ORIGINE'].'"><span style="display:none;">'.$station_id_data['ORIGINE'].'</span></td>';
			
			echo '<td><img src="icon/'.$station_id_data['ORIGINE'].'/'.$station_arry[$t]['tim'].'.png" title="'.$station_arry[$t]['tim'].'"><span style="display:none;">'.$station_arry[$t]['tim'].'</span></td>';
			
			echo '<td>'.$fetch_station_data['DATE_DEB_SCRUT'].'</td>';
			echo '<td>'.$fetch_max_dernier['dernier_qh'].'</td>';
			
			echo '</tr>';
			
			$s++;
			$t++;
		}*/
		?>
            
            </tbody>-->
            <!--</table> --> 

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
<script>
if(typeof jQuery == 'undefined'){
	document.write('<script type="text/javascript" src="datatable/js/jquery-1.11.1.js"></'+'script>');
}
</script>

<!----------- -->



  <link rel="stylesheet" type="text/css" href="datatable/css/fixedColumns.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="datatable/css/buttons.dataTables.min.css">
   <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
  <script type="text/javascript" charset="utf8" src="datatable/js/jquery-1.11.3.min.js"></script>
  
   <!--<script type="text/javascript" charset="utf8" src="js/jquery-1.12.4.js"></script>-->
  <script type="text/javascript" charset="utf8" src="datatable/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" charset="utf8" src="datatable/js/dataTables.fixedColumns.min.js"></script>
   
    
  <script type="text/javascript" charset="utf8" src="datatable/js/buttons.html5.min.js"></script>
  <script type="text/javascript" charset="utf8" src="datatable/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" charset="utf8" src="datatable/js/buttons.flash.min.js"></script>
  <script type="text/javascript" charset="utf8" src="datatable/js/pdfmake.min.js"></script>
  <script type="text/javascript" charset="utf8" src="datatable/js/vfs_fonts.js"></script>
    <!--<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>-->
  <script type="text/javascript" charset="utf8" src="datatable/js/buttons.print.min.js"></script>
     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
	<script type="text/javascript">
	$(document).ready(function()
		{            
				$('.datepicker').datepicker({ changeMonth: true,changeYear: true,dateFormat:"yy-mm-dd", showButtonPanel: true, closeText: 'Clear',minDate: '-50Y',maxDate: '+0m +0w',});
	
		});
  	jQuery(document).ready(function() {
    // Setup - add a text input to each footer cell
   
	
	//var table = $('#example').DataTable({'scrollX':true, 'dom': 'lBfrtip','buttons': ['csv']});
	
	//var table = $('#example').DataTable( {'buttons': ['excel']} );
	
	/*var table = $('#example').DataTable( {
        dom: 'lBfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
	
	
  
    // DataTable
    var table = $('#example').DataTable( {
        scrollY:        "300px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        fixedColumns:   true
    } );*/
	
	
} );
 </script>



<script type="text/javascript" src="multifilter/src/jquery-ui.min.js"></script>
<script type="text/javascript" src="multifilter/demos/assets/prettify.js"></script>
<script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
<script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
<script type="text/javascript">

		jQuery(document).ready( function() 
        {
			 //$("#state_id").multiselect(); 
           $("#state_id").multiselect({noneSelectedText: "Select States(<?php echo $no_of_stats;?>)"}).multiselectfilter();
           $("#origin").multiselect({noneSelectedText: "Select Type of Pollutant(2)"}).multiselectfilter();
		   
		   $("#city_id").multiselect({noneSelectedText: "Select Cities"}).multiselectfilter();
		   $("#industry_id").multiselect({noneSelectedText: "Select Cities First"}).multiselectfilter();
		   $("#industry_name_id").multiselect({noneSelectedText: "Select Category First"}).multiselectfilter();
		   $("#location_id").multiselect({noneSelectedText: "Select Industries First"}).multiselectfilter();
		    $("#parameter_id").multiselect({noneSelectedText: "Select Parameters"}).multiselectfilter();
		   
		   
           
        });
		
        function filter_data()
        {
			//alert('hi')
			$("#table_listing").html('<table align="center"><tr><td><img src="images/ajaxLoading.gif"></td></tr></table>');
           
		   /*
		    var state_id = $("#state_id").val();
            if(state_id==undefined || state_id=='')
                state_id = '';
            
            var city_id = $("#city_id").val();
            if(city_id==undefined || city_id=='')
                city_id = '';
            
            var industry_id = '';
            $('#industry_id :selected').each(function(){
                industry_id += "&industry_id[]=" + encodeURIComponent($(this).val()); 
            });
            
            var industry_name_id = '';
            $('#industry_name_id :selected').each(function(){
                industry_name_id += "&industry_name_id[]=" + encodeURIComponent($(this).val()); 
            });
            //alert(industry_name_id);
            var location_id = '';
             $('#location_id :selected').each(function(){
                location_id += "&location_id[]=" + encodeURIComponent($(this).val()); 
            });
				//alert(location_id)
            
			 var parameter_id = '';
             $('#parameter_id :selected').each(function(){
                parameter_id += "&parameter_id[]=" + encodeURIComponent($(this).val()); 
            });
			
            
			var origin = $("#origin").val();
            if(origin==undefined || origin=='')
                origin = '';
			*/	
				//alert(origin)
            
            var start_date = $("#start_date").val();
            if(start_date==undefined || start_date=='')
                start_date = '';
            
            var end_date = $("#end_date").val();
            if(end_date==undefined || end_date=='')
                end_date = '';
            
            var report_type = $("#report_type").val();
            if(report_type==undefined || report_type=='')
                report_type = '';
			
            var data_parameter="is_ajax_call=1&start_date="+start_date+"&end_date="+end_date+"&report_type="+report_type;
          // alert(data_parameter);
            $.ajax({
		url:"sms-summary_report.php", type:"post",data:data_parameter, cache:false,
		success: function(html)
		{
			//alert(html);
			
			
                    $("#table_listing").html(html);
					document.title= document.getElementById('title_td').innerHTML;
					/*$('#example tfoot th').each( function (i) {
							var title = $('#example thead th').eq( $(this).index() ).text();
							$(this).html( '<input type="text"  data-index="'+i+'" />' );
					} );
					initDataTable();*/
					 /*$("#city_id").multiselect({noneSelectedText: "Select Cities"}).multiselectfilter();
					 $("#industry_name_id").multiselect({noneSelectedText: "Select Industries"}).multiselectfilter();
					 $("#location_id").multiselect({noneSelectedText: "Select Stations"}).multiselectfilter();
					 $("#parameter").multiselect({noneSelectedText: "Select Parameters"}).multiselectfilter();*/
					 
                }
            });
        }

        function display_city()
        {
            var state_id = $("#state_id").val();
            if(state_id==undefined || state_id=='')
                state_id = '';
            var data="show_city=1&state_id="+state_id;
            $.ajax({
                    url:"show_city_reports.php", type:"post", data:data, cache:false,
                    success: function(city_data)
                    {
                        if(city_data !='')
                        {
                            var dta = city_data.split('####');
                            document.getElementById("city_data").innerHTML=dta[0];
                            $("#city_id").multiselect({noneSelectedText: "Select Cities("+dta[1]+")"}).multiselectfilter();
                            document.getElementById("industry_data").innerHTML='';
                            document.getElementById("industry_data_name").innerHTML='';
                            document.getElementById("location_data_name").innerHTML='';
							document.getElementById("paramter").innerHTML='';
							
                        }
                    }
            });
        }
        
        function display_industry()
        {
            var city_id = $("#city_id").val();
            if(city_id==undefined || city_id=='')
                city_id = '';
            var states_array = '';
            $('#state_id :selected').each(function(){
                states_array += "&states_array[]=" + encodeURIComponent($(this).val()); 
            });
            var data_city="city_id="+city_id+"&states_array="+states_array;
            $.ajax({
                    url:"show_industry_reports.php", type:"post", data:data_city, cache:false,
                    success: function(industry_data)
                    {
                        if(industry_data !='')
                        {
                            var dta = industry_data.split('####');
                            document.getElementById("industry_data").innerHTML=dta[0];
                            $("#industry_id").multiselect({noneSelectedText: "Select Categories("+dta[1]+")"}).multiselectfilter();
                            document.getElementById("industry_data_name").innerHTML='';
                            document.getElementById("location_data_name").innerHTML='';	
							 document.getElementById("paramter").innerHTML='';
                        }
                    }
            });
        }

        function display_industry_name()
        {
            var d='';
            var b=document.getElementById("city_id");
            for (var i = 0; i < b.options.length; i++) 
            {
                if(b.options[i].selected ==true)
                {
                    d+=b.options[i].value;
                    d+=",";
                }
            }
            
            var industry_id = '';
            $('#industry_id :selected').each(function(){
                industry_id += "&industry_id[]=" + encodeURIComponent($(this).val()); 
            });
            var states_array = '';
            $('#state_id :selected').each(function(){
                states_array += "&states_array[]=" + encodeURIComponent($(this).val()); 
            });
            var nsit = document.getElementById('nsit_array').value;
            var data_industry="industry_id="+industry_id+"&nsit="+nsit+"&states_array="+states_array;
            //var data_industry="industry_id="+industry_id+"&nsit="+nsit;
            $.ajax({
		url:"show_industry_name_reports.php", type:"post", data:data_industry, cache:false,
		success: function(industry_data_name)
		{
                    if(industry_data_name !='')
                    {
                        var dta = industry_data_name.split('####');
                        document.getElementById("industry_data_name").innerHTML=dta[0];
                        $("#industry_name_id").multiselect({noneSelectedText: "Select Industries("+dta[1]+")"}).multiselectfilter();
                        document.getElementById("location_data_name").innerHTML='';
                    }
		}
            });
        }

        function display_location()
        {
            nsit = document.getElementById('nsit_array').value;
            var industry_name_id = '';
            $('#industry_name_id :selected').each(function(){
                industry_name_id += "&industry_name_id[]=" + encodeURIComponent($(this).val()); 
            });
            var states_array = '';
            $('#state_id :selected').each(function(){
                states_array += "&states_array[]=" + encodeURIComponent($(this).val()); 
            });
            var industry_id = '';
            $('#industry_id :selected').each(function(){
                industry_id += "&industry_id[]=" + encodeURIComponent($(this).val()); 
            });
            var data_industry="industry_id="+industry_id+"&nsit="+nsit+"&states_array="+states_array+"&industry_name_id="+industry_name_id;
            var data_parameter=data_industry;
            $.ajax({
		url:"show_location_reports.php", type:"post", data:data_parameter, cache:false,
		success: function(data_parameter)
		{
			//alert(data_parameter)
                    if(data_parameter !='')
                    {
                        var dta = data_parameter.split('####');
                        document.getElementById("location_data_name").innerHTML=dta[0];
                        $("#location_id").multiselect({noneSelectedText: "Select Stations("+dta[1]+")"}).multiselectfilter();
						 $("#paramter").html('<table align="center"><tr><td><img src="images/ajaxLoading.gif"></td></tr></table>');
						display_parameter();
                    }
		}
            });
        }
        function display_parameter()
        {
          // alert('hi');
		   $("#paramter").html('<table align="center"><tr><td><img src="images/ajaxLoading.gif"></td></tr></table>');
            var location_id = '';
            $('#location_id :selected').each(function(){
                location_id += "&location_id[]=" + encodeURIComponent($(this).val()); 
            });
            var data_parameter=location_id;
			
            $.ajax({
                    url:"show_parameter_reports.php", type:"post", data:data_parameter, cache:false,
                    success: function(data_parameter)
                    {
                        if(data_parameter !='')
                        {
                            var dta = data_parameter.split('####');
							
							document.getElementById("paramter").innerHTML=dta[0];
                            $("#parameter_id").multiselect({noneSelectedText: "Select Parameters("+dta[1]+")"}).multiselectfilter();
                        }
                    }
            });
        }
		
		function set_report_type(typ)
		{
			start_date = document.getElementById("start_date").value;
			end_date = document.getElementById("end_date").value;
			errors ='Correct The Following Errors:\n\n';
			found_error = 'no';
		
			if(start_date=='')
			{
				errors +="Start Date Not Selected\n";
				//$("#report_type_span").addClass("error");	
				found_error='yes';			
			}
			if(end_date=='')
			{
				errors +="End Date Not Selected\n";
				//$("#report_type_span").addClass("error");	
				found_error='yes';			
			}
			/*if(start_date !='' && end_date !='')
			{
				var date1 = moment(start_date ,'YYYY-MM-DD');
				var date2 = moment(end_date  ,'YYYY-MM-DD');
				var diffDays  = date2.diff(date1, 'days'); 
				alert(diffDays);
				if(diffDays<1)
				{
					errors +="End Date should not be equal or lesser than From date\n";
					found_error='yes';
					
				 }	
			}*/
		

			if(found_error=='yes')
			{
				alert(errors);
				return false;
			}
		else
		{
			//alert('hi');
			document.getElementById('report_type').value=typ;
			filter_data();
		}
		}
		//set_report_type('industry_wise');
    </script>
</div>

<!--footer end-->

</body>

</html>

