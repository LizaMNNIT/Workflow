<?php
if(!empty($_POST['submit']))
{
  $leave=$_POST['leave'];
  $dept=$_POST['department'];
  $from_date=$_POST['from_date'];
  $to_date =$_POST['to_date'];
  $reason=$_POST['reason'];
  $eid=$_POST['eid'];
  $ename=$_POST['ename'];
  $team_no=$_POST['team_no'];

  $date=date("d/m/Y");

  require('fpdf181/fpdf.php');
  $pdf= new FPDF();
  $pdf->AddPage();
  $pdf->SetFont("Arial","","14");
  $pdf->Cell(100,10,"Head of Department",0,1);
  $pdf->Cell(100,10,"{$dept} Department",0,1);
  $pdf->Cell(100,10,"XYZ Company",0,1);
  $pdf->Cell(300,10,"",0,1);
  $pdf->Cell(100,10,"Date: {$date}",0,1);
  $pdf->Cell(300,10,"",0,1);
  $pdf->Cell(100,10,"Subject: {$leave} Leave Application",0,1);
  $pdf->Cell(300,10,"",0,1);
  $pdf->Cell(100,10,"Dear Sir,",0,1);
  $pdf->Cell(300,10,"My name is {$ename}, employee id {$eid}, of {$dept} Department, team number {$team_no}.",0,1);
  $pdf->Cell(300,10,"I want to apply for leave from {$from_date} to {$to_date} due to {$reason}.",0,1);
  $pdf->Cell(300,10,"I will be obliged if you consider my application for approval.",0,1);
  $pdf->Cell(300,10,"",0,1);
  $pdf->Cell(300,10,"Yours sincerely,",0,1);
  $pdf->Cell(300,10,"{$ename}",0,1);
  $filename="C:\xampp\htdocs\Workflow\files\PDF\hello.pdf";
  $pdf->Output();
  echo($pdf->Output());
}
else {
  echo "Error";
}
 ?>
