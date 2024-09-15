<?php
require('fpdf17/fpdf.php');
@include('connexion.php');
session_start();
class PDF extends FPDF
{   
	function Header()
	{    if($this->PageNo()==1)
	    {//$this->temporaire( "Hotel Codiam" );
		global $mydate;
		//$this->Ln('4');
		$this->SetFont('Arial','B',14);
		//Titre encadré
		$this->SetTextColor(100,150,255);
		//$sDateReturn=substr(date("Y-m-d")).'-'.substr(date("Y-m-d")).'-'.substr(date("Y-m-d"));
		$this->Cell(0,0,'ARCHEVECHE DE COTONOU',0,1,'');   
		//$this->Ln('0');
		$this->SetFont('Arial','I',10);
		$this->SetTextColor(0,0,0);
		$this->Cell(0,0,'                                                                                                      
		                                                        Cotonou le, '.substr(date("Y-m-d"),8,2).'/'.substr(date("Y-m-d"),5,2).'/'.substr(date("Y-m-d"),0,4),0,1,'');
		//$this->Ln('4');
		$this->SetFont('Arial','B',13);
		$this->SetTextColor(100,150,255);
		//Titre encadré
		$this->Cell(0,60,'              CODIAM',0,1,'');
		
		//$this->Ln('4');
		$this->SetFont('Arial','B',13);
		$this->SetTextColor(115,8,0);
		//Titre encadré
		$this->Cell(0,0,'        Liste des montants à faire valoir',0,1,'C');
		$this->Image('logo/codi.jpg',25,15,30,20);
		$this->SetFont('Arial','',10);
		//$this->Cell(60);
		$this->Ln('10');}
		
	}
		function Footer()
	{
		//Positionnement à 1,5 cm du bas
		$this->SetY(-15);
		$this->SetFont('Arial','B',10);
		$this->Cell(0,0,'--------------------------------------------------------------------------------------------------------------------------------------------------------------------',0,0,'L');

		//Police Arial italique 8
		$this->SetFillColor(200,220,255);
		$this->SetFont('Arial','I',8);	
		//Numéro et nombre de pages
		$this->Cell(0,10,'SYGHOC - CODIAM - Logiciel de Gestion Hôtellière                                                              Page '.$this->PageNo(),0,0,'R');
		
	}
	
	// Chargement des données
function LoadData($file)
{
    // Lecture des lignes du fichier
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
		//$data[]=explode(';',chop($line));
    return $data;
}

// Tableau coloré
function FancyTable($header, $data)
{
    // Couleurs, épaisseur du trait et police grasse
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // En-tête
    $w = array(21,49,30,35,35,20);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Restauration des couleurs et de la police
    $this->SetFillColor(224,235,255);
    //$this->SetFillColor(220,230,205);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Données
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,$row[2],'LR',0,'C',$fill);
        $this->Cell($w[3],6,$row[3],'LR',0,'C',$fill);
		$this->Cell($w[4],6,$row[4],'LR',0,'C',$fill);
        $this->Cell($w[5],6,$row[5],'LR',0,'C',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Trait de terminaison
    $this->Cell(array_sum($w),0,'','T');
}
}


$pdf = new PDF();
// Titres des colonnes
$header = array('N° Fiche', 'Nom & Prénoms', 'N° Chambre', 'Date d\'arrivée', 'Date de sortie', 'Montant');
// Chargement des données
$data = $pdf->LoadData('valoir.txt');
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
/* $pdf->BasicTable($header,$data);
$pdf->AddPage();
$pdf->ImprovedTable($header,$data);
$pdf->AddPage(); */
$pdf->FancyTable($header,$data);
$pdf->Output();



?>
