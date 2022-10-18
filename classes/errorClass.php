<?
	class errorClass
	{
   		public  $errMsg = "";
		
		function err_chkNullText($val,$valText)
		{
			if(strlen($val) <= 0)
			{
				$this->errMsg .= "* Please enter " . $valText . ".<br>";
			}else
			{
				$this->checkAbuseLanguage($val,$valText);
			}
			
			return $this->errMsg;
		}
		
		function err_chkNullValue($val,$valText)
		{
			if(strlen($val) <= 0 ||  $val == "0")
			{
				$this->errMsg .= "* Please select " . $valText . ".<br>";
			}else
			{
				$this->checkAbuseLanguage($val,$valText);
			}
			
			return($this->errMsg);
		}
		
		// --- validate Text without any space in words (single word) ----
		function err_chkSingleText($val,$valText)
		{
			if(strlen($val) <= 0)
			{
				$this->errMsg .= "* Please enter " . $valText . ".<br>";
			}
			else
			{
				$this->checkAbuseLanguage($val,$valText);
				
				if(strcmp($this->is_alphabetic($val),"0") == 0)
				{
					$this->errMsg .= "* " . $valText . " should contain alphabets only.<br>";
				}		
			}
			return($this->errMsg);
		}
		
		// --- validate Text with spaces ----
		function err_chkText($val,$valText)
		{
			if(strlen($val) <= 0)	
			{	
				$this->errMsg .= "* Please enter " . $valText . ".<br>";
			}
			if(strlen($val) > 0)
			{		
				$this->checkAbuseLanguage($val,$valText);	  				 
			 	$val	=	stripslashes($val);
				if(!ereg("^[/ A-Za-z0-9.-]+$", $val, $arr))
				{					
					$this->errMsg .= "* ".$valText." should not contain special characters .<br>";
			 	} 
					
			}
			return $this->errMsg;
		}
		
		function err_chkAlphanumericText($val,$valText)
		{
			if(strlen($val) <= 0)	
			{	
				$this->errMsg 	.= "* Please enter " . $valText . ".<br>";
			}
			
			if(strlen($val) > 0)
			{	
				$this->checkAbuseLanguage($val,$valText);	  				 
			 	$val	=	stripslashes($val);
				if(!ereg("^['/ A-Za-z0-9.-_-]+$", $val, $arr))
				{					
					$this->errMsg	.= "* ".$valText." should not contain special characters .<br>";
			 	}
			}
			return $this->errMsg;
		}
		
		function err_chkAlphanumericTextOnly($val,$valText)
		{
			if(strlen($val) > 0)
			{	
				$this->checkAbuseLanguage($val,$valText);	  				 
			 	$val	=	stripslashes($val);
				if(!ereg("^['/ A-Za-z0-9.-_-]+$", $val, $arr))
				{					
					$this->errMsg	.= "* ".$valText." should not contain special characters .<br>";
			 	}
			}
			return $this->errMsg;
		}
						
		// -------- check validation for postal code --------------
		function err_chkTextLength($val,$valText,$length)
		{
			if(strlen($val))
			{
				if(strlen($val) < $length)
				{
					$this->errMsg .= "* ". $valText ." should be at least " . $length . " character long.<br>";
				}				
			} 
			return($this->errMsg);
		}
		
		// --------- Check validation wih unique key --------
		function err_chkUniqueText($tblName,$chkfield1,$val,$chkfield2,$val2,$oper,$valText,$db)
		{	
			if($tblName == "contributor_master")
			{
				$chkField2	= "contributor_id";
				$fieldName	= "username";
			}
			if($tblName == "expert_master")
			{
				$chkField2	= "expert_id";
				$fieldName	= "user_name";
			}
			if($tblName == "user_master")
			{
				$chkField2	= "user_id";
				$fieldName	= "user_name";
			}
			if($tblName == "partner_master")
			{
				$chkField2	= "partner_id";
				$fieldName	= "user_name";
			}
				
				
			if(strlen($val) <= 0)	
			{	
				$this->errMsg	    .= "* Please enter " . $valText . ".<br>";
			}
			else
			{	
				$this->checkAbuseLanguage($val,$valText);				 		 
				
				if($oper == 0)
				{
					if(($db->CheckDup("user_master","user_name",$val) == 0) && ($db->CheckDup("expert_master","user_name",$val) == 0) && ($db->CheckDup("partner_master","user_name",$val) == 0)  && ($db->CheckDup("contributor_master","username",$val) == 0))						  
					{
					}
					else
					{
						$this->errMsg .= "* " . $valText . "(".$val.") already exists, please try with other name.<br>";
					}
				}
				elseif($oper == 1)
				{
				
					
						
					if( strcmp($val,$db->FindOtherValue1($tblName,$chkField2,$val,$fieldName)) == 0  )
					{
					}	
					else
					{
					
						if( ($db->CheckDupEx("contributor_master","username",$val,"contributor_id",$val2) == 0) &&
							($db->CheckDupEx("user_master","user_name",$val,"user_id",$val2) == 0) &&
						 	($db->CheckDupEx("partner_master","user_name",$val,"partner_id",$val2) == 0) &&
							($db->CheckDupEx("expert_master","user_name",$val,"expert_id",$val2) == 0) 
							)
						{	
													}
						else
						{	
							 $this->errMsg .= "* " . $valText . "(".$val.") already exists, please try with other name.<br>";
						}
					}
					
					
				}
			} 
			return $this->errMsg;
			
		}
		
		// --------- Check validation wih unique key --------
		function err_chkUniqueTxt($tblName,$chkfield1,$val,$chkfield2,$val2,$oper,$valText,$db)
		{			
			if(strlen($val) <= 0)	
			{	
				$this->errMsg	    .= "* Please enter " . $valText . " .<br>";
			}
			else
			 {	
			 	$this->checkAbuseLanguage($val,$valText);				 		 
				 if($oper == 0)
				  {
					
					if($db->CheckDup($tblName,$chkfield1,$val) == 1)
						$this->errMsg .= "* " . $valText . "(".$val.") already exists, please try with other name.<br>";
				  }
				  else
				  if($oper == 1)
				  {				
					 if($db->CheckDupEx($tblName,$chkfield1,$val,$chkfield2,$val2) == 1)						 
						$this->errMsg .= "* " . $valText . "(".$val.") already exists, please try with other name.<br>";
				  }
			 } 
			 return $this->errMsg;
		}
		
		function err_chkUniqueSurveyText($tblName,$chkfield1,$val,$chkfield2,$val2,$chkfield3,$val3,$chkfield4,$val4,$oper,$valText,$db)
		{			
			if(strlen($val) <= 0)	
			{	
				$this->errMsg	    .= "* Please enter " . $valText . ".<br>";
			}
			else
			 {	
			 	$this->checkAbuseLanguage($val,$valText);				 		 
				 if($oper == 0)
				  {
					
					//if($db->CheckDupEx1($tblName,$chkfield1,$val,"is_delete","N") == 1)
					if($db->CheckDupEx2($tblName,$chkfield1,$val,"is_delete","N",'user_ref_id',$val4) == 1)
						$this->errMsg .= "* " . $valText . " already exists, please try with other name.<br>";							
				  }
				  else
				  if($oper == 1)
				  {				
					 //if($db->CheckDupEx2_post($tblName,$chkfield1,$val,$chkfield2,$val2,$chkfield3,$val3) == 1)
					 if($db->CheckDupEx2_post($tblName,$chkfield1,$val,$chkfield2,$val2,$chkfield3,$val3,'user_ref_id',$val4) == 1)						 
						$this->errMsg .= "* " . $valText . " already exists, please try with other name.<br>";							
				  }
			 } 
			 return $this->errMsg;
		}
		
		// this fuction allows single quote (') .
		function err_chkSpChars($val,$valText,$length=0)
		{			
			$val	=	stripslashes($val);
			if($length > 0)
			{
				$this->checkAbuseLanguage($val,$valText);
				if(!ereg("^['/ A-Za-z0-9.-]+$", $val, $arr))
				{
					$this->errMsg	    .= "* " . $valText . " should not contain special characters.<br>";
				}
			}
			return $this->errMsg;
		 }		 
		
		// -------------- check validation for Numeric value --------------
		function err_chkNumericOnly($val,$valText)
		{	
			 
			if(strlen($val)<=0)
			{
				$this->errMsg .= "* Please enter ". $valText .". <br>";
			}		
			else
			{			   
			   //if($val <= 0)//---commented by satish
               if($val < 0)
			   {
					 $this->errMsg .= "* Please enter valid ". $valText .". <br>";
			   }		
			   if(!is_numeric($val)) 
			   {
					 $this->errMsg .= "* Please enter valid ". $valText .". <br>";
			   }
			 
			}
			return($this->errMsg);
		}
		
		
		
		function err_chkNumeric($val,$valText,$length)
		{
			if(strlen($val)<=0)
			{
				$this->errMsg .= "* Please enter ". $valText .". <br>";
			}		
			else
			{			   
			   if(!is_numeric($val)) 
			   {
					 $this->errMsg .= "* Please enter valid ". $valText .". <br>";
			   }
			   
			   if ($length > 0)
			   {
					if(strlen($val) < $length)
					{
						$this->errMsg .= "* ". $valText ." should be " . $length . " integer long.<br>";
					}			
			   }
			}
			return($this->errMsg);
		}
		
		// -------------- check validation for Numeric value --------------
		function err_chkNumericPositive($val,$valText,$length)
		{
			if(strlen($val)<=0)
			{
				$this->errMsg .= "* Please Enter ". $valText .". <br>";
			}		
			else
			{			   
			   if(!is_numeric($val)) 
			   {
					 $this->errMsg .= "* Please Enter valid ". $valText .". <br>";
			   }
			  if($val <= 0)
			  {
			  		// $this->errMsg .= "* Please Enter positive value for ". $valText .". <br>";
					 $this->errMsg .= "* ". $valText ." should be greater than zero.<br>";
			  } 
			   if ($length > 0)
			   {
					if(strlen($val) < $length)
					{
						$this->errMsg .= "* ". $valText ." should be at least " . $length . " integer long.<br>";
					}			
			   }
			}
			return($this->errMsg);
		}
		
		// -------------- check validation for Phone number --------------
		function err_chkPhone($val,$valText,$length)
		{
			if(strlen($val) > 0)
			{			   
				if(!ereg("^['()/ _0-9.-]+$", $val, $arr))
			   {
					 $this->errMsg .= "* Please Enter valid ". $valText .". <br>";
			   }
			   
			  else if ($length > 0)
			   {
					if(strlen($val) < $length)
					{
						$this->errMsg .= "* ". $valText ." should be at least " . $length . " integer long.<br>";
					}			
			   }
			   
			}
			return($this->errMsg);
		}
		
		
		
		// -------------- check validation for Email address --------------
		function err_chkEmailOnly($val,$valText)
		{
			if (strlen($val) <= 0) {
				$this->errMsg .= "* Please enter ".$valText.".<br>";
			}
			else
			{
				$this->checkAbuseLanguage($val,$valText);
				if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$val))
				{
					$this->errMsg .= "* Please enter a valid Email address ".$valText."<br>";
				}
			}
			
			return $this->errMsg;
		}
		
		function err_chkEmailOnlyNew($val,$valText)
		{
			if (strlen($val) > 0) {
				//$this->checkAbuseLanguage($val,$valText);
				if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$val))
				{
					$this->errMsg .= "* Please enter a valid [$valText] email address.<br>";
				}
			}
			
			return $this->errMsg;
		}
		
		
		function err_chkEmailOnlyNew1($val,$valText)
		{
			$this->rr = 0;
			if (strlen($val) > 0) {
				//$this->checkAbuseLanguage($val,$valText);
				if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$val))
				{
					$this->rr = "1";
				}
			}
			
			return $this->rr;
		}
		
		
		
		// -------------- check validation for email address with database value --------------
		function err_checkMail($fldEmail,$oper="",$tblName="",$chkfield1="",$val="",$condfld="",$condval="",$db="",$valText="")
		{			
			if(strlen($valText) <=0) 	
				$valText	=	"email ";
				
			if(strlen($fldEmail) <= 0)
			{
				$this->errMsg .= "* Please enter ".$valText." address.<br>";
			}
			else 
			{				
				$this->checkAbuseLanguage($fldEmail,$valText);
				if( !eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*"."@([a-z0-9]+([\.-][a-z0-9]+))*$",$fldEmail) )
				{
					$this->errMsg .="* Please enter a valid ".$valText." address.<br>";
				}
				else
				{ 
					if(strlen($oper) > 0 ||  $oper != "") 
					{
						 if($oper == 0)
						 {
							if(strlen($tblName) > 0) 
							{
								if($db->CheckDup($tblName,$chkfield1,$val) == 1){
									$this->errMsg .= "* ".$valText." already exists, please try with other name.<br>";
								}
							}
						 }
						 elseif($oper == 1)
						 {	
							 if ($db->CheckDupEx($tblName,$chkfield1,$val,$condfld,$condval) == 1)
							{
								$this->errMsg .= "* Email already exists, please try with other email.<br>";
							}
						 }
						
					}		
				}
			}
			
			return($this->errMsg);
		}
		
		
		// -------------- check validation for email address with database value (Email address not compulary)--------------
		function err_checkMail_notComp($fldEmail,$oper="",$tblName="",$chkfield1="",$val="",$condfld="",$condval="",$db="",$valText="")
		{			
			if(strlen($valText) <=0) 	
				$valText	=	"Email ";
				
			if(strlen($fldEmail) > 0 )
			{	
				$this->checkAbuseLanguage($fldEmail,$valText);		
				if( !eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*"."@([a-z0-9]+([\.-][a-z0-9]+))*$",$fldEmail) )
				{
					$this->errMsg .="* Please enter a valid ".$valText." address.<br>";
				}
				else
				{ 
					
					if(strlen($oper) > 0 ||  $oper != "") 
					{
						 if($oper == 0)
						 {
							if(strlen($tblName) > 0) 
							{
								if($db->CheckDup($tblName,$chkfield1,$val) == 1){
									$this->errMsg .= "* ".$valText." already exists, please try with other name.<br>";
								}
							}
						 }
						 elseif($oper == 1)
						 {	
							 if ($db->CheckDupEx($tblName,$chkfield1,$val,$condfld,$condval) == 1)
							{
								$this->errMsg .= "* Email already exists, please try with other email.<br>";
							}
						 }
						
					}		
				}
			}
			
			return($this->errMsg);
		}
	
	
		// --------------------- Check email validation at the time of updation --------
		function err_checkMail_update($tblName,$field,$val,$condfld,$condval,$db)
		{
			if(strlen($val) <=0)
			{
				$this->errMsg .= "* Please enter Email address.<br>";
			}
			else 
			{				
				$this->checkAbuseLanguage($fldEmail,$valText);
				if( !eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*"."@([a-z0-9]+([\.-][a-z0-9]+))*$",$val) )
				{
					$this->errMsg .="* Please enter a valid Email address.<br>";
				}
				else
				{
					if ($db->CheckDupEx($tblName,$field,$val,$condfld,$condval) == 1)
					{
						$this->errMsg .= "* Email already exists, please try with other email.<br>";
					}
				}
			}
			return($this->errMsg);
		}
		
		function err_chkLogin($oldPass,$newPass,$original,$confirmPass)
		{
			if(strlen($oldPass) <= 0 )
				 $this->errMsg	.= "* Please enter the old password.<br>";
				 
			if(strlen($newPass) <= 0 )
				 $this->errMsg	.= "* Please enter the new password.<br>";
			
			if(strlen($confirmPass) <= 0 )
				 $this->errMsg	.= "* Please enter the confirm password.<br>";
			
			if(strcmp($newPass,$confirmPass)== 0)
			{
				if(strcmp($oldPass,$original)== 0 && strlen($oldPass) > 0 &&  strlen($newPass) > 0 )
				{
					return $this->errMsg;
					
				}else
				{
					if(strlen($oldPass) > 0 &&  strlen($newPass) > 0)
						$this->errMsg	.= "* Please enter valid old password.<br>";
				}
			}else
				$this->errMsg		.= "* New password and confirm password is missmatch.";
			
			return $this->errMsg;
		}//function
		
		function err_chkBothPassword($fldPWD,$fldConPWD)
		{
			// New Line Added for Null Password 
			if(strlen($fldPWD) <= 0)
			{
				$this->errMsg 	.=	"* Please enter Password.<br>";
			} 
			// End of New Line Added for Null Password 
			else
			{
				
				if((!ereg("^[0-9A-Za-z]+$",$fldPWD)))
				{
					$this->errMsg .= "* Please enter valid Passwords.<br>";
				}
			
				if(strlen($fldPWD) < 5)
				{
					$this->errMsg .= "* Password must be at least 5 characters.<br>";
				}				
				if(strcmp($fldPWD,$fldConPWD) != 0)
				{
					$this->errMsg .= "* Both passwords should be equal.<br>";
				}
			}
			
			
			return($this->errMsg);
		}
	
		// ------------- Change password validation --------------------------------------------------
		function chk_passowrd($tblName,$cmpPass,$cmpUid,$fldUID,$fldPWD1,$fldPWD2,$fldPWD3,$db)
		{
			if(strlen($fldPWD1) < 5 || strlen($fldPWD1) > 30)
			{
				$this->errMsg .= "* Enter old password (alphanumeric characters of min 5 and max 30 characters)<br>";
			}
			else
			{
				if($db->CheckDupEx1($tblName,$cmpPass,$fldPWD1,$cmpUid,$fldUID) == 0)
				{
					$this->errMsg .= "* Old password does not match, please try again <br>";
				}
			}
			if(strcmp($fldPWD2,$fldPWD3) != 0)
			{
				$this->errMsg .= "* New password and Confirm passwords must be same <br>";
			}
			elseif((!ereg("^[0-9A-Za-z]+$",$fldPWD2) || strlen($fldPWD2) < 5) || (!ereg("^[0-9A-Za-z]+$",$fldPWD3) || strlen($fldPWD3)< 5))
				{
					$this->errMsg .= "* Enter valid new passwords (alphanumeric characters of min 5 and max 30 characters)<br>";
				}
			
			return($this->errMsg);
		}
		
		function err_chkPage($val,$part,$dir,$tblname,$fieldChkVal,$fieldChk,$pgFieldName,$db,$valText)
		{			
			//$filelen	=	strlen(basename($dir));
			//$dir	=	substr($dir,0,-($filelen+1));
			
			if(strlen($val) <= 0 )
			{
				 $this->errMsg 	.= "* Please enter ".strtolower($valText).".<br>";
			}			
			else
			{
				$rest	= explode(".",$val);
				if(strlen($rest[0]) < 3 || strlen($rest[0]) > 100)
				{
					$this->errMsg .= "*. ".$valText." should be between 3 - 100 characters.<br>";
				}
				$first=substr($val,0,1); 
				if(is_numeric($first)==true)
					$this->errMsg .= "* ".$valText." must not start with number.<br>";
				
				if(!ereg("^[0-9A-Za-z&.-]+$",$val))
					$this->errMsg .= "* Please enter a valid ".strtolower($valText).".<br>";
				else
				{
					$tmpCheck = substr($val,-4,5);
					if(!($tmpCheck == ".php"))
						$this->errMsg .= "* ".$valText." should be extension with .php <br>";
						
						
					else if($part == 0)
					{
						//echo "<br>pg name ".$dir."/".$val;
						if(file_exists($dir."/".$val))
							$this->errMsg .= "* ".$valText." already exist please enter again.<br>";
					}
					
					if (($db->CheckDupEx($tblname,$pgFieldName,$val,$fieldChkVal,$fieldChk) != 0))
					{
						
						$this->errMsg	.= "* The page of that name is already exists, please try another page name. <br>";
					}
				}
			}			
			return $this->errMsg;
	
		} // end of chk pg func
		
		function is_alphabetic($strValue)
		  {
			$Ans = ereg('^[[:alpha:]]+$',$strValue);
			
			if(strcmp($Ans,"1") == 0)
				$returnVal = 1;
			else
				$returnVal = 0;
				
			return $returnVal;
		 }
		 
		 function err_chkAddress($val,$valText)
		 {
		 	if(strlen($val) <= 0)
			{
				$this->errMsg	.= "* Please enter ".$valText.".<br>";
			}
			elseif(strlen($val) <= 0)
			{
				$this->checkAbuseLanguage($fldEmail,$valText);
			}
			elseif(!(!preg_match("/[^a-zA-Z0-9\\n\.\-\ ]+$/s",$val)))
			{
				$this->errMsg	.= "* ".$valText."  must not contain special characters. <br>";
			}	
			return $this->errMsg;
		 }
		 
		 function err_chkSelect($val,$valText)
		 {
		 	if(strlen($val) <= 0)
			{
				$this->errMsg	.= "* Please select ".$valText.".<br>";
			}			
			return $this->errMsg;		
		 }
		 
		 // check image validation (size, extension, blank)
		 function err_image($val,$val1,$valText,$width,$height,$imgPath)
		 {
			 if(strlen($val) <= 0)
			 {
			 	$this->errMsg	.= "* Please select ".$valText."<br>";
			 }else
			 {
			 	if(!file_exists($imgPath.$val1))
				{
				 $flsavechk = strtolower(substr(strrchr($val1, "."), 1));
				if( strcasecmp($flsavechk,"png")!=0  &&  strcasecmp($flsavechk,"gif")!=0 && strcasecmp($flsavechk,"jpg")!=0 && strcasecmp($flsavechk,"jpeg")!=0 )
					$this->errMsg .= "* Please select valid ".$valText." of png/jpeg format.<br>";				
				
				$tmpSize	=	getimagesize($val);
				$tmpwidth	= $tmpSize[0];
				$tmpheight	= $tmpSize[1];
			
				if($tmpwidth > $width || $tmpheight > $height)
				{
					$this->errMsg	.=	"* $valText dimensions must be less than equal to $width X $height <br>";
				}//if
				}else
					$this->errMsg	.= "* $valText already exits.";
			}//else	 
			
			return $this->errMsg;
			 
		 }//err_image
		 
		 // image valiation
		 function err_chkImgType($val,$valText)
		 {			
			 if(strlen($val) > 0 )
			 {
				$flsavechk = strtolower(substr(strrchr($val, "."), 1));
				if(  strcasecmp($flsavechk,"png")!=0 && strcasecmp($flsavechk,"jpg")!=0 && strcasecmp($flsavechk,"jpeg")!=0 && strcasecmp($flsavechk,"gif")!=0 )
					$this->errMsg .= "* Please select valid ".$valText." of png/jpeg/jpg/gif format.<br>";				
			}else
			{
				$this->errMsg .= "* Please upload $valText";
			} 
			return $this->errMsg;
		}
		
		// profile valiation
		 function err_chkProfileType($val,$valText)
		 {			
			 if(strlen($val) > 0 )
			 {
				$flsavechk = strtolower(substr(strrchr($val, "."), 1));
				if(  strcasecmp($flsavechk,"doc")!=0 && strcasecmp($flsavechk,"txt")!=0 )
					$this->errMsg .= "* Please select valid ".$valText." of doc/txt format.<br>";				
			}
			return $this->errMsg;
		}
		
		 function err_chkImgSize($val,$valText,$width,$height)
		 {
		 	$tmpSize	=	getimagesize($val);
			 $tmpwidth	= $tmpSize[0];
			 $tmpheight	= $tmpSize[1];
			 $showWidth	= $width-1;
			 $showHeight	= $height-1;
			if($tmpwidth < $showWidth || $tmpheight < $showHeight)
			{
				 $this->errMsg	.=	"* $valText dimensions must be greater than or equals to $showWidth X $showHeight pixels.<br>";
			}
			return	$this->errMsg;
		 }
		 
		 function err_chkImgTypeBanner($val,$dbImg,$valText)
		 {			
			 if(strlen($val) <= 0 &&  strlen($dbImg) <= 0)
			 {
			 	$this->errMsg	.= "* Please select ".$valText."<br>";
			 }			 
			 if(strlen($val) > 0 )
			 {
				$flsavechk = strtolower(substr(strrchr($val, "."), 1));
				if(  strcasecmp($flsavechk,"png")!=0 && strcasecmp($flsavechk,"jpg")!=0 && strcasecmp($flsavechk,"jpeg")!=0 && strcasecmp($flsavechk,"gif")!=0)
					$this->errMsg .= "* Please select valid ".$valText." of png/gif/jpeg format.<br>";				
			} 
			return $this->errMsg;
		}
		
		// Video validation
		 function err_chkVideoType($val,$valText)
		 {			
			 if(strlen($val) > 0 )
			 {
				$flsavechk = strtolower(substr(strrchr($val, "."), 1));
				if(  strcasecmp($flsavechk,"3gpp")!=0 && strcasecmp($flsavechk,"avi")!=0 && strcasecmp($flsavechk,"mpeg")!=0)
					$this->errMsg .= "* Please select valid ".$valText." of 3gpp/avi/mpeg format.<br>";				
			}else
			{
				$this->errMsg .= "* Please select $valText";
			} 
			return $this->errMsg;
		}
		// --------- Check validation wih unique Postage --------
		function err_chkUniquePostage($tblName,$chkfield1,$val,$chkfield2,$val2,$chkfield3,$val3,$oper,$valText,$db)
		{			
//			echo "<BR>k  ".$oper;
			if(strlen($val2) <= 0)	
			{	
				$this->errMsg	    .= "* Please select " . $valText . " .<br>";
			}
			else
			 {					 		 
					 if($oper == 0)
					{
						if($db->CheckDupEx1($tblName,$chkfield1,$val,$chkfield2,$val2) == 1)
							$this->errMsg .= "* " . $valText . " already exists, please try with other name.<br>";							
					}
					else
					 if($oper == 1)
					 {						
						 if($db->CheckDupEx1_post($tblName,$chkfield1,$val,$chkfield2,$val2,$chkfield3,$val3) == 1)						 
							$this->errMsg .= "* " . $valText . " already exists, please try with other name.<br>";							
					 } 
				
			 } 
			 return $this->errMsg;
		}
		
		 function err_chkSiteUrl($val,$valText)
		{
			if(strlen($val) <=0)
			{
				$this->errMsg .= "* Please Enter ".$valText.".<br>";
			}
			else
			{
				$CHECK_URL 			= TRUE;
				$CHECK_URL_REGEX 	= "/^(http:|ftp:\/\/).*(\.+).*/i";
				if($CHECK_URL && !preg_match($CHECK_URL_REGEX, $val))
					 $this->errMsg .= "* Enter a valid ".$valText.".<br>";
			}
			return $this->errMsg;
		} 
		
		function err_chkDUPSiteUrl($val,$valText,$db,$oper="",$tblName="",$chkfield1="",$condfld2="",$condval2="",$condfld3="",$condval3="")
		{
			if($oper == 0 && strlen($oper) > 0)
				{
					 if ($db->CheckDupEx1($tblName,$chkfield1,$val,$condfld2,$condval2) == 1)							
						$this->errMsg .= "* Entries for URLs already exists.Please re-enter.<br>";						
				}
				else
				if($oper == 1 && strlen($oper) > 0)
				{
					 if($db->CheckDupEx1_post($tblName,$chkfield1,$val,$condfld2,$condval2,$condfld3,$condval3) == 1)					 						
						$this->errMsg .= "* Entries for URLs already exists.Please re-enter.<br>";						
				} 
				
				return $this->errMsg;
		}
		
		
		function err_chkDOB($val,$valText)
		{
			if(empty($val))
			{
				$this->errMsg .= "* Please enter $valText.<br>";
			}else
			{
				$arrYear	= explode("-",$val);
				if($arrYear[2] > 1992)
				{
					$this->errMsg .= "* Please enter valid $valText (grater than 16).<br>";
				}//if
			}//else
			return $this->errMsg;
		}//function err_chkDOB
		
		function chkCheckBox($val,$valText)
		{
			if(strlen($val) <= 0)
			{
				$this->errMsg .= "* Please accept  " . $valText . ".<br>";
			}
		
			return $this->errMsg;
		}//function chkCheckBox
		
		/* function for checking abouse words */
		function checkAbuseLanguage($val,$valText)
		{
			  $abuseKeyWords = "asshole:fuck:bastard:benchod:rape:madarchod";
			
			  $abuse = explode(":",$abuseKeyWords);
			  $match ="";
			  
			  foreach($abuse as $value)
			  {
				$match .= stristr($val,$value);
			  }
			
			  if($match!="")
			  {
				 	 $this->errMsg .= "* Please do not enter abuse words for ".$valText.".<br>";
			  }
			
			  return $this->errMsg;
		 }
		
		function err_chkAbuseText($val,$valText)
		{
			if(strlen($val) > 0)
			{
				$this->checkAbuseLanguage($val,$valText);
			}
			return $this->errMsg;
		}
		//function for date comparision
		
		function err_date_comparison($todays_date,$entered_date,$valtext)
		{
		   $currDate      = strtotime($todays_date);
		   $enterDate     = strtotime($entered_date);
			
			if($entered_date!= "")
			{ 
			   if ($currDate > $enterDate){
					return $this->errMsg	 .="* Please enter valid ". $valtext." date.<br>";
				}else
				   return $this->errMsg;
			}
			else 
			   return $this->errMsg   .="* Please enter ". $valtext." date.<br>";  
		}
		
		
		
		function err_chkIsAirtel($val,$msg)
		{
			$mobileType = chkTypeOfMSISDN($val);
			if( strcmp($mobileType,"airtel") != 0 )
			{
				return $this->errMsg	 .="* ".$msg;
			}
			return $this->errMsg;
		}
		
		/* Added by radhika */
		function chkEmailList($val,$valText)
		{
			
			$status	= "";
			$strEmailIds = "";
			$strEmailIds	= $val;
			$arrEmails	= explode(",",$strEmailIds);
			if(sizeof($arrEmails) > 1)
			{	
				for($e=0;$e<sizeof($arrEmails);$e++)
				{
					if(!eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*"."@([a-z0-9]+([\.-][a-z0-9]+))*$",trim($arrEmails[$e])))
					{
						  $this->errMsg .="* Please enter a valid ".$arrEmails[$e]." email address in ".$valText." .<br>"; 
					}//if
					
				}//FOR
				
			}//EMAILS
			else
			{
				$this->err_check_mail_only($strEmailIds,$valText);
			}
			return($this->errMsg);
		}//FUNCTION
		
		// -------------- check validation for email address only (radhika) --------------
		function err_check_mail_only($fldEmail,$valText)
		{			
			if(strlen($valText) <=0) 	
				$valText	=	"Email ";
				
			if(strlen($fldEmail) <=0)
			{
				$this->errMsg .= "* Please enter ".$valText." address.<br>";
			}
			else 
			{				
				if( !eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*"."@([a-z0-9]+([\.-][a-z0-9]+))*$",$fldEmail) )
				{
					$this->errMsg .="* Please enter a valid ".$valText." address.<br>";
				}
			}
			
			return($this->errMsg);
		}
		
		
		
		function err_chkFileSize($FileSize,$checkSize,$valText)
		 {	
			if($FileSize>$checkSize)		
			{
				$this->errMsg .= "* ".$valText." size should not be more than 10MB<br>";
				//echo "a++++".$FileSize; exit;
			}
			return $this->errMsg;
		}
		
		function err_chkSongType($val,$dbImg,$valText,$part)
		 {			
			if($part == 0) 
			{
				if(strlen($val) <= 0)
				
				{
					$this->errMsg .= "* Please upload ".$valText."  file.<br>";
				}	
				else if(strlen($val) > 0 )
				 {
					$flsavechk = strtolower(substr(strrchr($val, "."), 1));
					if(  strcasecmp($flsavechk,"mp3")!=0)
						$this->errMsg .= "* Please select valid ".$valText." of mp3 format.<br>";				
				} 
			} else {
				if(strlen($val) > 0 )
				 {
					$flsavechk = strtolower(substr(strrchr($val, "."), 1));
					if(  strcasecmp($flsavechk,"mp3")!=0)
						$this->errMsg .= "* Please select valid ".$valText." of mp3 format.<br>";				
				} 
					
			}	
			return $this->errMsg;
		}
		
		function err_chkFlashType($val,$dbImg,$valText,$part)
		 {		
		 		
				if(strlen($val) <= 0)
					$this->errMsg .= "* Please upload ".$valText."  file.<br>";
				else if(strlen($val) > 0 )
				 {
				 	$flash_size	= $_FILES["txt_flash"]["size"];
					$flsavechk = strtolower(substr(strrchr($val, "."), 1));
					if(  strcasecmp($flsavechk,"flv")!=0 and  strcasecmp($flsavechk,"swf")!=0)
						$this->errMsg .= "* Please select valid ".$valText." of flv/swf format.<br>";	
					// 10485760 = 10 MB 2097152 = 2MB
					if( $flash_size > "10485760")
					{
						$this->errMsg .= "* Flash size should not be greater than 10 MB.<br>";	
					}			
				} 
			return $this->errMsg;
		}

		function err_pptType($val,$dbImg,$valText,$part)
		{
			if(strlen($val) <= 0)
					$this->errMsg .= "* Please upload ".$valText."  file.<br>";
				else if(strlen($val) > 0 )
				 {
					$flsavechk = strtolower(substr(strrchr($val, "."), 1));
					if(  strcasecmp($flsavechk,"ppt")!=0 )
						$this->errMsg .= "* Please select valid ".$valText." of ppt format.<br>";				
				} 
			return $this->errMsg;
		}
	} // class end
	
?>