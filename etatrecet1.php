<?php
//session_start();
 echo "	<table align='center' style='float:left;margin-left:15%;'>
			<tr>
				<td style='font-size:1.3em;'>
					<B>TABLEAU RECAPITULATIF DES RECETTES ";   if($_POST['choix']==2) echo "&nbsp;CHAMBRES&nbsp;"; else echo "&nbsp;SALLES&nbsp;"; echo "POUR LA PERIODE du </B>&nbsp;&nbsp;".$_POST['se1']."/".$_POST['se2']."/".$_POST['se3']."&nbsp;&nbsp;<b>Au</b>&nbsp;&nbsp;".$_POST['se4']."/".$_POST['se5']."/".$_POST['se6']."
				</td>
			</tr>
	</table>";
 	//echo '<br><br>';

if (isset($_POST['VALIDER'])&& $_POST['VALIDER']=='Valider')
	{
	if(isset($_POST['excel']) &&  $_POST['excel']!=1)
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=''><img src='logo/im10.jpg' width='80' id='button-imprimer' class='noprt' style='clear:both;'></a>";
	if($_POST['check']!=1)
		{if($_POST['choix']==1)
			{include 'recette_condense.php';

			}
		if($_POST['choix']==2)
			{ include 'recette_chambre_NRP.php';
			//echo 1;
			}
		if(($_POST['choix']!=1)&&($_POST['choix']!=2))
			{ include 'recette_salleNRP.php';
			}
		}
	else
		{if($_POST['choix']==1)
			{include 'recette_condenseNRP.php';
			}
		if($_POST['choix']==2)
			{include 'recette_chambre.php';
			//echo 2;
			}

		if(($_POST['choix']!=1)&&($_POST['choix']!=2))
			{ include 'recette_salle.php';
			}
		}
	}
?>
