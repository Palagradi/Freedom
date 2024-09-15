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

		<div align="" style="font-family:Cambria;margin-top:-40px;"><form action='indicHotel2.php?menuParent=Statistiques' method='post' name='indicHotel'>
			 
	<table  WIDTH="auto" style='margin: 50px auto;background-color:#D0DCE0;color:#444739;' id="tab">
	<tr>
	<td colspan='4'>&nbsp;
	</td>
	</tr>
	<tr>
	<td colspan='4'>
		<h4 ALIGN='CENTER' style='font-weight:bold;color:maroon;'>LES INDICATEURS DE PERFORMANCE EN HOTELLERIE</h4>
	</td>
	</tr>
	<tr style=''><td colspan='4' align='center'>PERIODE DU :&nbsp;&nbsp;<input type='date' name='ladate' id='ladate'  required />

	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AU :&nbsp;&nbsp;<input type='date' name='ladate2' id='ladate2'  required /> </td></tr>
		<tr>
			<td ><br/><span style='font-weight:bold;color:maroon;font-size:1.1em;font-style:italic;'>Les Indicateurs de Performance Commerciale</span></td>
			<td align='right'><br/> <span style='font-size:0.9em;'>
			<?php 
				if(empty($c)) 
						echo "<a href='indicHotelR.php?menuParent=Statistiques&c=1' style='color:green;' ><b>Tout cocher</b>";
				else if(!empty($c)&& ($c==1))
					{	echo "<a href='indicHotelR.php?menuParent=Statistiques&d=1' style='color:green;' ><b>Tout décocher</b>";
					}
				else {
					}
				?>
			</a> </span>
			</td>
		</tr>	<tr><td >&nbsp;</td></tr>
		<tr>
			<td style=''>
			    <input type="checkbox" id="test1" <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?> ><label for="test1" ><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>
				Il permet de traduire le nombre de chambres louées en % par rapport à la capacité totale en chambres offertes. <br/>Autrement formulé, et d'une manière statique, c'est
				répondre à la question suivante: <b>Combien avons-nous loué de chambres?</b><br/>
				Sur le plan dynamique, le <b>Taux d'occupation</b> nous renseigne sur la capacité commerciale de la brigade de réception et celle <br/>de l'équipe de la force de vente (l'agressivité commerciale).
				On peut le calculer pour une journée, une décade, un mois etc,</span>TAUX D'OCCUPATION</a></label>
			</td>
			<td><input type='checkbox'  id="test2" <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?> ><label for="test2"><a href='' class='info' ><span style='color:#494039;'>
				Il permet de déterminer le pourcentage des Chambres non occupées.</span>TAUX DE DISPONIBILITE</a></label>			
			</td>
		</tr>
		<tr>
			<td style=''><input type='checkbox'  id="test3"  <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?>><label for="test3"><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>
				Son calcul permet de formuler le nombre de lits loués par rapport à la capacité en lit sous forme de pourcentage.<br/> Donc de répondre à la question suivante: <b>Combien
				avons-nous vendu de lits?</b> Il nous renseigne aussi sur le niveau<br/> de la rentabilisation de la capacité chambres de l'hôtel. La périodicité de calcul est de même que pour le Taux d'occupation		
				</span>TAUX DE FREQUENTATION</a></label>
			</td>
			<td><input type='checkbox'  id="test4" <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?> ><label for="test4"><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>Il permet de se prononcer sur la demande de la clientèle à travers la 
			fréquentation des <br>chambres. Il répond à la question de la nature: <b>Quel type de chambre est le plus demandé? <br> (single, double, triple, suite...).</b> Il est intéressant comme indicateur pour l'équipe commerciale
				</span>INDICE DE FREQUENTATION</a></label>
			
			</td>
		</tr>
		<tr>
			<td style=''><input type='checkbox'  id='test5' <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?> ><label for="test5"><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>Il permet de mesurer l'effet de la variation combinée de l'occupation des chambres
			et du prix moyen par<br/> chambre louée, réalisant ainsi une synthèse de la performance commerciale de l'établissement. Aujourdh'hui, <br/>le <b>REVENU MOYEN CHAMBRE</b> est considéré le principal indicateur de performance de l'hôtel.
				</span> YIELD SIMPLE (REVENU MOYEN CHAMBRE)</a></label>
			</td>
			<td><input type='checkbox'  id='test6' <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?>><label for="test6"><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>Il mesure la capacité globale de l'établissement à générer du Chiffre d'affaires.
				</span>YIELD ELARGI</a></label>
			
			</td>
		</tr>
		<tr>
			<td style=''><input type='checkbox'  id='test7' <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?>><label for="test7"><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>D'une part, il nous renseigne sur le type de clientèle (de passage, de séjour), 
			d'autre part, <br/>il permet de juger la capacité de l'hôtel à retenir et à prolonger la durée de la présence du client.<br/> Son calcul s'effectue sur une période déterminée: une semaine, un mois.
				</span>DUREE MOYENNE DE SEJOUR</a></label>
			</td>
			<td><input type='checkbox'  id='test8' <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?>><label for="test8"><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>Par son calcul, l'hôtelier est en mesure d'évaluer le processus de vente au comptoir de laréception d'une part  <br/>et le niveau
			d'adéquation offre-demande. Le <b>Taux de captage</b> peut être calculé dans le cas de la fréquentation.
				</span>TAUX DE CAPTAGE</a></label>
			
			</td>
		</tr>
		<tr>
			<td style=''><input type='checkbox'  id='test9' <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?>><label for="test9"><a href='' class='info' ><span style='color:#494039;'>
				Il permet de se renseigner sur l'aptitude du client à dépenser et à évaluer l'effort commercial consenti par le personnel tous azimuts. </span>REVENU MOYEN PAR CLIENT</a></label>
			</td>
			<td><input type='checkbox'  id='test10' <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?>><label for="test10"><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>
				Il permet de situer le prix de vente moyen pratiqué. Il a un sens lorsque l'hôtel travaille avec, <br/>en plus des clients individuels, les agences de voyages
				(tarif confidentiel ou préférentiel # Rack rate).<br/> Il permet de dégager la marge délaissée par la location d'une chambre. Son calcul permet de répondre <br/>à une double préoccupation:
				<b>Pratiquons-nous des prix compétitifs? Sommes-nous rentables? </b></span>PRIX DE VENTE MOYEN D'UNE CHAMBRE</a></label>
			
			</td>
		</tr>
		<tr>
			<td style=''><input type='checkbox'  id='test11' <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?> ><label for="test11"><a href='' class='info' ><span style='color:#494039;'>
				Son calcul permet de déterminer le pourcentage des clients qui n'ont pas respectés leur engagement de réservation.</span>TAUX DE NO SHOW</a></label>
			</td>
			<td><input type='checkbox'  id='test12' <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?>><label for="test12"  ><a href='' class='info' ><span style='color:#494039;'>
				Il permet de connaître le manque à gagner de la sous-location et donc, d'engager des actions nécessaires.</span>TAUX DE REALISATION FINANCIERE EN HEBERGEMENT</a></label>
			
			</td>
		</tr>
		<tr>
			<td style=''><input type='checkbox'  id='test13' <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?>><label for="test13"><a href='' class='info' ><span style='color:#494039;'>
				C'est l'écart en pourcentage, entre le tarif affiché et le prix moyen chambre et cela pour une période donnée.</span>TAUX DE REDUCTION</a></label>
			</td>
			<td><input type='checkbox'  id='test14' <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?>><label for="test14"><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>
				Le <b>RevPar</b> reflète les performances d'un établissement à la fois en termes de fréqentation <br/>et de prix moyen.
				C'est un indicateur d'évolution qui révèle la performance de la politique <br/>tarifaire mise en parallèle avec le taux
				de remplissage. Il permet une comparaison spatiale. </span>REVENU MOYEN PAR CHAMBRE DISPONIBLE (LE REVPAR)</a></label>
			
			</td>
		</tr>
		<tr>
			<td ><br/><span style='font-weight:bold;color:maroon;font-size:1.1em;font-style:italic;'>Les Indicateurs de Performance relatifs aux Côuts</span></td>
		</tr>	<tr><td >&nbsp;</td></tr>
		<tr>
			<td style=''><input type='checkbox'  id='test15' <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?>><label for="test15"><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>
				</span>COUT MATIERE</a></label>
			</td>
			<td><input type='checkbox'  id='test16' <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?>><label for="test16"><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>
				Ce ratio indique l'effectif moyen par chambre disponible ou louée. Il est calculé pour <br/>l'ensemble de l'établissement
				ou pour un service donné. Il dépend de la catégorie de <br/>l'établissement et permet des comparaisons avec les statistiques professionnelles.</span>RENDEMENT PAR EMPLOYE</a></label>
			
			</td>
		</tr>
				<tr>
			<td style=''><input type='checkbox'  id='test17' <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?>><label for="test17"><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>
				Cet indicateur (inverse du ratio charges de personnel) résulte de la productivité <br/> physique,de la maîtrise des rénumérations et charges sociales et de la politique de prix.</span>TAUX DE PRODUCTIVITE</a></label>
			</td>
			<td><input type='checkbox'  id='test18' <?php if(!empty($c)&& ($c==1)) echo "checked='checked'"; ?>><label for="test18"><a href='' class='info' ><span style='font-size:0.9em;color:#494039;'>
				Il nous indique sur le rendement du service des étages. Il est très utilisé <br/> dans tous les établissements hôteliers qui ne sous-traitent pas cette activité.</span>RENDEMENT AU SERVICE ETAGE</a></label>
			
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