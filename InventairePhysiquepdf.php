<?php
require('fpdf17/fpdf.php');
class PDF extends FPDF
{   
	function Header()
	{  if($this->PageNo()==1)
	   { //$this->temporaire("Duplicata");
		global $mydate;
		//$this->Ln('4');
		$this->SetFont('Arial','B',14);
		//Titre encadré
		$this->SetTextColor(100,150,255);
		//$sDateReturn=substr(date("Y-m-d")).'-'.substr(date("Y-m-d")).'-'.substr(date("Y-m-d"));
		$this->Cell(0,0,$_GET['logo'],0,1,'');   
		//$this->Ln('0');
		$this->SetFont('Arial','I',10);
		$this->SetTextColor(0,0,0);
		//if(empty($_SESSION['date_emission']))
		$this->Cell(0,0,'                            
		                                                                                                                                  Cotonou le, '.substr(date("Y-m-d"),8,2).'/'.substr(date("Y-m-d"),5,2).'/'.substr(date("Y-m-d"),0,4),0,1,'');
		//else
			//	$this->Cell(0,0,'                              Cotonou le, '.substr($_SESSION['date_emission'],8,2).'/'.substr($_SESSION['date_emission'],5,2).'/'.substr($_SESSION['date_emission'],0,4),0,1,'');$this->Ln('4');
		$this->SetFont('Arial','B',13);
		$this->SetTextColor(50,75,200);
		//Titre encadré
		$this->Cell(0,10,$_GET['id'],0,1,'');    //CODIAM
		
		//$this->Ln('4');
		//$this->SetFont('Arial','B',13);
		//$this->SetTextColor(115,8,0);
		

										
		//Titre encadré
		$this->Cell(0,20,"Etat préparatoire d'Inventaire ",0,1,'C');
		//$this->Image('logo/codi.jpg',25,15,30,20);
		//$this->SetFont('Arial','',10);
		
/* 		$this->SetTextColor(0,0,0);
		$this->fact_dev( "Détails du reçu ", "" );
		if(isset($_SESSION['remise'])&& ($_SESSION['remise']>0))
			$this->addDate($_SESSION['remise']);  //REMISE
		else
			$this->addDate($_SESSION['avanceA']);
		if($_SESSION['montant']<$_SESSION['avanceA']) $_SESSION['montant']=$_SESSION['avanceA'] ;
		if(isset($_SESSION['remise'])&& ($_SESSION['remise']>0))
			$this->addClient($_SESSION['montant']-$_SESSION['remise']);  //SOMME PAYEE
		else
			$this->addClient($_SESSION['montant']-$_SESSION['avanceA']);  //SOMME PAYEE
		$this->addPageNumber($_SESSION['montant']);
		
		
		$this->SetTextColor(115,8,0);
		$this->addReglement($_SESSION['groupe1']);
		
		$this->addEcheance( "Hébergement");
		//$_SESSION['fin']="04-04-2014";
		$this->addNumTVA(  "Du"." ".$_SESSION['debut']." "."au"." ".$_SESSION['fin'] );
		$this->Ln('10'); */	
		}
		
	
		
	}		// Ajoute une remarque (en bas, a gauche)
		function addRemarque($remarqu,$remarque)
		{
			$this->SetFont( "Arial", "", 10);
			$length = $this->GetStringWidth( "Remarque : " . $remarque );
			$r1  = 10;
			$r2  = $r1 + $length;
			$y1  = $this->h - 45.5;
			$y2  = $y1+5;
			$this->SetXY( $r1 , $y1 );
			$this->Cell($length,4, $remarqu. $remarque);
		}

	function Footer()
	{ //Positionnement à 1,5 cm du bas
		$this->SetY(-15);
		$this->SetFont('Arial','B',10);
		$this->Cell(0,0,'',0,0,'L');
		//Police Arial italique 8
		$this->SetFillColor(200,220,255);
		$this->SetFont('Arial','I',8);	
		//Numéro et nombre de pages
		//if($this->PageNo()=='/{nb}')
		//{
		//$this->Cell(-180,10,'('.$_SESSION['nomHotel'].')'.$_SESSION['footer1'] ,0,0,'C');
		//$this->Cell(0,18,$_SESSION['footer2'],0,0,'C');
		$this->Cell(0,25,'REPUBLIQUE DU BENIN                                                                                                                 ',0,0,'R');

//$this->addRemarque(" Signature",$_SESSION['chiffre_en_lettre']);

//$this->addCadreEurosFrancs("Détails de la facture",$_SESSION['montant'],$_SESSION['avanceA'],$_SESSION['montant']- $_SESSION['avanceA']);


    $this->SetTextColor(128);
    // Numéro de page
    //$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	//}
	}
	
	// Chargement des données
function LoadData($file)
{
    // Lecture des lignes du fichier
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}

// Tableau coloré
function BasicTable($header, $data)
{
    // Couleurs, épaisseur du trait et police grasse
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // En-tête
    $w = array(15,20,65,25,37,30);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],6,$header[$i],1,0,'C',true);

    $this->Ln();
    // Restauration des couleurs et de la police
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Données
    $fill = false;
    foreach($data as $row)
    {   $this->SetFont('times','B',8);
        $this->Cell($w[0],4,$row[0],'LR',0,'C',$fill);
        $this->Cell($w[1],4,$row[1],'LR',0,'C',$fill);
		$this->Cell($w[2],4,$row[2],'LR',0,'',$fill);
        $this->Cell($w[3],4,number_format($row[3],0,',',' '),'LR',0,'C',$fill);
		$this->Cell($w[4],4,$row[4],'LR',0,'C',$fill);
		$this->Cell($w[5],4,$row[5],'LR',0,'C',$fill);
		//$this->Cell($w[6],6,number_format($row[6],0,',',' '),'LR',0,'C',$fill);
		//$this->Cell($w[7],6,number_format($row[7],0,',',' '),'LR',0,'C',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Trait de terminaison
    $this->Cell(array_sum($w),0,'','T');
}
}


$pdf = new PDF();
// Titres des colonnes
$header = array('N°','Référence', 'Libellé', 'Seuil', 'Stock théorique', 'Stock réel');
// Chargement des données
$data = $pdf->LoadData('txt/InventairePhysique.txt');
$pdf->AddPage();
$pdf->BasicTable($header,$data);

$pdf->Output();

//$_SESSION['defalquer_impaye']=0;unset($_SESSION['date_emission']);
?>
