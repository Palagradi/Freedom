<?php
include_once'menu.php'; $c=!empty($_GET['c'])? $_GET['c']:NULL;$d=!empty($_GET['d'])? $_GET['d']:NULL;
?>
<html>
	<head> 
		<link href="fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet">
			<script type="text/javascript" src="js/date-picker.js"></script>
			<script type="text/javascript" >
				function edition() { options = "Width=700,Height=700" ; window.open( "receipt2.php", "edition", options ) ; } 
			</script><link rel="Stylesheet" href='css/table.css' />
	</head>
	<style>
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

		.bouton2 {
			border-radius:12px 0 12px 0;
			background: white;
			border:2px solid #B1221C;
			color:#B1221C;
			font:bold 12px Verdana;
			height:auto;font-family:cambria;font-size:0.9em;
		}
		.bouton2:hover{color:white;
			cursor:pointer;background-color: #B1221C;border:2px solid #B1221C;
		}
	</style>
	<body bgcolor='azure' style="">

		<div align="" style="font-family:Cambria;margin-top:-40px;"><form action='indicHotelR2.php?menuParent=Statistiques' method='post' name='indicHotelR'>
			 
	<table  WIDTH="800" style='margin: 50px auto;background-color:#D0DCE0;color:#444739;' id="tab">
		<tr>
	<td colspan='4'>&nbsp;
	</td>
	</tr>
	<tr>
	<td colspan='4'>
		<h4 ALIGN='CENTER' style='font-weight:bold;color:maroon;'>LES INDICATEURS DE PERFORMANCE EN RESTAURATION</h4>
	</td>
	</tr>

	<tr style=''><td colspan='4' align='center'>PERIODE DU :&nbsp;&nbsp;<input type='date' name='ladate' id='ladate'  required />

	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AU :&nbsp;&nbsp;<input type='date' name='ladate2' id='ladate2'  required /> </td></tr>
		<tr>
			<td ><br/><span style='font-weight:bold;color:maroon;font-size:1.1em;font-style:italic;'>Les Indicateurs de Performance Commerciale</span></td>
			<td align='right'><br/> <span style='font-size:0.9em;'>
			<?php 
				if(empty($c)) 
						echo "<a href='indicHotelR.php?menuParent=Restauration&c=1' style='color:green;' ><b>Tout cocher</b>";
				else if(!empty($c)&& ($c==1))
					{	echo "<a href='indicHotelR.php?menuParent=Restauration&d=1' style='color:green;' ><b>Tout décocher</b>";
					}
				else {
					}
				?>
			</a> </span>
			</td>
		</tr>
	<tr><td >&nbsp;</td></tr>
		<tr>
			<td style=''>
			    <input type="checkbox" id="test1" <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?> ><label for="test1" ><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>
				C’est l’équivalent du taux d’occupation en hébergement, il <br/>nous  renseigne sur le nombre de repas que le restaurant a vendu.</span>TAUX DE REMPLISSAGE</a></label>
			</td>
			<td><input type='checkbox'  id="test2" <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?> ><label for="test2"><a href='' class='info' ><span style='color:#494039;'>
				Il nous permet de connaitre la dépense moyenne consentie par les clients.</span>TICKET MOYEN</a></label>			
			</td>
		</tr>
		<tr>
			<td style=''><input type='checkbox'  id="test3"  <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?>><label for="test3"><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>
				Il indique la vente d’un plat par rapport aux autres plats</span>INDICE DE VENTE</a></label>
			</td>
			<td><input type='checkbox'  id="test4" <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?> ><label for="test4"><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>
			Il indique le nombre de fois qu’un plat est présenté sur la carte.</span>INDICE DE PRÉSENTATION</a></label>
			
			</td>
		</tr>
		<tr>
			<td style=''><input type='checkbox'  id="test3"  <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?>><label for="test3"><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>
				Il permet à l’entreprise de connaître la popularité d’un plat.</span>INDICE DE POPULARITÉ</a></label>
			</td>
			<td><input type='checkbox'  id="test4" <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?> ><label for="test4"><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>
			   Il permet de connaître la capacité de production de l’établissement.  </span>INDICE DE ROTATION PAR SERVICE</a></label>			
			</td>
		</tr>
		<tr>
			<td style=''><input type='checkbox'  id="test3"  <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?>><label for="test3"><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>
			<b>IRP supérieur à 1 :</b> cela signifie que les clients choisissent plutôt les plats à prix élevés. 
			  Une interprétation possible <br/>de ce résultat est que les prix de la gamme sont trop bas 
			  par rapport à l’attrait exercé sur les clients par les plats proposés.<br/>
				<b>IRP inférieur à 1 :</b> à l’inverse, la demande se dirige dans ce cas plutôt vers les plats les moins chers de la gamme, ce qui peut <br/>signifier que les prix sont perçus comme trop élevés.
				Cette analyse permet d’évaluer globalement le positionnement prix de l’établissement.<br/> Cependant, le choix des clients n’est pas influencé par le seul prix mais aussi par le produit, son appellation, sa place dans la carte et par la  <br/>force de vente.
				 <br/>Cet indice permet d fournir au responsable du restaurant des informations utiles pour améliorer l’offre mais ne donnent pas de solutions  <br/>toutes faites pour agir sur la perception du rapport qualité/prix par le client.
				  </span>INDICE RÉPONSE PRIX (IRP)</a></label>	
			</td>
			<td><input type='checkbox'  id="test4" <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?> ><label for="test4"><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>
				Il permet de connaître la capacité de production de l’établissement <br/>sur une période plus longue qu’un service.</span>INDICE DE ROTATION MOYEN</a></label>		
			</td>
		</tr>
		<tr>
			<td style=''><input type='checkbox'  id="test3"  <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?>><label for="test3"><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>
				Ce taux mesure la capacité du restaurant.</span>TAUX  DE LA CAPACITÉ D’UN RESTAURANT</a></label>
			</td>
			<td><input type='checkbox'  id="test4" <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?> ><label for="test4"><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>
			   Il permet de nous indiquer le taux de rotation de la chaise.  </span>TAUX D’OCCUPATION DE LA CHAISE PAR JOUR</a></label>			
			</td>
		</tr>
	<tr>
			<td ><br/><span style='font-weight:bold;color:maroon;font-size:1.1em;font-style:italic;'>Les Indicateurs de Performance relatifs aux Côuts</span></td>
		</tr>
			<tr><td >&nbsp;</td></tr>
		<tr>
			<td style=''><input type='checkbox'  id='test15' <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?>><label for="test15"><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>
				Il permet de mesurer le coût des denrées utilisées dans la confection des plats.</span>COÛT NOURRITURE</a></label>
			</td>
			<td><input type='checkbox'  id='test16' <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?>><label for="test16"><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>
				Il permet de refléter l’ensemble des coûts boissons et nourritures comprise dans les boissons.</span>LE COÛT BOISSON</a></label>			
			</td>
		</tr>
		<tr>
			<td style=''><input type='checkbox'  id='test15' <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?>><label for="test15"><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>
				Il permet à l’entreprise de mieux suivre le premier de ses coûts principaux.</span>COUT MATIERE</a></label>
			</td>
			<td><input type='checkbox'  id='test16' <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?>><label for="test16"><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>
				Il détermine le coût, en temps, de chaque couvert.</span>EFFICACITE DU PERSONNEL</a></label>			
			</td>
		</tr>
		<tr>
			<td colspan='2' align='center'><br/>
				<table align='center'>
					<tr>
					<td>
					<input type='submit' class="bouton2" name='ok' value='OK'/><br/>&nbsp;	</td>
					</tr>

				</table>
			</td>
		</tr>
	</table>

	</div>



</form>
	</body> 
</html>