<html>
<head>
<title>Error</title>
<style type="text/css">

body {
background-color:	#fff;
margin:				40px;
font-family:		Lucida Grande, Verdana, Sans-serif;
font-size:			12px;
color:				#000;
}

td {
	font-family:		Lucida Grande, Verdana, Sans-serif;
	font-size:			12px;
	color:				#000;
}

#content  {
border:				#999 1px solid;
background-color:	#fff;
padding:			20px 20px 12px 20px;
}

h1 {
font-weight:		bold;
font-size:			20px;
color:				#990000;
margin: 			0 0 4px 0;
}
</style>
</head>
<body>
	<div id="content">
		<table>
			<tr>
				<td valign="middle"><img src="<?php echo EVO_PUBLIC_URL;?>img/logo.gif" border="0"></td>
				<td valign="middle" style="padding-left: 50px;">
					<h1>Fatal Error</h1>
					<?php echo $message; ?>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>