<?php
include_once'menu.php';


?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title><?php echo $title; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="bootstrap/customize.css" rel="stylesheet">
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<meta name="viewport" content="width=device-width">
		<style>
			.alertify-log-custom {
				background: blue;
			}
			a:hover {
			text-decoration:underline;background-color: gold;color:maroon;
			}
					[type="checkbox"]:not(:checked),
		[type="checkbox"]:checked {
		  position: absolute;
		  left: -9999px;
		}
		 
		[type="checkbox"]:not(:checked) + label,
		[type="checkbox"]:checked + label {
		  position: relative; 
		  padding-left: 25px; 
		  cursor: pointer;    
		}
		
		[type="checkbox"]:not(:checked) + label:before,
		[type="checkbox"]:checked + label:before {
		  content: '';
		  position: absolute;
		  left:0; top: 2px;
		  width: 17px; height: 17px;
		  border: 1px solid #aaa;
		  background: #f8f8f8;
		  border-radius: 3px; 
		  box-shadow: inset 0 1px 3px rgba(0,0,0,.3) 
		}
		 

		[type="checkbox"]:not(:checked) + label:after,
		[type="checkbox"]:checked + label:after {
		  content: '✔';
		  position: absolute;
		  top: 0; left: 4px;
		  font-size: 14px;
		  color: #09ad7e;
		  transition: all .2s;
		}

		[type="checkbox"]:not(:checked) + label:after {
		  opacity: 0; 
		  transform: scale(0); 
		}

		[type="checkbox"]:checked + label:after {
		  opacity: 1; 
		  transform: scale(1); 
		}

		[type="checkbox"]:disabled:not(:checked) + label:before,
		[type="checkbox"]:disabled:checked + label:before {
		  box-shadow: none;
		  border-color: #bbb;
		  background-color: #ddd;
		}

		[type="checkbox"]:disabled:checked + label:after {
		  color: #999;
		}

		[type="checkbox"]:disabled + label {
		  color: #aaa;
		}
		 

		[type="checkbox"]:checked:focus + label:before,
		[type="checkbox"]:not(:checked):focus + label:before {
		  border: 1px dotted blue;
		}
		</style>
	</head>
	<body  style="margin-top:-1.2%;">
	<div align="" style="">
	<table  WIDTH="auto" style='border:2px solid black;margin: 85px auto;' class="">
		<tr>
			<td colspan='2' align='center' style=''><a href=''>
			<img title='' src='logo/chambre.jpg' width='100%' height='200'/>
			<input type='checkbox'  id='test1' <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?>><label for="test1"><h5 style=''>HEBERGEMENT </h5><label> 
			</a>
			</td>

		</tr>
		<tr>
			<td style=''><a href=''>
			<img title='' src='logo/stock.jpg' width='300' height='200'/><br/>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='checkbox'  id='test2' style=''><label for="test2"><h5 style=''>ECONOMAT</h5><label> 
			
			</a>
			</td>
			<td><a href=''>
			<img title='' src='logo/Resto.jpg' width='300' height='200'/><br/>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='checkbox'  id='test3' <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?>><label for="test3"><h5 style=''>RESTAURATION</h5><label> 
			</a>
			</td>
		</tr>
	</table>

	</div>
	</body>
</html>
<?php
	// $Recordset1->Close();
?>
