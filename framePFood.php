<?php
	require("config.php");

	//$fd=!empty($_GET['fd'])?$_GET['fd']:NULL; $fk=!empty($_GET['fk'])?$_GET['fk']:NULL; $prix = !empty($_GET['prix'])?$_GET['prix']:NULL;
	//$_SESSION['origin']="drink";
	//$cv=(isset($_SESSION['cv'])&&(!empty($_SESSION['cv']))) ? $_SESSION['cv']:1;
	
 	$table=(isset($_SESSION['table'])&&(!empty($_SESSION['table']))) ? $_SESSION['table']:0;	
	$Qte = isset($_GET['Qte'])?$_GET['Qte']:0;   
	$numero = !empty($_GET['numero'])?$_GET['numero']:0;

	
if(($numero>0)&&($Qte>0)){echo "&nbsp;";
	$rek="SELECT * FROM plat WHERE numero='".$numero."'";
	$query = mysqli_query($con,$rek) or die (mysqli_error($con));$data=mysqli_fetch_assoc($query); $Qte_Stock=$data['NbreJ'];
	if(!empty($TPS_2)&&($TPS_2==1))  $tva=0 ; else $tva=round($data['prix']/(1+$TvaD)*$TvaD);
	
	if (($Qte>$Qte_Stock)||($Qte_Stock==0))
	{	echo "<script src='js/sweetalert.min.js'></script>";
		echo "<script>";
		echo "swal('Quantité demandée supérieure à la quantité en stock')";
		echo "</script>";

	}else {
		$rk="SELECT * FROM tableEnCours WHERE LigneCde='".$data['designation']."' AND LigneType='1' AND numTable='".$table."' AND created_at='".$Jour_actuel."' AND Etat <> 'Desactive'";
		$req1 = mysqli_query($con,$rk) or die (mysqli_error($con));
		if(mysqli_num_rows($req1)>0){
			$data0=mysqli_fetch_assoc($req1); $Qte0=$Qte+$data0['qte'];
			$pre_sql1="UPDATE tableEnCours SET qte='".$Qte0."',updated_at='".$Heure_actuelle."' WHERE Num = '".$data0['Num']."' AND Etat <> 'Desactive'";
			$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));
		}
		else {
			$pre_sql1="INSERT INTO tableEnCours VALUES(NULL,'".$numero."','".$table."','".$data['designation']."','1','','".$data['prix']."','".$Qte."','','','".$Jour_actuel."','".$Heure_actuelle."','".$tva."')";
			$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));	
		}

		$ref="BAR".$numero ; $quantiteF=$Qte_Stock-$Qte;
		
		$re="INSERT INTO operation VALUES(NULL,'".$ref."','Vente ','".$numero."','".$Qte_Stock."','".$Qte."','".$quantiteF."','".$Jour_actuel."','".$Heure_actuelle."','','".$Qte."')";
		$req=mysqli_query($con,$re);

		echo $update="UPDATE plat SET NbreC=NbreC+'".$Qte."',Nbre=Nbre-'".$Qte."' WHERE numero='".$_GET['numero']."' AND state=1 ";
		$Query=mysqli_query($con,$update);
		
  		echo "<script language='javascript'>";
		echo "window.close();";
		echo "window.opener.location.reload();";
		echo "</script>";   
	}
}

?>

<body style='background-color:#84CECC; '>
<link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<link href="js/datatables/dataTables.bootstrap4.css" rel="stylesheet">
	
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

		<script src="js/sweetalert.min.js"></script>

		<script type="text/javascript" >
		function JSalertQte(param){
		swal("QUANTITE DE PLATS ",{
		  content: {
			element: "input",
			attributes: {
			  placeholder: "Saisissez ici la quantité commandée ",
			  type: "number",
			  min : "1",
			},
		  },
		})
			.then((value) => {
				//var numero = param; 
				document.location.href='frameFood.php?Qte='+value+'&numero='+param;
			});
		}
		</script>

		<script type="text/javascript" >

			$(document).ready( function() {
		  // détection de la saisie dans le champ de recherche
		  $('#qt').keyup( function(){
			$field = $(this);
			$('#Rresults').html(''); // on vide les resultats

/* 			//document.getElementById('q').style.backgroundColor="#84CECC";
			var fiche =  document.getElementById('fiche');
			$('#ajax-loader').remove(); // on retire le loader */

			// on commence à traiter à partir du 2ème caractère saisie
			if( $field.val().length > 1 )
			{  $('#Rresults').html('');
			  // on envoie la valeur recherché en GET au fichier de traitement
			  $.ajax({
			type : 'GET', // envoi des données en GET ou POST
			url : 'searchFoodF.php' , // url du fichier de traitement
			data : 'qt='+$(this).val() , // données à envoyer en  GET ou POST
			beforeSend : function() { // traitements JS à faire AVANT l'envoi
				$field.after('<img src="logo/wp2d14cca2.gif" alt="loader" id="ajax-loader" />'); // ajout d'un loader pour signifier l'action
			},
			success : function(data){ // traitements JS à faire APRES le retour d'ajax-search.php
				$('#ajax-loader').remove(); // on enleve le loader
				$('#Rresults').html(data); // affichage des résultats dans le bloc
			}
			  });
			}
		  });
		});
		</script>


<style>
 .button {
  background-color: orange;
  border: none;
  color: white;font-weight:bold;
  padding-left: 2px; padding-right: 2px;  padding-top: 2px; padding-bottom: 0px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 15px;
  margin: 0px 0px;cursor: pointer;


</style>

<br/>
<!------ Include the above in your HEAD tag ---------->
<form class="ajax" action="" method="get">
	<p align='center'>
		 <input style='text-align:center;font-size:1.5em;background-color:#EFFBFF;width:500px;padding:3px;border:1px solid #aaa;-moz-border-radius:7px;-webkit-border-radius:7px;border-radius:7px;height:35px;line-height:22px;' type="text" name="qt" id="qt" 
		 placeholder="Rechercher parmi la liste des portions du <?php echo $Jour_actuel; ?>"/> 
	</p>
</form>
<!--fin du formulaire-->
<div id="results">

</div>

<!--preparation de l'affichage des resultats-->
<div id="Rresults">

<div class="table-responsive">
	<table id="dataTable_"  align='center' width='90%' border='0' cellpadding='3' style='margin-top:1px;border-collapse: collapse;font-family:Cambria;'>
		<thead>
		<tr><td> &nbsp;&nbsp;</td></tr>
		<tr  style='background-color:gray;color:white;font-size:1.2em; padding-bottom:5px;'>
			<td style="border:2px solid #ffffff" align="center">#</td>
			<td style="padding:2px;border:2px solid #ffffff" align="center" ><g style='color:yellow;'>Catégorie</g><span style='font-size:0.8em;'></td>
			<td style="padding:2px;border:2px solid #ffffff" align="center" >Désignation <br/>plat principal<span style='font-size:0.8em;'></td>
			<td style="padding:2px;border:2px solid #ffffff" align="center" ><g style='color:yellow;'>Désignation<br/>Portion</g><span style='font-size:0.8em;'></td>
						<td style="padding:2px;border:2px solid #ffffff" align="center" >Quantité<br/>&nbsp;disponible<span style='font-size:0.8em;'></td>
			<td style="padding:2px;border:2px solid #ffffff" align="center" ><g style='color:yellow;'>Prix <br/> portion</g><span style='font-size:0.8em;'></td>
			<td style='padding:2px;border:2px solid #ffffff;' align="center" >Actions</td>
		</tr>
		</thead>
		<tbody id="">
<?php 
	mysqli_query($con,"SET NAMES 'utf8'");
	$req="SELECT * FROM plat,categorieplat,menu,portion WHERE portion.numPlat=plat.numero AND categorieplat.id=plat.categPlat AND menu.id=plat.categMenu ORDER BY NbreJ DESC";
	$result=mysqli_query($con,$req);
	$cpteur=1;$i=0;$j=0;
    // parcours et affichage des résultats
    while( $data = mysqli_fetch_object($result))
    { $j++;
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
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>&nbsp;<?php echo $data->catPlat; ?> </td>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>&nbsp; <?php echo $data->designation; ?></td>
				<td align='left'  style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->libellePortion; ?></td>
								<td align='center'  style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->Nbre; ?></td>
				<td align='center'  style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->prix; ?></td>				
				<td align='center'  style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> 
				<a class='info' onclick='JSalertQte(<?php echo $data->numero ?>);return false;' 
				<?php
				if($data->NbreJ>0)
					echo "style='color:".$color.";'><img src='logo/".$plus.".png' alt='' width='25' height='25' border='0'/><span style='color:#FC7F3C;'>Ajouter</span></a>";
				echo "</td>";
				}
				?>
			</tr> 
		</tbody>
		<tfoot></tfoot>
	</table>
</div>
</div>		
		<script src="js/datatables/jquery.dataTables.js"></script>
        <script src="js/datatables/dataTables.bootstrap4.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin.min.js"></script>
        <!-- Custom scripts for this page-->
        <script src="js/sb-admin-datatables.min.js"></script>
        <script src="js/sb-admin-charts.min.js"></script>
        <script src="js/custom.js"></script>
		
</body>
