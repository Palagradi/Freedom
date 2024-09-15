<?php
	include 'connexion.php'; 
		echo "<table align='center' border='0' width='' cellpadding='0' cellspacing='0' style='border:0px solid;font-family:Cambria;'> "; 
		echo"<tr> ";
			echo"<td rowspan='2' align='center' ><b>TABLEAU SYNTHETIQUE DE CODIAM POUR LA PERIODE  de  </b>";
	switch ($_POST['se2'])
		{
			case '01': echo '<b><i>'.$_POST['se1'].''.'JANVIER </i></b>'; break; 
			case '02': echo '<b><i>'.$_POST['se1'].' '.'FEVRIER </i></b>'; break;
			case '03': echo '<b><i>'.$_POST['se1'].' '.'MARS </i></b>'; break;
			case '04': echo '<b><i>'.$_POST['se1'].' '.'AVRIL </i></b>'; break;
			case '05': echo '<b><i>'.$_POST['se1'].' '.'MAI </i></b>'; break;
			case '06': echo '<b><i>'.$_POST['se1'].' '.'JUIN </i></b>'; break;
			case '07': echo '<b><i>'.$_POST['se1'].' '.'JUILLET </i></b>'; break;
			case '08': echo '<b><i>'.$_POST['se1'].' '.'AOUT </i></b>'; break;
			case '09': echo '<b><i>'.$_POST['se1'].' '.'SEPTEMBRE&nbsp;&nbsp;</i></b>'; break;
			case '10': echo '<b><i>'.$_POST['se1'].' '.'OCTOBRE </i></b>'; break;
			case '11': echo '<b><i>'.$_POST['se1'].' '.'NOVEMBRE </i></b>'; break;
			case '12': echo '<b><i>'.$_POST['se1'].' '.'DECEMBRE </i></b>'; break;
			default: echo ' '; break;
		}
		switch ($_POST['se5'])
		{
			case '01': echo ' au <b><i>'.$_POST['se4'].' '.'JANVIER</i></b>'; break; 
			case '02': echo ' au <b><i>'.$_POST['se4'].' '.'FEVRIER</i></b>  '; break;
			case '03': echo ' au <b><i>'.$_POST['se4'].' '.'MARS</i></b>  '; break;
			case '04': echo ' au <b><i>'.$_POST['se4'].' '.'AVRIL</i></b>  '; break;
			case '05': echo ' au <b><i>'.$_POST['se4'].' '.'MAI</i></b>  '; break;
			case '06': echo ' au <b><i>'.$_POST['se4'].' '.'JUIN</i></b>  '; break;
			case '07': echo ' au <b><i>'.$_POST['se4'].' '.'JUILLET</i> </b>  '; break;
			case '08': echo ' au <b><i>'.$_POST['se4'].' '.'AOUT</i></b>  '; break;
			case '09': echo ' au <b><i>'.$_POST['se4'].' '.'SEPTEMBRE</i> </b> '; break;
			case '10': echo ' au <b><i>'.$_POST['se4'].' '.'OCTOBRE </i></b> '; break;
			case '11': echo ' au <b><i>'.$_POST['se4'].' '.'&nbsp;NOVEMBRE</i></b>  '; break;
			case '12': echo ' au <b><i>'.$_POST['se4'].' '.'DECEMBRE</i></b>  '; break;
			default: echo ' '; break;
		}
		echo "<b>".$_POST['se3'].'</b> <br><br>'; 
		echo "</td> ";
				echo"</tr> 
		</table> ";
		if (isset($_POST['ok'])&& $_POST['ok']=='OK') 
	{
		$debut=$_POST['se3'].'-'.$_POST['se2'].'-'.$_POST['se1'];	
		$fin=$_POST['se6'].'-'.$_POST['se5'].'-'.$_POST['se4'];	
	
			$exec=mysql_query("SELECT DATEDIFF('$fin','$debut') AS DiffDate");
			$row_Recordset1 = mysql_fetch_assoc($exec);
			$row_Recordset=$row_Recordset1['DiffDate'];
			
			$req = mysql_query("SELECT numch FROM chambre");
			while($data = mysql_fetch_array($req))
			{$count=$data['numch'];
			}
			$totalRows_RecordsetA = mysql_num_rows($req);
			
			$chambre_dispo=$totalRows_RecordsetA*$row_Recordset;
			
			$req = mysql_query("SELECT sum(N_reel) AS N_reel FROM compte,fiche1 WHERE compte.numfiche=fiche1.numfiche AND fiche1.datarriv BETWEEN '$debut' AND '$fin'");
			while($data = mysql_fetch_array($req))
			{$N_reel = $data['N_reel'];
			}
			$taux=100*($N_reel/$chambre_dispo);

			$i = 1;
			$chambre=array("");$chamb=array("");
			$req9 = mysql_query("SELECT nomch FROM chambre ORDER BY numch ");
			while($data9 = mysql_fetch_array($req9))
			{$chambre[$i] = $data9['nomch'];
			$chamb[$i] = $data9['numch'];
			 $i++;
			}
			$totalRows_Recordset = mysql_num_rows($req9);
		
		echo "<table align='center' border='1' width='50%' cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'> "; 

		$req9 = mysql_query("SELECT DISTINCT compte.numch AS nbre FROM compte,fiche1,chambre  WHERE fiche1.numfiche=compte.numfiche AND chambre.numch=compte.numch AND fiche1.datarriv BETWEEN '$debut' AND '$fin' AND fiche1.datdep BETWEEN '$debut' AND '$fin'");
			while($data9 = mysql_fetch_array($req9))
			{$count=$data9['nbre'];
			}
		$nbre1=mysql_num_rows($req9);
		$req10 = mysql_query("SELECT DISTINCT compte.numch AS nbre FROM compte,view_fiche2,chambre  WHERE view_fiche2.numfiche=compte.numfiche AND chambre.numch=compte.numch AND view_fiche2.datarriv BETWEEN '$debut' AND '$fin' AND view_fiche2.datdep BETWEEN '$debut' AND '$fin'");			
			while($data10 = mysql_fetch_array($req10))
			{$count2=$data10['nbre'];
			}
		$nbre2=mysql_num_rows($req10);	
		$req11 = mysql_query("SELECT DISTINCT fiche1.numcli  AS nbre FROM compte,fiche1,chambre  WHERE fiche1.numfiche=compte.numfiche AND chambre.numch=compte.numch AND fiche1.datarriv BETWEEN '$debut' AND '$fin' ");
			while($data11 = mysql_fetch_array($req11))
			{$count3=$data11['nbre'];
			}
		$nbre3=mysql_num_rows($req11);	
		$req12 = mysql_query("SELECT DISTINCT view_fiche2.numcli  AS nbre FROM compte,view_fiche2,chambre  WHERE view_fiche2.numfiche=compte.numfiche AND chambre.numch=compte.numch AND view_fiche2.datarriv BETWEEN '$debut' AND '$fin' ");			
			while($data12 = mysql_fetch_array($req12))
			{$count4=$data12['nbre'];
			}
		$nbre4=mysql_num_rows($req12);	
			echo"<tr> "; 			
			echo "<td> "; echo "Nombre de chambres louées";   echo"</td> ";
			echo "<td align='center'> "; echo $chambre=$nbre1+$nbre2;  echo"</td> ";
			echo"</tr> ";
			
			echo"<tr> "; 			
			echo "<td > "; echo "Nombre de clients";   echo"</td> ";
			echo "<td align='center'> "; echo $client=$nbre3+$nbre4;  echo"</td> ";
			echo"</tr> ";
			
			echo"<tr> "; 			
			echo "<td> "; echo "Indice de fréquentation";   echo"</td> ";
			echo "<td align='center'> "; echo round(($client/$chambre)*100,2);  echo"%</td> ";
			echo"</tr> ";
			
			echo"<tr> "; 			
			echo "<td> "; echo "Taux d'occupation";   echo"</td> ";
			echo "<td align='center'> "; echo  $taux=round($taux,2); echo"%</td> ";
			echo"</tr> ";
		//}		
					
		
	
		echo"</table> "; 
		
				
		echo "<table align='center' border='1' width='50%' cellpadding='0' cellspacing='0' style='border:0px solid;font-family:Cambria;'> "; 
		echo"<tr> ";
			echo"<td rowspan='2' align='center' > <u><b><br/> NB: </b></u>Les renseignements contenus dans ce questionnaire sont confidentiels; ils sont couverts par le secret statistique. les résultats seront publié sous formes anonyme conformement à l'article 25 de la loi n° 99-014 du 29 janvier 1999, portant création, organisation et fonctionnement du Conseil National de la Statistique (CNS)</td> ";
			echo"</td> ";
		echo"</tr> 
		</table> ";
	}
	?>