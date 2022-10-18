function doClick(id,imgid) {
      var el = document.getElementById(id);
      if (el) {
		  
        el.click();
		//$("#"+imgid).attr("src","images/Open-Folder-Full.png");
      }
    }

									function create_floor()
									{
										no = $("#no_of_floor").val();
										//alert("Script-"+no)
										if(no !='' && !isNaN(no))
										{
								 	if(previous_floor==0)
									{
										
										for(i=1;i<=no;i++)
										{ l=i;
										   if(l<10)										   
										   l ="0"+l;
											
											$("#create_floor").append('<div id="floor_id'+i+'" class="floor_div"><table><tr id="floor_row'+i+'"><td>Floor '+l+' Name: </td><td><input type="text" name="floor_'+i+'" id="floor_'+i+'" value="" size="16" onblur="set_name(this.value,'+i+');" onmouseover="this.title=this.value;"><input type="hidden" name="floor_id'+i+'" id="floor_id_'+i+'" value="" /></td><td><input type="file" name="floor_img'+i+'" id="floor_img'+i+'" onchange="handleFiles(this.files,\'imgfolder'+i+'\')" class="hidden" /><img src="images/folder_blank.png" border="0" onclick=\'doClick("floor_img'+i+'","imgfolder'+i+'")\' id="imgfolder'+i+'"  style="cursor:pointer"/></td><td><input type="text" name="option_'+i+'_no" id="option_'+i+'_no" value="" onblur="option_create(this.value,'+i+');" size="2"></td></tr></table></div>');
											//$("#create_option_no_div").append('<div id="option_'+i+'_no_div"><table width="100%"><tr ><td id="option_'+i+'_name">Floor '+i+' Options: </td><td width="20%"><input type="text" name="option_'+i+'_no" id="option_'+i+'_no" value="" size="2" onkeyup="option_create(this.value,'+i+');"></td></tr></table></div>');
											
											$("#create_options").append('<table id="floor_option_draw_'+i+'"  style="float:left;min-width:360px;padding:5px;" class="tbl"><tr><td><span id="floor_option_'+i+'_name">Floor '+i+' Options List</span> <input type="hidden" name="+last_no_of_option_'+i+'" id="last_no_of_option_'+i+'" value="0" ></td></tr><tr><td id="option_row_'+i+'"></td></tr></table><table style="float:left;"><td> </td></table>')
										
									}									
									 previous_floor=no;
								}
								else
								{
									if(no>previous_floor)
									{
										next_start=parseInt(parseInt(previous_floor)+1);
										for(i=next_start;i<=no;i++)
										{
											l=i;
										   if(l<10)										   
										   l ="0"+l;
										
											$("#create_floor").append('<div id="floor_id'+i+'" class="floor_div"><table><tr id="floor_row'+i+'"><td>Floor '+l+' Name: </td><td><input type="text" name="floor_'+i+'" id="floor_'+i+'" value="" size="16" onblur="set_name(this.value,'+i+');" onmouseover="this.title=this.value;"></td><input type="hidden" name="floor_id'+i+'" id="floor_id_'+i+'" value="" /><td><input type="file" name="floor_img'+i+'" id="floor_img'+i+'" onchange="handleFiles(this.files,\'imgfolder'+i+'\')" class="hidden" /><img src="images/folder_blank.png" border="0" onclick=\'doClick("floor_img'+i+'","imgfolder'+i+'")\' id="imgfolder'+i+'"  style="cursor:pointer"/></td><td><input type="text" name="option_'+i+'_no" id="option_'+i+'_no" value="" onblur="option_create(this.value,'+i+');" size="2"></td></tr></table></div>');
											//$("#create_option_no_div").append('<div id="option_'+i+'_no_div"><table width="100%"><tr ><td id="option_'+i+'_name">Floor '+i+' Options:</td><td width="20%"><input type="text" name="option_'+i+'_no" id="option_'+i+'_no" value="" onkeyup="option_create(this.value,'+i+');" size="2"></td></tr></table></div>');
											$("#create_options").append('<table id="floor_option_draw_'+i+'"  style="float:left;min-width:360px;padding:5px;" class="tbl" ><tr><td><span id="floor_option_'+i+'_name">Floor '+i+' Options List</span> <input type="hidden" name="last_no_of_option_'+i+'" id="last_no_of_option_'+i+'" value="0" ></td></tr><tr><td id="option_row_'+i+'"></td></tr></table><table style="float:left;"><td> </td></table>')
											
										}
										//document.getElementById('create_floor').innerHTML += output;
										//alert(no);
									    previous_floor=no;
										
										
									}
									else
									if(no<previous_floor)
									{
										//alert(previous_floor);
										next_start=parseInt(parseInt(no)+1);
										
										for(i=previous_floor;i>no;i--)
										{
											
											$("#create_floor").children("div[id^=floor_id]:last").remove();
											//$("#create_option_no_div").children("div[id^=option_]:last").remove();
											$("#create_options").children('<table[id^=floor_option_draw_]:last').remove();
										}
										previous_floor=no;
									}
								}
								}
								
							}
							
							function set_name(values,i)
							{
								
								ids = "#option_"+i+"_name";
								$(ids).html(values+' Options');
								id2 ='#floor_option_'+i+'_name';
								$(id2).html(values+' Options');
							}
							function set_all_name()
							{
								no = parseInt($("#no_of_floor").val());
								for(i=1;i<=no;i++)
								{
									values = floor_input_name = $("#floor_"+i).val();
									ids = "#option_"+i+"_name";
									$(ids).html(values+' Options');
									
								}
							}
							///////////===== FUNCTION FOR OPTIONS START======
							function  option_create(values, id)
							{   no = values;
								previous_option=parseInt($("#last_no_of_option_"+id).val());
								
								if(no !='' && !isNaN(no))
								{ 
								 	if(previous_option==0)
									{// alert(no);
										for(i=1;i<=no;i++)
										{
											l=i;
										   if(l<10)										   
										   l ="0"+l;
										
								
							  				$("#option_row_"+id).append('<div id="op'+id+'_'+i+'"><table ><tr id="o_row'+i+'"><td><input type="hidden" name="option_id'+id+'_'+i+'" id="option_id'+id+'_'+i+'" value="" />Option '+l+'<br /> Name: </td><td><input type="text" onmouseover="this.title=this.value;" name="opt_'+id+'_'+i+'_name" id="opt_'+id+'_'+i+'_name" value="" size="30" ></td><td><input type="file" onchange="handleFiles(this.files,\'imgfolder'+id+'_'+i+'\')" id="opt_img'+id+'_'+i+'" name="opt_img'+id+'_'+i+'"class="hidden" /><img src="images/folder_blank.png" border="0" onclick=\'doClick("opt_img'+id+'_'+i+'","imgfolder'+id+'_'+i+'")\' id="imgfolder'+id+'_'+i+'"  style="cursor:pointer"/></td></tr></table></div>');	
							      		}
									document.getElementById("last_no_of_option_"+id).value=no;									
									
								}
									else
									{
									if(no>previous_option)
									{
										next_start=parseInt(parseInt(previous_option)+1);
										for(i=next_start;i<=no;i++)
										{ //alert("#option_row_"+id);
											l=i;
										   if(l<10)										   
										   l ="0"+l;										
											$("#option_row_"+id).append('<div id="op'+id+'_'+i+'"><table ><tr id="o_row'+i+'"><td><input type="hidden" name="option_id'+id+'_'+i+'" id="option_id'+id+'_'+i+'" value="" />Option '+l+' <br /> Name: </td><td><input type="text" onmouseover="this.title=this.value;" name="opt_'+id+'_'+i+'_name" id="opt_'+id+'_'+i+'_name" value="" size="30" ></td><td><input type="file" name="opt_img'+id+'_'+i+'" id="opt_img'+id+'_'+i+'" onchange="handleFiles(this.files,\'imgfolder'+id+'_'+i+'\')" class="hidden" /><img src="images/folder_blank.png" border="0" onclick=\'doClick("opt_img'+id+'_'+i+'","imgfolder'+id+'_'+i+'")\' id="imgfolder'+id+'_'+i+'"  style="cursor:pointer"/></td></tr></table></div>');
										}
										document.getElementById("last_no_of_option_"+id).value=no;
									}
									
									else if(no<previous_option)
									{
										//alert(previous_option);
										next_start=parseInt(parseInt(no)+1);
										
										for(i=previous_option;i>no;i--)
										{
											
											$("#option_row_"+id).children("div[id^=op]:last").remove();
											
										}
										document.getElementById("last_no_of_option_"+id).value=no;
									}
								}
								//alert($("#last_no_of_option_"+id).val());
								}
							}
							function create_elevation()
							{
								previous_elv_value = parseInt($("#previous_elv_value").val());
								no =$("#no_of_elevation").val();
								//alert(no);
								if(no !="" && !isNaN(no))
								{  //alert(no);
									if(previous_elv_value==0)
									{
										for(i=1;i<=no;i++)
										{
											l=i;
										   if(l<10)										   
										    l ="0"+l;										
											$("#create_elevation_div").append('<div id="elevation_id'+i+'" class="elv_div"><table><tr id="elv_row'+i+'"><td>Elv '+l+' Name: </td><td><input type="text" name="elv_'+i+'" id="elv_'+i+'" value="" onmouseover="this.title=this.value;" size="30"><input type="hidden"  value=""  id="elv_id'+i+'"  name="elv_id'+i+'"  /></td><td><input type="file" name="elv_img'+i+'" id="elv_img'+i+'" onchange="handleFiles(this.files,\'elv_imgimgfolder'+i+'\')"class="hidden" /><img src="images/folder_blank.png" border="0" onclick=\'doClick("elv_img'+i+'","elv_imgimgfolder'+i+'")\' id="elv_imgimgfolder'+i+'"  style="cursor:pointer"/></td></tr></table></div>');
										}
										 document.getElementById("previous_elv_value").value=no;
									}
									
									else if(no>previous_elv_value)
									{
										next_start=parseInt(parseInt(previous_elv_value)+1);
										for(i=next_start;i<=no;i++)
										{
											l=i;
										   if(l<10)										   
										   l ="0"+l;

											$("#create_elevation_div").append('<div id="elevation_id'+i+'" class="elv_div"><table><tr id="elv_row'+i+'"><td>Elv '+l+' Name: </td><td><input type="text" name="elv_'+i+'" id="elv_'+i+'" value="" onmouseover="this.title=this.value;" size="30"><input type="hidden"  value=""  id="elv_id'+i+'"  name="elv_id'+i+'"  /></td><td><input type="file" name="elv_img'+i+'" id="elv_img'+i+'" onchange="handleFiles(this.files,\'elv_imgimgfolder'+i+'\')" class="hidden" /><img src="images/folder_blank.png" border="0" onclick=\'doClick("elv_img'+i+'","elv_imgimgfolder'+i+'")\' id="elv_imgimgfolder'+i+'"  style="cursor:pointer"/></td></tr></table></div>');
										}
										 document.getElementById("previous_elv_value").value=no;
									}
									else if(no<previous_elv_value)
									{
										//alert(previous_elv_value);
										next_start=parseInt(parseInt(no)+1);
										
										for(i=previous_elv_value;i>no;i--)
										{
											
											$("#create_elevation_div").children("div[id^=elevation_id]:last").remove();
											
										}
										document.getElementById("previous_elv_value").value=no;
										
									}
									
																		
									
								}
									
								}
								
    function handleFiles(files,idsss) 
	{
      var d = document.getElementById("preview_img_div");
	  d.innerHTML='<img src="images/ajaxLoading.gif" />';
      if (!files.length) {
        d.innerHTML = "<p>No files selected!</p>";
		$("#"+idsss).attr("src","images/folder_blank.png");
      } else {
        for (var i=0; i < files.length; i++) {
          var img = document.createElement("img");
          img.src = window.URL.createObjectURL(files[i]);;
          img.height = 400;
          img.onload = function() {
            window.URL.revokeObjectURL(this.src);
          }
          //li.appendChild(img);
          
          //var info = document.createElement("span");
		  d.innerHTML='';
          d.appendChild(img);
       //   li.appendChild(info);
        }
		$("#"+idsss).attr("src","images/Open-Folder-Full.png");
      }
    }

				function show_img_edit(srcs)
				{
					d = document.getElementById("preview_img_div");
					var img = document.createElement("img");
          			img.src =srcs;
					img.height = 400;
					 d.innerHTML='';
         			 d.appendChild(img);
				}				
								
								function validate()
								{
									no = parseInt($("#no_of_floor").val());
									project_name=$("#project_name").val();
									logo = $("#logo").val();
									area =$("#area").val();
									if(project_name=='')
									{
										alert('project name should not blank');
										document.getElementById('project_name').focus();
										return false;
									}
									if(area=='')
									{
										alert('area should not blank');
										document.getElementById('area').focus();
										return false;
									}
									
									if(no !='')
									{
										for(i=1;i<=no;i++)
										{
											
											floor_id = $("#floor_id_"+i).val();
											//alert("#floor_id"+i+' '+floor_id);
											floor_  = $("#floor_"+i).val();
											floor_img = $("#floor_img"+i).val();
											if(floor_id =='')
											{
												if(floor_=='')
												{
													alert('Floor Name should not blank');
													document.getElementById("floor_"+i).focus();
													return false;
												}
												else if(floor_img=='')
												{
													alert('Floor Image should not blank');
													document.getElementById("floor_img"+i).focus();
													return false;
												}
												
													 
											}
											total_options =$("#option_"+i+"_no").val();
												//alert(total_options);	 
													 for(k=1;k<=total_options;k++)
													 {
														 
														 if($("#option_id"+i+"_"+k).val()=='')
														 {
															
															 if($("#opt_"+i+"_"+k+"_name").val()=='')
															 {
																alert('Option name should not blank');
																document.getElementById("opt_"+i+"_"+k+"_name").focus();
																return false;		
															 }
															 if($("#opt_img"+i+"_"+k).val()=='')
															{
																alert('Option Image should not blank');
																document.getElementById("opt_img"+i+"_"+k).focus();
																return false;
															}
															 
														 }
													
												}	
										}
									}
									
									
									no_of_elevation =$("#no_of_elevation").val();
									
									 for(k=1;k<=no_of_elevation;k++)
									 {
										 
										 if($("#elv_id"+k).val()=='')
										 {
											
											 if($("#elv_"+k).val()=='')
											 {
												alert('Elevation name should not blank');
												document.getElementById("elv_"+k).focus();
												return false;		
											 }
											  if($("#elv_img"+k).val()=='')
											 {
												alert('Elevation image should not blank');
												document.getElementById("elv_img"+k).focus();
												return false;		
											 }
										 }
									 }
									return true;
								}
									
							