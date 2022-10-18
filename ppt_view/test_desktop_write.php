<?PHP

/*
  	  ===================================================================
  	  test_desktop_file_write.php
  	  
  	  By: Chris Shea (chris@innovationsdesign.net)
  	  
  	  License: Freeware - do as you wish

	This demonstrates the use of desktop_file_write.php to create files using Excel, Word, Notepad or Powerpoint.

  	Excel and Word are basically happy with html input. This allows you to use colors, fonts, tables, line-skips etc.

	Notepad is an easy fallback in the situation where Word may not be available.

	PowerPoint works but I'm not sure how practical it is.

	You can also produce an MS Works spreadsheet, a Rich Text File (RTF), or a Comma Separated Variables file.
	=======================================================================

*/

$path_global	= $_SERVER['DOCUMENT_ROOT']."/_include_global";           // **** Change this to the path for the desktop_file_write.php module


	$data1 = "xxxxxxxxxx,yyyyy,zzzzzz\n
			12345,54367,abc,def\n
			";                                     // this one doesn't split the fields but it does do a double line skip

	$data2 = "xxxxxx\tyyyyyyy\tzzzzzzz\n12344\t56789";		// tab delimited works
	
	$data2a = "xxxxx,yyyyyy,zzzzzz\naaaaaa,bbbbb,ccccc";


	$data3 = "<table border=1 rules=all><tr bgcolor=yellow><th>Col 1 <th>Col 2 <th>Col 3";     // this allows you to use html formatting
	$data3 .= "<tr><td><font color=blue size=3>aaaaaaa<td>bbbbbbbb<td>ccccccccc";
	$data3 .= "<tr><td>xxxxxxxx<td>yyyyyyyy<td>zzzzzzzz<td>=A1";
	$data3 .= "<tr><td>1<td>2<td>3<td><b>=SUM(a4:c4)";
	$data3 .= "</table>";


	$data4 = "<table><tr><td><font size=4><b>Here is the Title</font></b>
				<br>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
				<br><br><font color=blue>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
			 </table>
		    ";
		    
	$data5 =  "Lorem Ipsum is simply dummy text of the printing \n
			and typesetting industry. Lorem Ipsum has been the 
			industry's standard dummy text ever since the 1500s, 
			when an unknown printer took a galley of type and scrambled
			it to make a type specimen book. It has survived not only 
			five centuries, but also the leap into electronic typesetting, 
			remaining essentially unchanged. It was popularised in the 
			1960s with the release of Letraset sheets containing Lorem 
			Ipsum passages, and more recently with desktop publishing
			software like Aldus PageMaker including versions of Lorem Ipsum.
			";


	// writing excel
	   //	$dfw_data 	= $data3;
	   //	$dfw_filename 	= "fileout.xls";              // as you see in data3, you can include formulas in the data
          //echo "<td>1234<td> here is some data provided as an echo ";     // if you echo anything it becomes part of the output

	// writing word
		//$dfw_data      = $data4;
		//$dfw_filename	= "fileout.doc";

	// writing notepad
		//$dfw_data		= $data5;
		//$dfw_filename	= "fileout.txt";
		
	// writing powerpoint
		$dfw_data = $data5;
		$dfw_filename = "testppt.pptx";
		
	// writing Works spreadsheet
		//$dfw_data		= $data2;                     // this works with tab delimited input (not HTML)
		//$dfw_filename	= "fileout.xlr";

	// writing works document
		//$dfw_data      = $data5;
		//$dfw_filename	= "fileout.rtf";

	// writing CSV document
		//$dfw_data      = $data2a;
		//$dfw_filename	= "fileout.csv";



	// echo "<br>xxxxxxxxxxxxxxxxxxxxxxxxxx";  You don't want to do this as it becomes part of the output to the file.




	include $path_global."/desktop_file_write.php";

?>