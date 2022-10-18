<!doctype html><head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>Setting the Y-Axis format</title>
</head>
	<script src="dhtmlxScheduler/codebase/dhtmlxscheduler.js" type="text/javascript" charset="utf-8"></script>
	
<link rel="stylesheet" href="dhtmlxScheduler/codebase/dhtmlxscheduler.css" type="text/css" charset="utf-8">

	
<style type="text/css" >
	html, body{
		margin:0px;
		padding:0px;
		height:100%;
		overflow:hidden;
	}	
	#not_for_test{
		color:red;
		position:absolute;
		z-index:9999;
		font-size:40pt;
		top:50px; left:300px;
	}
</style>
<script type="text/javascript" charset="utf-8">
	function init() {
		
		scheduler.config.start_on_monday=false;
		scheduler.config.xml_date="%Y-%m-%d %H:%i";
		scheduler.config.hour_date="%h:%i %A";
		
		//scheduler.config.hour_size_px=25;

		scheduler.init('scheduler_here',new Date(2017,11,18),"week");
		//scheduler.load("data/events.xml");
		
		scheduler.parse([
			{ start_date: "2017-11-18 12:00", end_date: "2017-11-18 14:00", text:"Task D-12458" },
			{ start_date: "2017-11-19 12:30", end_date: "2017-11-19 15:00", text:"Task D-72348" },
            { start_date: "2017-11-18 13:30", end_date: "2017-11-18 17:00", text:"Task D-41175" },
            { start_date: "2017-11-20 16:30", end_date: "2017-11-20 20:00", text:"Task D-92431" },
		],"json");
		
	}
</script>

<body onLoad="init();">
	<div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%;'>
		<div class="dhx_cal_navline">
			<div class="dhx_cal_prev_button">&nbsp;</div>
			<div class="dhx_cal_next_button">&nbsp;</div>
			<div class="dhx_cal_today_button"></div>
			<div class="dhx_cal_date"></div>
			<div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
			<div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
			<div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
		</div>
		<div class="dhx_cal_header">
		</div>
		<div class="dhx_cal_data">
		</div>		
	</div>
</body>