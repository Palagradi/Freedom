<?php
	include_once 'menuprin1.php'; 
	include 'connexion.php'; 
	if (isset($_POST['ok']) and $_POST['ok']=='MODIFIER') 
	{
		if ( (isset($_POST['edit1']) && $_POST['edit1']!='') or (isset($_POST['edit2']) && $_POST['edit2']!='') or 
			(isset($_POST['edit3']) && $_POST['edit3']!='')or (isset($_POST['edit4']) && $_POST['edit4']!='') )  
			{
				$ret=mysql_query("SELECT pass FROM utilisateur WHERE login='".$_POST['edit1']."'");
				$ret1=mysql_fetch_array($ret); 
				if (($_POST['edit2']==$ret1['pass'])and ($_POST['edit3']==$_POST['edit4']))
				{
					$rez=mysql_query("UPDATE utilisateur SET pass='".$_POST['edit3']."' WHERE login='".$_POST['edit1']."'");
					echo "<script language='javascript'>"; 
						echo " alert('Votre mot de passe a été modifié.');";
					echo "</script>"; 
				}
				else 
				{
					echo "<script language='javascript'>"; 
						echo " alert('Idendification erronée .');";
					echo "</script>"; 
					exit(); 
				}
			}
	}
?> 
<html>
	<head> 
		<title> SYGHOC </title> 
	</head>
	<body><br/>
		<table align='center' style='font-size:1.1em;background-color:#D0DCE0;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;'> 
			<tr> 
				<td> 
					<fieldset> 
						<legend align='center'style='font-size:1.3em;color:#DA4E39;'><b> MODIFICATION DE MOT DE PASSE</b> </legend> 
						<form action='modifpass.php' method='post'>
							<table  height='200' style="width:700px;">
								<tr>
									<td> Login: </td>
									<td> <input type='text' name='edit1' /> </td>
								</tr>
								<tr>
									<td>Mot de Passe Actuel : </td>
									<td> <input type='password' name='edit2' /> </td>
								</tr>
								<tr>
									<td> Nouveau Mot de Passe: </td>
									<td> <input type='password' name='edit3' /> </td>
								</tr>
								<tr>
									<td> Confirmation du Mot de Passe: </td>
									<td> <input type='password' name='edit4' /> </td>
								</tr>
								<tr> 
									<td colspan='2' align='center'> <input type='submit' name='ok' value='MODIFIER' style='border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;'/> </td>
								</tr>
							</table>
						</form>
					</fieldset>
				</td>
			</tr>
		</table>
	</body> 
</html>