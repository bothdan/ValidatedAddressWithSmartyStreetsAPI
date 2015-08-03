<!DOCTYPE html>
<html>
<head>
<title>Address Validation 1.0</title>
<meta charset="UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<script>
	function callPHPfile()
		{
			var xmlhttp;
				
			 street = $('#street').val();
			 city = $('#city').val();
			 state = $('#state').val();
			
					if (window.XMLHttpRequest)
					  {// code for IE7+, Firefox, Chrome, Opera, Safari
					  xmlhttp=new XMLHttpRequest();
					  }
					else
					  {// code for IE6, IE5
					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					  }
			xmlhttp.onreadystatechange=function()
			  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
						document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
						}
			  }
			xmlhttp.open("POST","action.php?street="+street+"&city="+city+"&state="+state,true);
			xmlhttp.send();
			//ClearForm();
		}
		
		function ClearForm() {
				
			$('input#street').val('');
			$('input#city').val('');
			$('input#state').val('');
		}
</script>
</head>

<body>
<div class="content-wrap">
	<div class="content">
		<div class="form">
				<div class="title">Address Validation 1.0</div>
				
				<p><label>Street Address: </label><br>
					<input id="street" name="street" type="text" tabindex="1" ><br>
				</p>
				<p><label>City: </label><br>
					<input id="city" name="city" type="text" tabindex="2"><br>
				</p>
				<p><label>State: </label><br>
					<input id="state" name="state" type="text" tabindex="3"><br>
				</p>
<br>				
				<button class="btn" type="button" onclick="callPHPfile()">Submit</button>
				<button class="btn" type="button" onclick="ClearForm()">Reset</button>
		</div>
		<br>
				<div id="myDiv"><div class="msg">Output</div><?php include_once('table.php');?></div>
	</div>
</div>

</body>
</html>