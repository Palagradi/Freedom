<?php
		include 'menu.php'; 
?>
<html>
	<head> 
		<title> SYGHOC </title> 
		<script type="text/javascript" src="date-picker.js"></script>
	</head>
	<body bgcolor='azure' style="margin-top:-20px;"><br/>
	<div align="" style="margin-top:0%;">
		<form  action='reediter_facture.php?agent=1' method='post' name='recette2'>
			 <br/> <table align='center'style='font-size:1.1em;'>				
				<tr> 
					<td style='color:#DA4E39;'> <center> <font color='green' size='6' >REEDITION DE FACTURE </font> </center> </td> 
				</tr>
			</table> <br/> 
			<table align='center'>
				
				</tr> 
				<tr>
					<td style='font-style:italic;'>Pendant toute la durée de votre connexion, et tant que vous n'avez pas clôturé votre point de caisse,<br/>
					vous pouvez réediter une facture. Ci-dessous la liste des factures que vous avez émises pour les clients.
					</td>				
				</tr>
		</table>
		
	<table align="center" width="" border="0" cellspacing="0" style="margin-top:30px;border-collapse: collapse;font-family:Cambria;">
			<tr>
				<td>
					<b><span style='color:#DA4E39;font-size:1.2em;'>Sélectionnez la période</span></b>
				</td>
			</tr>

	</table>
	<table align='center'>
				<td><br/><b>Du: </b></td>
				<td>
					<br/><input type='text' name='debut' id='' size='20' readonly style='' value''/>
				   <a href="javascript:show_calendar('recette2.debut');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
					 <img src="logo/cal.gif" style="border:1px solid blue;" alt="calendrier" title="calendrier"></a>
				</td>
				<td> <br/><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AU: </b></td>
				<td>
					<br/><input type="text" name="fin" id="" size="20" readonly style='<?php if($etat1_4==1)echo"background-color:#FDF1B8;";?>' value="" />
				   <a href="javascript:show_calendar('recette2.fin');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
					 <img src="logo/cal.gif" style="border:1px solid blue;" alt="calendrier" title="calendrier"></a>
				</td>
				<td><br/>&nbsp;&nbsp;&nbsp;<input class="mybutton" type='submit' name='ok' value='OK'/></td> 
				
				<input type='hidden' name='agent' value='<?php echo $agent;?>'/>			
				
				</tr>
	</table>
	</form>
	</div>
	</body>
	<?php
	if (isset($_POST['ok'])&& $_POST['ok']=='OK') 
	{
	}
	?>
	
</html>