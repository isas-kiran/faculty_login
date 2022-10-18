<?PHP

/*
	===========================================================================
	desktop_file_write.php
	
	By: Chris Shea (chris@innovationsdesign.net)
	
	License: 	This is released as Freeware - do as you wish with it. If you extend or improve it
			I would appreciate a copy.

	This will save a file onto the local computer.
	It requires two parameters in:
		$dfw_data - The actual that will be written to the file.
		$dfw_file_name - The filename with the suffix (but not the path)
		
	This module can produce output as:
		Excel 		(xls)
		Word			(doc)
		Notepad		(txt)
		Powerpoint 	(ppt)
		MS Works  	(xlr)
		Rich Text 	(rtf)
		Comma Sep Var 	(csv)

	It is pretty simple to add additional file types.
	For examples of creating the various file types, see the 
	test module.


	============================================================================

*/

	if ($dfw_data == "") {
		echo "<br>ERROR: No input provided";
		exit;
	}

	if ($dfw_filename == "") {
		$dfw_filename = "fileout";
	}
	
	$dfw_type = substr($dfw_filename,-3);


	
	if ($dfw_type == "xls") {
		header("Content-type: application/msexcel");
		header("Content-Disposition: attachment; filename=$dfw_filename");	// the filename must end in .xls
		header("Pragma: no-cache");
		header("Expires: 0");
		print "$header\n$dfw_data";
		
	}
	elseif ($dfw_type == "doc") {
		header("Content-type: application/msword");
		header("Content-Disposition: attachment; filename=$dfw_filename");
		header("Pragma: no-cache");
		header("Expires: 0");
		print "$header\n$dfw_data";
	}
	elseif ($dfw_type == "txt") {
		header("Content-type: application/notepad");
		header("Content-Disposition: attachment; filename=$dfw_filename");
		header("Pragma: no-cache");
		header("Expires: 0");
		print "$header\n$dfw_data";
	}
	elseif ($dfw_type == "ppt") {
		header("Content-type: application/mspowerpoint");
		header("Content-Disposition: attachment; filename=$dfw_filename");
		header("Pragma: no-cache");
		header("Expires: 0");
		print "$header\n$dfw_data";
	}
	elseif ($dfw_type == "xlr") {                                                             // Microsoft Works
		header("Content-type: application/msworks");
		header("Content-Disposition: attachment; filename=$dfw_filename");
		header("Pragma: no-cache");
		header("Expires: 0");
		print "$header\n$dfw_data";
		
	}
	elseif ($dfw_type == "rtf") {
		header("Content-type: application/msworks");
		header("Content-Disposition: attachment; filename=$dfw_filename");
		header("Pragma: no-cache");
		header("Expires: 0");
		print "$header\n$dfw_data";
	}
	elseif ($dfw_type == "csv") {
		header("Content-type: application/msworks");
		header("Content-Disposition: attachment; filename=$dfw_filename");
		header("Pragma: no-cache");
		header("Expires: 0");
		print "$header\n$dfw_data";
	}

	else {
		echo "<br>ERROR: invalid file type - must be .xls .doc .txt .ppt .xlr .rtf or .csv  ";
	}
	

?>