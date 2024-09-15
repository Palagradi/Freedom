<?php
	include 'connexion.php'; 
?>
<html>
	<head> 
		<title> SYGHOC </title> 
	</head>
	<body>
		<table> 
			<tr> 
				<td>
					<table border='1'>
						<tr> 
							<td WIDTH='400'> CHAMBRE N° </td> 
							
					<?php
						$res=mysql_query('SELECT * FROM taxenuite'); 
						while ($ret=mysql_fetch_array($res)) 
							{
								echo '<tr>';
								
										echo' <td whidth="400"> '; 
											echo $ret[0]; 
										echo '</td>';
									;
							}
					?> 
					</table>
				</td> 
			</tr> 
		</table> 
	</body>
</html> 
	