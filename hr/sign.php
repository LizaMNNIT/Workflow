<?php

/*if(!empty($_POST['submit']))
{
  $leave=$_post['leave'];
  $dept=$_post['department'];
  $from_date=$_post['from_date'];
  $to_date=$_post['to_date'];
  $reason=$_post['reason'];
  $eid=$_post['eid'];
  $ename=$_post['ename'];
  $team_no=$_post['team_no'];

*/

  require('fpdf181/fpdf.php');
  $pdf= new FPDF();
  $pdf->AddPage();
  $pdf->SetFont('Arial','',14);
  $pdf->Cell(100,10,"Head of Department",0,1,L);
  //$pdf->Cell(100,10,"{$dept} Department",0,1,L);
  $pdf->Cell(100,10,"XYZ Company",0,1,L);
  //$pdf->Cell(100,10,"Date: {$sysdate}",0,1,L);
  //$pdf->Cell(100,10,"Subject: {$leave} Leave Application",0,1,L);
  $pdf->Cell(100,10,"Dear Sir,",0,1,L);
 // $pdf->Cell(300,10,"My name is {$uname}, employee id {$uid},",0,0);
  //$pdf->Cell(300,10,"of {$dept} Department, team number {$team_no}.",0,0);
 //$pdf->Cell(300,10,"I want to apply for leave from {$from_date} to {$to_date} due to {$reason}.",0,1);
  $pdf->Cell(300,10,"I will be obliged if you consider my application for approval.",0,1);
  $pdf->Cell(300,10,"Yours sincerely,",0,1,L);
 // $pdf->Cell(300,10,"{$uname}",0,1,L);
 $pdf->Image("one.png",10,6);
  $pdf->Output();
//}
 ?>
