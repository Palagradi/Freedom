<?php
require("../config.php");

$cv=(isset($_SESSION['cv'])&&(!empty($_SESSION['cv']))) ? $_SESSION['cv']:1; $Qte=$cv;
$Qte = isset($_POST['QteAjeT'])?$_POST['QteAjeT']:NULL;    $Qte = isset($_GET['Qte'])?$_GET['Qte']:$cv;

 mysqli_query($con,"SET NAMES 'utf8'");
//recherche des résultats dans la base de données
$result =   mysqli_query($con, 'SELECT *
                          FROM boisson
                          WHERE   Depot = \'2\' AND (Categorie LIKE \'%' . safe( $_GET['qt'] ) . '%\'  OR designation LIKE \'%' . safe( $_GET['qt'] ) . '%\' OR Conditionne LIKE \'%' . safe( $_GET['qt'] ) . '%\')
                          LIMIT 0,20' );

						  //echo 'SELECT *
                          //FROM boisson
                          //WHERE   Depot = \'bar\' AND designation LIKE \'' . safe( $_GET['qt'] ) . '%\' OR Categorie LIKE \'' . safe( $_GET['qt'] ) . '%\' OR Conditionne LIKE \'' . safe( $_GET['qt'] ) . '%\' OR Prix LIKE \'' . safe( $_GET['qt'] ) . '%\'
                          //LIMIT 0,20' ;
// affichage d'un message "pas de résultats"
if( mysqli_num_rows( $result ) == 0 )
{
?>
    <h5 style="text-align:center; margin:10px 0;color:teal;">Aucune boisson ne correspond à cette recherche</h5>
<?php
}
else
{ 	echo " <table align='center' width='90%' border='0' cellpadding='3' style='margin-top:1px;border-collapse: collapse;font-family:Cambria;'>

    <tr style='border:0px;'><td colspan='8' > <span style='border:0px;font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#4C767A;' ><u>Liste des boissons recherchées </u> </span>
		";
	if(isset($_POST['QteAjeT'])) {
    echo "<body style='background-color:#84CECC; '>";
    $Qte=$_POST['QteAjeT'];
  ?>
    <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="css/bootstrap.min.js"></script>
    <script src="css/jquery-1.11.1.min.js"></script>
    <style>
    a.info {	   position: relative;
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

    <?php
      }
      ?>

    <span style='display:block;float:right;font-weight:bold;'>Quantité : <form  action='searchDrinkF.php?<?php if(isset($_GET['Qte'])) echo "Qte=".$_GET['Qte'];if(isset($_GET['qt'])) echo "qt=".safe( $_GET['qt'] );?>' method='post' id='chgdept' style='display:inline;'>
    <input type='number' id='' name='QteAjeT'   min='1' value='<?php echo$ii=isset($Qte)?$Qte:1; ?>' style='text-align:center;width:75px;-moz-border-radius:7px;-webkit-border-radius:7px;border-radius:7px;' onchange="document.forms['chgdept'].submit();"  onkeyup="document.forms['chgdept'].submit();"></span>
    </td></tr>

     <tr><td> &nbsp;&nbsp;</td></tr>
    		<tr  style='background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;'>
    		<td style="border-right: 2px solid #ffffff" align="center" ><a class='info' href='Bar.php?&trie=1' style='text-decoration:none;color:white;' title="">N° <br/>d'ordre<span style='font-size:0.8em;'></span></a></td>
    			<td style="border-right: 2px solid #ffffff" align="center" ><a class='info' href='Bar.php?&trie=1' style='text-decoration:none;color:white;' title="">Catégorie<span style='font-size:0.8em;'></span></a></td>
    			<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='Bar.php?&trie=2' style='text-decoration:none;color:white;' title=''>Désignation<span style='font-size:0.8em;'></span></a></td>
    			<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='Bar.php?&trie=3' style='text-decoration:none;color:white;' title=''>Conditionnement<span style='font-size:0.8em;'></span></a></td>
    			<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='Bar.php?&trie=4' style='text-decoration:none;color:white;' title=''>Qté en<br/> Stock<span style='font-size:0.8em;'></span></a></td>
    			<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='Bar.php?&trie=4' style='text-decoration:none;color:white;' title=''>Qté ind.<span style='font-size:0.8em;'></span></a></td>
    			<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='Bar.php?&trie=5' style='text-decoration:none;color:white;' title=''>Prix de <br/>vente<span style='font-size:0.8em;'></span></a></td>
    			<td align="center" >Actions</td>
    		</tr>
    	 <input type='hidden' value='<?php if(isset($Qte)) echo $Qte; else echo 1;?>'  id='Qte' />


		<?php //echo "</tr>";

	$cpteur=1; $i=0;
    // parcours et affichage des résultats
    while( $data = mysqli_fetch_object($result))
    {
		if($cpteur == 1)
			{
				$cpteur = 0;
				$bgcouleur = "#DDEEDD";
			}
			else
			{
				$cpteur = 1;
				$bgcouleur = "#dfeef3";
			} $i++;  if($i%2==0)$color="#FC7F3C"; else $color="maroon";

    ?>
    <tr class='rouge1' bgcolor=' <?=$data->Qte_Stock<=0?"red":$bgcouleur; ?>'>
      <td align='center' style='padding:7px;border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><?php echo $i; ?> .</td>
      <td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><?php echo $data->Categorie; ?> </td>
      <td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->designation; ?></td>
      <td align='' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->Conditionne; ?></td>
      <td align='center'  style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->Qte_Stock; ?></td>
      <td align='center'  style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->Qte; ?></td>
      <td align='center'  style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->Prix; ?></td>

      <?php   //$Qte=1;  //$cv=1;
      echo "<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <a class='info' ";
      //if($Qte<=$data->Qte_Stock)  { //if(isset($_GET['QteAj'])) echo $_GET['QteAj'];
      echo "href='FrameDrink.php?numero=".$data->numero."&fd=".$data->designation."&fk=".$data->Qte."&prix=".$data->Prix."&cv=".$cv."&Qte_Stock=".$data->Qte_Stock."&Qte=".$Qte."' ";
      //}
      //else
        //{
        // echo "onclick='JSalert();return false;' ";
      ?>

      <?php  //}
        echo "style='color:".$color.";'><span style='color:#FC7F3C;'>Ajouter</span><i style='font-size:1.4em;' class='fas fa-cart-plus'></i></a></td>";
        ?>

	</tr>

    <?php
    }
}

if(isset($_POST['QteAjeT'])) {
  echo "</body>";
}

/*****
fonctions
*****/
function safe($var)
{	require("../connexion.php");
	$var = mysqli_real_escape_string($con,$var);
	$var = addcslashes($var, '%_');
	$var = trim($var);
	$var = htmlspecialchars($var);
	return $var;
}
?>
