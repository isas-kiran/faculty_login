									function clears(id_clear)
									{
										selectd_id = "#exc_opt_"+id_clear;
										//alert(selectd_id);
										$(selectd_id). val([]);
									}
									function save_options123(row_num,total_floors)
									{
										
										var label_ = '#label_'+row_num;
										for_option=$(label_).val();
										if(for_option=='')
										{
										alert('Please select the excusive option');
										$(label_).focus();
										return false;
										}
										else
										{
										values_selected='';
										for(d=1;d<=total_floors;d++)
										{   //var opt_id='';
												 opt_id = '#exc_opt_'+row_num+'_'+d;
												//alert(opt_id);
												var foo = []; 
												$(opt_id+' option:selected').each(function(i, selected){ 
												  foo[i] = $(selected).val(); 
												 // alert(foo[i]);
												  values_selected +=foo[i]+',';
												});	
											
											
										}
										//alert(values_selected);
										if(values_selected=='')
										{
											alert('Please select the excusive dependent option');
											//$(label_).focus();
											return false;
										
										}
										
										/////////////==============
										
									var data1="showonlyvalues=1&condition=excusive&for_option="+for_option+"&to="+values_selected+"&row_num="+row_num;
				
							$.ajax({
				
								url: "public-process.php", type: "post", data: data1, cache: false,
				
								success: function (html)
				
								{      
				
									if(html)
				
									{                        
				
										
										$("#floor_id"+row_num).append(html);
										document.getElementById("tbl"+row_num).style.display='none';
				
									
									}
				
									else
				
									{
				
										alert("There are some errors while submitting the form, please again.");
				
									}
				
								}
							});
										}										//////////////=========
									}
									
									function edit_row(row_num)
									{
										div_ids = "#tb_"+row_num;
										
										$(div_ids).remove();
										document.getElementById("tbl"+row_num).style.display='table';
									}
									
									
									function create_floor(operations)
									{  
										no = parseInt($("#no_of_floor").val());
										
										var previous_floor=no;
										
										if(no>=0)
										{
											
										if(operations=='add')
										{
											
											no =no+1;
											$("#no_of_floor").val(no);
										}
										else
										{
											
											if(no !=1)
											{
											no = no-1;
											$("#no_of_floor").val(no);
											}
										}
										
										if(no !='')
										{
											
											if(previous_floor==0)
											{
												for(i=1;i<=no;i++)
												{												
													
													$("#create_floor").append(floors(i));					
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
														
														$("#create_floor").append(floors(i));
														
													}
													previous_floor=no;													
													
												}
												else
												if(no<previous_floor)
												{	next_start=parseInt(parseInt(no)+1);													
													for(i=previous_floor;i>no;i--)
													{
														
														$("#create_floor").children("div[id^=floor_id]:last").remove();
													}
													previous_floor=no;
												}
											
											}
										}
										}//no
										
										
										
										
																	
							}
							
							function create_type1(operations)
							{
								//alert(operations);
								no_type1 = parseInt($("#type1").val());
								
								var previous_floor1 =no_type1;
								
								if(no_type1>=0)
										{
											
										if(operations=='add_type1')
										{
											no_type1 =no_type1+1;
											
											$("#type1").val(no_type1);
										}
										else
										{
											
											if(no_type1 !=1)
											{
											no_type1 = no_type1-1;
											$("#type1").val(no_type1);
											}
										}
										
										if(no_type1 !='')
										{
											if(previous_floor1==0)
											{
												for(i=1;i<=no_type1;i++)
												{												
													//alert(no);
													$("#create_type1").append(type1(i));					
												}									
											 previous_floor1=no_type1;
											}
											else
											{	
												if(no_type1>previous_floor1)
												{
													next_start=parseInt(parseInt(previous_floor1)+1);
													for(i=next_start;i<=no_type1;i++)
													{
														
														$("#create_type1").append(type1(i));
														
													}
													previous_floor1=no_type1;													
													
												}
												else
												if(no_type1<previous_floor1)
												{	next_start=parseInt(parseInt(no_type1)+1);													
													for(i=previous_floor1;i>no_type1;i--)
													{
														$("#create_type1").children("div[id^=type1_id]:last").remove();
													}
													previous_floor1=no_type1;
												}
											
											}
										}
										
										
										}//no_type1
										
							}
							
							
							function create_type2(operations)
							{
								no_type2 = parseInt($("#type2").val());
								
								var previous_floor2=no_type2;
								if(no_type2>=0)
										{
										if(operations=='add_type2')
										{
											no_type2 =no_type2+1;
											$("#type2").val(no_type2);
										}
										else
										{
											if(no_type2 !=1)
											{
											no_type2= no_type2-1;
											$("#type2").val(no_type2);
											}
										}
										
										if(no_type2 !='')
										{
											if(previous_floor2==0)
											{
												for(i=1;i<=no_type2;i++)
												{												
													//alert(no);
													$("#create_type2").append(type2(i));					
												}									
											 previous_floor2=no_type2;
											}
											else
											{	
												if(no_type2>previous_floor2)
												{
													next_start=parseInt(parseInt(previous_floor2)+1);
													for(i=next_start;i<=no_type2;i++)
													{
														
														$("#create_type2").append(type2(i));
														
													}
													previous_floor2=no_type2;													
													
												}
												else
												if(no_type2<previous_floor2)
												{	next_start=parseInt(parseInt(no_type2)+1);													
													for(i=previous_floor2;i>no_type2;i--)
													{
														$("#create_type2").children("div[id^=type2_id]:last").remove();
													}
													previous_floor2=no_type2;
												}
											
											}
										}
										}//no_type2
							}
							
							
								
								function validate()
								{
									no = parseInt($("#no_of_floor").val());									
									var clicked_ok_all='no';
									for(x=1;x<=no;x++)
									{
										
										if(document.getElementById('row_deleted'+x).value =='')
										{
											
											 if(document.getElementById('exclusive_to_'+x))
											 {
												 clicked_ok_all='yes';
												
											 }
											
										}
									}
									
									if(clicked_ok_all=='yes')
									{
										return true;
									}else
									{
										alert('Please select options and then click on OK button before click on Save Condition Button ');
									return false;
									}
								}
									
							/*function delete_floor(id)
							{
								
								if(confirm('Do you really want to delete record'))
								{
									$("#del_floor"+id).val('yes');
									$("#floor_id"+id).removeClass('floor_div').addClass('none');
								}
							}
							function delete_type1(id)
							{
								if(confirm('Do you really want to delete record'))
								{
									$("#del_floor_type1"+id).val('yes');
									$("#type1_id"+id).removeClass('type1').addClass('none');
								}
							}
							function delete_type2(id)
							{
								if(confirm('Do you really want to delete record'))
								{
									$("#del_floor_type2"+id).val('yes');
									$("#type2_id"+id).removeClass('type2').addClass('none');
								}
							}*/
							
							function delete_rec(id,types)
							{
								if(confirm('Do you really want to delete record'))
								{
									if(types=='floor')
									{  
										$('#floor_id'+id).hide();
										$('#del_floor'+id).val('yes');
										
									}
									else if(types=='type1')
									{
										$("#type1_id"+id).hide('');
										$("#del_floor_type1"+id).val('yes');
										
									}
									else if(types=='type2')
									{
										$("#type2_id"+id).hide('');
										$("#del_floor_type2"+id).val('yes');
										
									}
									
									
								}
							}
