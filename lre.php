<?php
session_start(); 
		if($_SESSION['poste']==cpersonnel)
		include 'menucp.php'; 
	   	   if($_SESSION['poste']==agent)
		include 'menuprin1.php'; 
			   if($_SESSION['poste']==directrice)
		include 'menudirec.php'; 
			   if($_SESSION['poste']==admin)
		include 'admin.php';
		include 'connexion.php'; 
		include 'chiffre_to_lettre.php';
?>
<html>
	<head> 
		<title> SYGHOC </title> 
		
	</head>
	<body>
		<table align='center'> 
			<tr>
				<td align='center'>
					<center> <font color='green' size='7' >
					<?php 	echo "RECETTE JOURNALIERE";	?>
					</font> </center> <br/> 
				</td>
			</tr>
			
		<tr>
				<td align='center'>
					<B>
					<B> <?php 	
				$mt=0; 	$i=1; $cpteur=1;
				$res=mysql_query("SELECT * FROM encaissement WHERE datencaiss='".date('Y-m-d')."' and agenten='".$_SESSION['login']."'"); 
				while ($ret=mysql_fetch_array($res)) 
					{			$mt=$mt+$ret['ttc_fixe']*$ret['np'].' F CFA'; 
					}
					
					echo'<span style=""> Agent:&nbsp;'; echo ucfirst($_SESSION['login']); echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<B> TOTAL: &nbsp;&nbsp;</b>'.$mt.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:  '; echo date('d-m-Y'); ?> </B> 
					<hr noshade size=3>
				</td>
		</tr>

			<tr> 
				<td>
					<table border='1'>
					
						<tr style='background-color:#EEEE99;'> 
							<td WIDTH='200' align='center'><B> Référence  </B></td> 
							<td WIDTH='200' align='center'><B> Type d'encaissement</B></td> 
							<td WIDTH='200' align='center'><B> Montant</B></td> 
							
						</tr>
					<?php
						$mt=0; 	$i=1; $cpteur=1;
						$res=mysql_query("SELECT * FROM encaissement WHERE datencaiss='".date('Y-m-d')."' and agenten='".$_SESSION['login']."'AND ref NOT IN
				(SELECT ref FROM encaissement,fiche2 WHERE datencaiss='".date('Y-m-d')."' and encaissement.agenten='".$_SESSION['login']."' AND encaissement.ref=fiche2.numfiche)
				AND Type_encaisse NOT IN
				('Reservation chambre','Reservation salle')"); 
						while ($ret=mysql_fetch_array($res)) 
							{if($cpteur == 1)
								{
									$cpteur = 0;
									$bgcouleur = "#acbfc5";
								}
								else
								{
									$cpteur = 1;
									$bgcouleur = "#dfeef3";
								}
								echo"<tr bgcolor='".$bgcouleur."'>"; 
								//for ($i=0;$i<3;$i++)
								//	{
										echo' <td width="200" align="center"> '; echo "&nbsp;&nbsp;".$ret['ref']; echo '</td>';
										echo' <td width="200" align="center"> '; echo "&nbsp;&nbsp;".$ret['Type_encaisse']; echo '</td>';
										echo' <td width="200" align="center"> '; echo "&nbsp;&nbsp;".$ret['ttc_fixe']*$ret['np']; echo '</td>';
									//}
								echo'</tr>';
								$mt=$mt+$ret['ttc_fixe']*$ret['np'].' F CFA'; 
							}		
				//echo "SELECT ref,Type_encaisse,sum(ttc_fixe*np) AS somme FROM encaissement,fiche2 WHERE datencaiss='".date('Y-m-d')."' and encaissement.agenten='".$_SESSION['login']."' AND encaissement.ref=fiche2.numfiche GROUP BY fiche2.numfiche";			
	
$res=mysql_query("SELECT ref,Type_encaisse,sum(ttc_fixe*np) AS somme FROM encaissement,fiche2 WHERE datencaiss='".date('Y-m-d')."' and encaissement.agenten='".$_SESSION['login']."' AND encaissement.ref=fiche2.numfiche GROUP BY fiche2.numfiche"); 
						while ($ret=mysql_fetch_array($res)) 
							{if($cpteur == 1)
								{
									$cpteur = 0;
									$bgcouleur = "#acbfc5";
								}
								else
								{
									$cpteur = 1;
									$bgcouleur = "#dfeef3";
								}
								echo"<tr bgcolor='".$bgcouleur."'>"; 
								//for ($i=0;$i<3;$i++)
								//	{
										echo' <td width="200" align="center"> '; echo "&nbsp;&nbsp;".$ret['ref']; echo '</td>';
										echo' <td width="200" align="center"> '; echo "&nbsp;&nbsp;".$ret['Type_encaisse']; echo '</td>';
										echo' <td width="200" align="center"> '; echo "&nbsp;&nbsp;".$ret['somme']; echo '</td>';
									//}
								echo'</tr>';
								$mt=$mt+$ret['somme'].' F CFA'; 
							}
							
							
						
						$res=mysql_query("SELECT  ref,Type_encaisse,tarif,ttc_fixe FROM encaissement WHERE datencaiss='".date('Y-m-d')."' and encaissement.agenten='".$_SESSION['login']."' AND encaissement.Type_encaisse='Reservation chambre'
						UNION
						SELECT  ref,Type_encaisse,tarif,ttc_fixe FROM encaissement WHERE datencaiss='".date('Y-m-d')."' and encaissement.agenten='".$_SESSION['login']."' AND encaissement.Type_encaisse='Reservation salle'"); 
						while ($ret=mysql_fetch_array($res)) 
							{if($cpteur == 1)
								{
									$cpteur = 0;
									$bgcouleur = "#acbfc5";
								}
								else
								{
									$cpteur = 1;
									$bgcouleur = "#dfeef3";
								}
								echo"<tr bgcolor='".$bgcouleur."'>"; 
								//for ($i=0;$i<3;$i++)
								//	{
										echo' <td width="200" align="center"> '; echo "&nbsp;&nbsp;".$ret['ref']; echo '</td>';
										echo' <td width="200" align="center"> '; echo "&nbsp;&nbsp;".$ret['Type_encaisse']; echo '</td>';
										echo' <td width="200" align="center"> '; echo "&nbsp;&nbsp;".$ret['tarif']*$ret['ttc_fixe']; echo '</td>';
									//}
								echo'</tr>';
								$mt=$mt+$ret['sommen'].' F CFA'; 
							}
					?>  
						<td> </td> 
					</table>
				</td> 
			</tr> 
			
			<tr> 
				<td WIDTH='' align='left'><B> TOTAL: &nbsp;&nbsp;</b> <?php echo $mt; ?> </B>
				 &nbsp;&nbsp;(<?php echo chiffre_en_lettre($mt, $devise1='CFA', $devise2=''); ?>)</td> 
			</tr>
			
			<tr> 
				<td WIDTH='' align='left'> <br/> <b>Pour Consulter la recette d'une période donnée, <a href='recette2.php?agent=1' style='text-decoration:none;'> Cliquez ici</a></b>
				</td> 
			</tr>
						
		</table> 
	</body>
</html> 
	