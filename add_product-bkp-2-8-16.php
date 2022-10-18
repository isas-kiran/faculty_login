<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM product where product_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Product</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        jQuery(document).ready( function() 
        {
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
    </script>
    
<!--        <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script type="text/javascript">
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
        });
    </script>
    
     <script>
	 function show_subcategory(pcategory_id,sub_id)
	 {
				
		//alert(sub_id);
		 
		if(pcategory_id !='')
		{
		 // var course="show_subcategory=1&pcategory_id="+pcategory_id+"&sub_id="+sub_id;
	
		
		  var data1="pcategory_id="+pcategory_id+"&sub_id="+sub_id;
				   //alert(data1);
					 $.ajax({
				url: "get-subcategory.php", type: "post", data: data1, cache: false,
				success: function (html)
					{
						
						 document.getElementById('member_new').innerHTML=html;
					}
				});
				
		}
		 
	}
	 </script>
     
      <script language="javascript" src="js/script.js"></script>
      <script language="javascript" src="js/conditions-script.js"></script>
 
</head>
<body>
<?php include "include/header.php";?>
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
    <td class="top_mid" valign="bottom"><?php include "include/product_category_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
        <table width="100%" cellspacing="0" cellpadding="0">
            
        <?php
                        $errors=array(); $i=0;
                        $success=0;
                        if($_POST['save_changes'])
                        {
                            $product_name=$_POST['product_name'];
                            $product_code=$_POST['product_code'];  
							$pcategory_id=$_POST['pcategory_id'];    
							$sub_id=$_POST['sub_id']; 
							$description=$_POST['description']; 
							$amount=$_POST['amount'];
							$quantity=$_POST['quantity'];           
                            $commission=$_POST['commission'];
							$price=$_POST['price'];
							$vender=$_POST['vender'];
							$type=$_POST['type'];
							$total_floor=$_POST['floor'];
							
                            if(count($errors))
                            {
                                ?>
                                <tr>
                                    <td> <br></br>
                                    <table align="left" style="text-align:left;" class="alert">
                                    <tr><td ><strong>Please correct the following errors</strong><ul>
                                            <?php
                                            for($k=0;$k<count($errors);$k++)
                                                    echo '<li style="text-align:left;padding-top:5px;" class="green_head_font">'.$errors[$k].'</li>';?>
                                            </ul>
                                    </td></tr>
                                    </table>
                                    </td>
                                </tr>   <br></br>  
                                <?php
                            }
                            else
                            {
                                $success=1;
                                $data_record['product_name'] =$product_name;
                                $data_record['product_code'] =$product_code;
								$data_record['pcategory_id'] =$pcategory_id;
								$data_record['sub_id'] =$sub_id;
								$data_record['description'] =$description;
								$data_record['amount'] =$amount;
								$data_record['quantity']=$quantity;
								$data_record['commission']=$commission;
								$data_record['price']=$price;
								$data_record['vender']=$vender;
								$data_record['type']=$type;

                               if($record_id)
                                {
                                  
                                    $where_record=" product_id='".$record_id."'";
                                    $db->query_update("product", $data_record,$where_record);
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $data_record['added_date'] =date("Y-m-d H:i:s");
                                    $record_id=$db->query_insert("product", $data_record);
									$product_id=mysql_insert_id();
									
									//=========================INSERT GALLERY IMAGE RECORD============================
									
									/*for($i=1;$i<=$total_floor;$i++)
									{
										 
										//echo $_FILES['image'.$i]["name"];
										if($_FILES['image'.$i]["name"] !='')
										{
											$uploaded_url_gallery="";
								
											if($_FILES['image'.$i]["name"])
											{
												
												$uploaded_url_gallery=time().basename($_FILES['image'.$i]["name"]);
												$newfile_gallery= "product_photo/";
												$filename_gallery =$filetype_gallery =$filesize_gallery = $source1_gallery = $target_path1_gallery ='';
											 
										
												$filename_gallery = $_FILES['image'.$i]['tmp_name']; // File being uploaded.
												$filetype_gallery = $_FILES['image'.$i]['type'];// type of file being uploaded
												$filesize_gallery = filesize($filename_gallery); // File size of the file being uploaded.
												$source1_gallery= $_FILES['image'.$i]['tmp_name'];
												$target_path1_gallery = $newfile_gallery.$uploaded_url_gallery;
				
												list($width1, $height1, $type1, $attr1) = getimagesize($source1_gallery);
												if(strtolower($filetype_gallery) == "image/jpeg" || strtolower($filetype_gallery) == "image/pjpeg" || strtolower($filetype_gallery) == "image/GIF" || strtolower($filetype_gallery) == "image/gif" || strtolower($filetype_gallery) == "image/png")
												{
													
													if(move_uploaded_file($source1_gallery, $target_path1_gallery))
													{
													
													 $file_uploaded_gallery=1;
													}
													else
													{
														$file_uploaded_gallery=0;
														$success=0;
														$errors[$i++]="There are some errors in ".$uploaded_url_gallery." while uploading image, please try again";
													}
												}
												else
												{
													$file_uploaded_gallery=0;
													$success=0;
													$errors[$i++]="Location image: Only image files allowed";
												}
												
											}
											$data_record_gallery['product_id'] =$product_id;
											  
											$data_record_gallery['image'] =$uploaded_url_gallery; 
											$data_record_gallery['added_date'] =date('Y-m-d H:i:s');
											$record_ids=$db->query_insert("product_image", $data_record_gallery);
											//$image_id=mysql_insert_id();  
										}
									}*/
									
									for($i=1;$i<=$total_floor;$i++)
									{
										
											$uploaded_url_gallery="";
								
											if(count($errors)==0 && $_FILES['image'.$i]["name"])
											{
												
												$uploaded_url_gallery=time().basename($_FILES['image'.$i]["name"]);
												$newfile_gallery= "../product_photo/";
												$filename_gallery =$filetype_gallery =$filesize_gallery = $source1_gallery = $target_path1_gallery ='';
											 
										
												$filename_gallery = $_FILES['image'.$i]['tmp_name']; // File being uploaded.
												$filetype_gallery = $_FILES['image'.$i]['type'];// type of file being uploaded
												$filesize_gallery = filesize($filename_gallery); // File size of the file being uploaded.
												$source1_gallery= $_FILES['image'.$i]['tmp_name'];
												$target_path1_gallery = $newfile_gallery.$uploaded_url_gallery;
				
												list($width1, $height1, $type1, $attr1) = getimagesize($source1_gallery);
												if(strtolower($filetype_gallery) == "image/jpeg" || strtolower($filetype_gallery) == "image/pjpeg" || strtolower($filetype_gallery) == "image/GIF" || strtolower($filetype_gallery) == "image/gif" || strtolower($filetype_gallery) == "image/png")
												{
													
													if(move_uploaded_file($source1_gallery, $target_path1_gallery))
													{
													
													 $file_uploaded_gallery=1;
													}
													else
													{
														$file_uploaded_gallery=0;
														$success=0;
														$errors[$i++]="There are some errors in ".$uploaded_url_gallery." while uploading image, please try again";
													}
												}
												else
												{
													$file_uploaded_gallery=0;
													$success=0;
													$errors[$i++]="Location image: Only image files allowed";
												}
												
											}
											//$data_record_gallery['event_id'] =$gallery_id;
											$data_record_gallery['image'] =$uploaded_url_gallery; 
											$data_record_gallery['added_date'] =date('Y-m-d H:i:s');
											//$record_id=$db->query_insert("event_gallary_image", $data_record_gallery);
											$insert_img="insert into product_image (`product_id`,`image`,`added_date`) values('".$product_id."','".$data_record_gallery['image']."','".$data_record_gallery['added_date']."')";
											$ptr_img=mysql_query($insert_img);
											//$gallery_id=mysql_insert_id();  
										
									}
									//=========================END GALLERY IMAGE===============================
									
                                    echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                                }
                            }
                        }
                        if($success==0)
                        {
                        
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm" enctype="multipart/form-data">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
              <tr>
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
                </tr>
                
              <tr>
                  <td width="20%" valign="top">Product Name<span class="orange_font">*</span></td>
                <td width="70%"><input type="text"  class="validate[required] input_text" name="product_name" id="product_name" value="<?php if($_POST['save_changes']) echo $_POST['product_name']; else echo $row_record['product_name'];?>" /></td> 
                <td width="10%"></td>
              </tr>
             
             <tr>
                  <td width="20%" valign="top">Product Code</td>
                <td width="70%"><input type="text"  class=" input_text" name="product_code" id="product_code" value="<?php if($_POST['save_changes']) echo $_POST['product_code']; else echo $row_record['product_code'];?>" /></td> 
                <td width="10%"></td>
             </tr>
             
             <tr>
                 <td>Product Category </td>
                      <td width="70%">
                        <select name="pcategory_id" style="width:200px;" id="pcategory_id" onchange="show_subcategory(this.value,'');">
                         <option value="0">Select Category</option> 
                          <?php  
                            $sql_dest = " select pcategory_name, pcategory_id from product_category order by pcategory_id asc";
                            $ptr_edes = mysql_query($sql_dest);
                            while($data_dist = mysql_fetch_array($ptr_edes))
                            { 
                                    $selecteds = '';
                                    if($data_dist['pcategory_id']==$row_record['pcategory_id'])
                                    $selecteds = 'selected="selected"';	
                                       
                                echo "<option value='".$data_dist['pcategory_id']."' ".$selecteds.">".$data_dist['pcategory_name']."</option>";
                            }

                            ?>
                        </select>
                      </td>
                            
              </tr>
              
               <?php
			  if($record_id)
			  { ?>
              <script>
				  show_subcategory(<?php echo $row_record['pcategory_id'] ?>,'<?php echo $row_record['sub_id'] ?>')
				  </script>
			  <?php }
			  ?>
              
              <tr><td width="50%" colspan="3"><div id="member_new"> </div></td></tr>
              
             
              
                 <?php /*?><td>Product Sub Category </td>
                      <td width="70%">
                        <select name="sub_id" style="width:200px;" >
                         <option value="0">Select Category</option> 
                          <?php  
                            $sql_dest = " select sub_name, sub_id from subcategory order by sub_id asc";
                            $ptr_edes = mysql_query($sql_dest);
                            while($data_dist = mysql_fetch_array($ptr_edes))
                            { 
                                    $selecteds = '';
                                    if($data_dist['sub_id']==$row_record['sub_id'])
                                    $selecteds = 'selected="selected"';	
                                       
                                echo "<option value='".$data_dist['sub_id']."' ".$selecteds.">".$data_dist['sub_name']."</option>";
                            }

                            ?>
                        </select>
                      </td><?php */?>
                            
              
             
           <tr>
            <td width="12%" valign="top">Product Description </td>
            <td colspan="2">
                   
			 <script src="ckeditor/ckeditor.js"></script>
                <textarea name="description" id="description"><?php if ($_POST['description']) echo stripslashes($_POST['description']); else echo $row_record['description']; ?></textarea>
            <script>
                CKEDITOR.replace( 'description' );
            </script>
                </td> 

            </tr>
            
            
              
              <tr>
                  <td width="20%" valign="top">Amount</td>
                <td width="70%"><input type="text"  class=" input_text" name="amount" id="amount" value="<?php if($_POST['save_changes']) echo $_POST['amount']; else echo $row_record['amount'];?>"  /></td> 
                <td width="10%"></td>
              </tr>
              
              <tr>
                  <td width="20%" valign="top">Quantity</td>
                <td width="70%"><input type="text"  class="input_text" name="quantity" id="quantity" value="<?php if($_POST['save_changes']) echo $_POST['quantity']; else echo $row_record['quantity'];?>"  /></td> 
                <td width="10%"></td>
              </tr>
              
              <tr>
                  <td width="20%" valign="top">Commission</td>
                <td width="70%"><input type="text"  class=" input_text" name="commission" id="commission" value="<?php if($_POST['save_changes']) echo $_POST['commission']; else echo $row_record['commission'];?>" /></td> 
                <td width="10%"></td>
              </tr>
              
              <tr>
                  <td width="20%" valign="top">Price</td>
                <td width="70%"><input type="text"  class=" input_text" name="price" id="price" value="<?php if($_POST['save_changes']) echo $_POST['price']; else echo $row_record['price'];?>" /></td> 
                <td width="10%"></td>
              </tr>
            
             <tr>
                  <td width="20%" valign="top">Vender</td>
                <td width="70%"><input type="text"  class="input_text" name="vender" id="vender" value="<?php if($_POST['save_changes']) echo $_POST['vender']; else echo $row_record['vender'];?>" /></td> 
                <td width="10%"></td>
              </tr>
              
              <tr>
                  <td width="20%" valign="top">Type</td>
                <td width="70%">
                <input type="radio" name="type" id="type" value="powder" <?php if($row_record['type']=='powder') echo 'checked="checked"'; ?> >Powder
                <input type="radio" name="type" id="type" value="liquid" <?php if($row_record['type']=='liquid') echo 'checked="checked"'; ?> >Liquid
                <input type="radio" name="type" id="type" value="creamy" <?php if($row_record['type']=='creamy') echo 'checked="checked"'; ?> >Creamy
                
                </td> 
                <td width="10%"></td>
              </tr>
              
              <tr>
              
              
              </tr>
              <td colspan="2">
                 	<table  width="100%" style="border:1px solid gray; ">
                    	<tr>
                        <td colspan="2">
                        <!--===========================================================NEW TABLE START===================================-->
                        <table cellpadding="5" width="100%" >
                         <tr>
                         <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" size="1" onKeyUp="create_floor();" value="0" />
                         
                         <script language="javascript">
									
									function floors(idss)
									{
										var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td valign="top" width="10%"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'" /><input type="file" name="image'+idss+'" id="image'+idss+'" /></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';
										document.getElementById('floor').value=idss;
										return shows_data;
									}
									
							</script>
                         
                         
                           <td align="right"><input type="button" name="Add"  class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" > 
<input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" >
  </td></tr>
                                <tr><td>  </td><td align="left"></td></tr>
                        </table> 
                        <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center"><tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>
  <tr ><td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td></tr>
  <tr>
                            <td colspan="6">
                            <table cellspacing="3" id="tbl" width="100%">
                            <tr>
                           <!-- <td valign="top" width="1%" align="center">Position</td>
                            <td valign="top" width="10%" align="center">Tag</td>
                            <td valign="top" width="10%" align="center" >Comment</td>-->
                            <td valign="top" width="10%"  align="center">Upload Image</td>
                             </tr></table>
                             <input type="hidden" name="floor" id="floor"  value="0" />
                            <div id="create_floor"></div>
                        </td></tr></table>
                        <!--============================================================END TABLE=========================================-->
                        </td>
                        </tr>
                    	
                 	</table>
                 </td>
              <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Product" name="save_changes"  /></td>
                  <td></td>
              </tr>
        </table>
        </form>
        </td></tr>
<?php
                        }   ?>
	 
        </table></td>
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
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
<script language="javascript">
create_floor('add');
//create_floor_dependent();
</script>
</body>
</html>
<?php $db->close();?>