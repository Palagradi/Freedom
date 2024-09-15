<?php 
//session_start();
//ob_start();
//$bdd= new PDO('mysql:host=localhost;dbname=codiam','root','');
include_once'menu.php';
require('html2pdf/html2pdf.class.php');

echo '<page backtop="5%" backbottom="5%" backleft="5%" backright="5%">
	<h1 style="align-test:center">Liste des clients</h1>
	<table style="width:100%;:1px solid black;" >
		<tr>
			<th>Numéro</th>
			<th>Nom</th>
			<th>Prénoms</th>
		</tr>';
			$req=mysql_query("SELECT numcli,nomcli,prenomcli FROM client LIMIT 100");
			while($data=mysql_fetch_array($req))
			{	echo "<tr>
					<td>".$data['numcli']."</td>";
					echo "<td>".$data['nomcli']."</td>";
					echo "<td>".$data['prenomcli']."</td>
				</tr>";
			}
	echo"</table>
</page>";
$content = ob_get_clean();

$pdf = new HTML2PDF('P','A4','fr','true','UTF-8');
$pdf->writeHTML($content);
$pdf->Output('liste.pdf');


?>