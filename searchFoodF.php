<?php
require("config.php");

 mysqli_query($con,"SET NAMES 'utf8'");
//recherche des résultats dans la base de données
$result =   mysqli_query($con, 'SELECT * FROM plat,categorieplat,menu WHERE categorieplat.id=plat.categPlat AND menu.id=plat.categMenu AND (categMenu LIKE \'%' . safe( $_GET['qt'] ) . '%\'  OR catPlat LIKE \'%' . safe( $_GET['qt'] ) . '%\' OR designation LIKE \'%' . safe( $_GET['qt'] ) . '%\')
                          LIMIT 0,20' );

// affichage d'un message "pas de résultats"
if( mysqli_num_rows( $result ) == 0 )
{
?>
    <h5 style="text-align:center; margin:10px 0;color:teal;">Aucune boisson ne correspond à cette recherche</h5>
<?php
}
else
{ 	echo " <table align='center' width='90%' border='0' cellpadding='3' style='margin-top:1px;border-collapse: collapse;font-family:Cambria;'>";

  ?>
    <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="css/bootstrap.min.js"></script>
    <script src="css/jquery-1.11.1.min.js"></script>
    <style>
    a.info {	  
			position: relative;
    		   color: black;
    		   text-decoration: none;
    		   border-bottom: 1px gray none; /* On souligne le texte. */
    		}
    		a.info span {
    		   display: none; /* On masque l'infobulle. */
    		}
    		a.info:hover {
    		   background: none; /* Correction d'un bug d'Internet Explorer. */
    		   z-index: 500; /* On définit une valeur pour l'ordre d'affichage. */
    		   cursor: pointer; /* On change le curseur par défaut par un curseur d'aide. */
    		}
    		a.info:hover span {
    		   display: inline; /* On affiche l'infobulle. */
    		   position: absolute;
    		   white-space: nowrap; /* On change la valeur de la propriété white-space pour qu'il n'y ait pas de retour à la ligne non désiré. */
    		   top: 25px; /* On positionne notre infobulle. */
    		   left: 20px;
    		   background: white;
    		   color: green;
    		   padding: 3px;
    		   border: 1px solid green;
    		   border-left: 4px solid green;
    		   border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;
    		}
    </style>
    <link href="fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet">
    <link href="css/customize.css" rel="stylesheet"><script type="text/javascript" src="js/fonctions_utiles.js"></script>

</tr>
	<thead>
		<tr><td> &nbsp;&nbsp;</td></tr>
		<tr  style='background-color:gray;color:white;font-size:1.2em; padding-bottom:5px;'>
			<td style="border:2px solid #ffffff" align="center">#</td>
			<td style="padding:2px;border:2px solid #ffffff" align="center" >Catégorie plat<span style='font-size:0.8em;'></td>
			<td style="padding:2px;border:2px solid #ffffff" align="center" >Désignation<span style='font-size:0.8em;'></td>
			<td style="padding:2px;border:2px solid #ffffff" align="center" >Nbre de plats<br/>&nbsp;disponibles<span style='font-size:0.8em;'></td>
			<td style="padding:2px;border:2px solid #ffffff" align="center" >Prix de vente<span style='font-size:0.8em;'></td>
			<td style='padding:2px;border:2px solid #ffffff;' align="center" >Actions</td>
		</tr>
		</thead>

		<?php //echo "</tr>";

	$cpteur=1; $i=0;$j=0;
    // parcours et affichage des résultats
    while( $data = mysqli_fetch_object($result))
    {
		$j++;
		if($cpteur == 1)
			{
				$cpteur = 0;
				$bgcouleur = "#DDEEDD";
			}
			else
			{
				$cpteur = 1;
				$bgcouleur = "#dfeef3";
			}  $i++;  if($i%2==0){$color="#FC7F3C";$plus="plus1"; }else {$color="maroon";$plus="plus2";}

    ?>
		 	<tr class='rouge1' bgcolor=' <?=$data->NbreJ<=0?"gray":$bgcouleur; ?>'>
			  <td align='center' style='padding:7px;border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><?php echo $j; ?>.</td>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><?php echo $data->catPlat; ?> </td>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->designation; ?></td>
				<td align='center'  style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->NbreJ; ?></td>
				<td align='center'  style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->prix; ?></td>	
				
				<td align='center'  style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> 
				<a class='info' onclick='JSalertQte(<?php echo $data->numero ?>);return false;' 
				<?php
				if($data->NbreJ>0)
					echo "style='color:".$color.";'><img src='logo/".$plus.".png' alt='' width='25' height='25' border='0'/><span style='color:#FC7F3C;'>Ajouter</span></a>";
				echo "</td>";
		?>
	</tr>

    <?php
    }
}


/*****
fonctions
*****/
function safe($var)
{	require("connexion.php");
	$var = mysqli_real_escape_string($con,$var);
	$var = addcslashes($var, '%_');
	$var = trim($var);
	$var = htmlspecialchars($var);
	return $var;
}
?>
