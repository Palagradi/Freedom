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
		include 'connexion_2.php';
	include 'connexion.php';
	mysql_query("SET NAMES 'utf8'");
	
/* backup the db OR just a table */
function backup_tables($host,$user,$pass,$name,$tables = '*')
{
	
	$link = mysql_connect($host,$user,$pass);
	mysql_select_db($name,$link);
	
	//get all of the tables
	if($tables == '*')
	{
		$tables = array();
		$result = mysql_query('SHOW TABLES');
		while($row = mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//cycle through
	foreach($tables as $table)
	{
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = mysql_num_fields($result);
		
		$return.= 'DROP TABLE '.$table.';';
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysql_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j<$num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = ereg_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}

}
	
	if(isset($_POST['EXPORTER']) && $_POST['EXPORTER'] == "EXPORTER")
		{//save file
		backup_tables('localhost','root','','codiam');
		$handle = fopen('backup\backup_'.date('d-m-y').'.sql','w+','backup');
		//$handle = fopen('backup.sql','w+');
		if($handle)  $handle;
		fwrite($handle,$return);
		fclose($handle);
		$srcfile='C:\wamp\www\SYGHOC\backup\backup_'.date('d-m-y').'.sql';
	 	$dstfile=$_POST['emplacement'].'backup_'.date('d-m-y').'.sql';
		//mkdir(dirname($dstfile), 0777, true);
		copy($srcfile, $dstfile);
		//exec('start C:\wamp\www\utilitaires\backup.bat', $output);		
		echo "<script language='javascript'>"; 
		echo " alert('Exportation réussie');";
		echo "</script>";
		}
?>


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>Exportation de la base</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="design.css"/>
	</head>
	<body bgcolor="">
		<div align="center" >
			<form action="" method="POST">
				<table width="650" height="200" border="0" cellpadding="0" cellspacing="0" style="margin-top:100px; border:2px solid black; font-family:Cambria;">
					<tr>
						<td colspan="4">
							<h2 style="text-align:center; font-family:Cambria;color:#980065;">Exporter la base de données</h2>
						</td>
					</tr>

					<tr>
						<td colspan="2" style="padding-left:100px;">Emplacement  : </td>
						<td colspan="2"> 
							<input type="text" id="" name="emplacement" value="D:\"style="width:200px;"  />
						</td>
					</tr>

					<tr>
						<td colspan="2" align="right" style="padding-right: 20px;"><br/> <input type="submit" class="les_boutons" value="EXPORTER" id="" name="EXPORTER" style="margin-bottom:5px;border:2px solid #980065;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;"/> </td>
						<td colspan="2"><br/> <input type="submit" class="les_boutons" name="annuler" value="ANNULER" style="margin-bottom:5px;border:2px solid #980065;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;"/> </td>
					</tr>

				</table>
			</form>

			<br/>
			<p>&nbsp;</p>
		</div>
	</body>
</html>