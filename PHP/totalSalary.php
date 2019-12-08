<?php
function findTotalSalary($db, $upsID, $year){
              $adjustmentID_results = $db->query("select adjID from EmployeeAdjustments where year = $year and upsID = $upsID");
              $adjustmentIDs = $adjustmentID_results->fetch(PDO::FETCH_ASSOC);
              $baseSalaryQuery = $db->query("select baseSalary from EmployeePositionInformationByYear natural join SalaryScale where upsID = $upsID");
              $baseSalary = $baseSalaryQuery->fetch()[0];
              
              if (is_array($adjustmentIDs) || is_object($adjustmentIDs)){
              foreach ($adjustmentIDs as $adjustmentID){
                $adjustment_result = $db->query("select * from SalaryAdjustments where adjID = $adjustmentID");
                $adjustment = $adjustment_result->fetch();
                if ($adjustment["operation"] == "x"){
                  $baseSalary *= $adjustment["adjVal"];
                }
              }
              foreach ($adjustmentIDs as $adjustmentID){
                $adjustment_result = $db->query("select * from SalaryAdjustments where adjID = $adjustmentID");
                $adjustment = $adjustment_result->fetch();
                if ($adjustment["operation"] == "+"){
                  $baseSalary += $adjustment["adjVal"];
                }   
              }
            }
              return $baseSalary;
            }

function findTotalRankSalaries($db){
  $query_str = $db->prepare("with A as (select max(year) from EmployeePositionInformationByYear) select firstName, lastName, baseSalary from SalaryScale natural join EmployeePositionInformationByYear natural join Employee where year in A");
  if ($query_str->execute()){
    $i = 0;
    $salariesByRank = array("Inst"=>0,"Asst"=>0,"Assc"=>0,"Full"=>0,"CLAsst"=>0,"CLAssc"=>0);
    $result_set = $db->query("with A as (select max(year) from EmployeePositionInformationByYear) select firstName, lastName, baseSalary, year, upsID, rank, type from SalaryScale natural join EmployeePositionInformationByYear natural join Employee where year in A");
    while($row = $result_set->fetch()) {
      if ($row[$i] != NULL){
        $totalSalary = findTotalSalary($db, $row['upsID'], $row['year']);
        if($row['rank']=='Inst'){
            $salariesByRank["Inst"]+=$totalSalary;
        }
        else if ($row['rank']=='Assc'){
          $salariesByRank["Assc"]+=$totalSalary;
        }
        else if ($row['rank']=='Asst'){
          $salariesByRank["Asst"]+=$totalSalary;
        }
        else if ($row['rank']=='Full'){
          $salariesByRank["Full"]+=$totalSalary;
        }
        else if ($row['rank']=='CLAsst'){
          $salariesByRank["CLAsst"]+=$totalSalary;
        }
        else {
          $salariesByRank["CLAssc"]+=$totalSalary;
        }
      }
    }
    return $salariesByRank;
  }
}

function findTotalTypeSalaries($db){
  $query_str = $db->prepare("with A as (select max(year) from EmployeePositionInformationByYear) select firstName, lastName, baseSalary from SalaryScale natural join EmployeePositionInformationByYear natural join Employee where year in A");
  if ($query_str->execute()){
    $i = 0;
    $salariesByType = array("T"=>0,"I"=>0,"CL"=>0,"S"=>0,"VAP"=>0,"VIN"=>0,"E"=>0);
    $result_set = $db->query("with A as (select max(year) from EmployeePositionInformationByYear) select firstName, lastName, baseSalary, year, upsID, rank, type from SalaryScale natural join EmployeePositionInformationByYear natural join Employee where year in A");
    while($row = $result_set->fetch()) {
      if ($row[$i] != NULL){
        $totalSalary = findTotalSalary($db, $row['upsID'], $row['year']); 
        if($row['type']=='T'){
          $salariesByType["T"]+=$totalSalary;
        }
        else if ($row['type']=='I'){
          $salariesByType["I"]+=$totalSalary;
        }
        else if ($row['type']=='CL'){
          $salariesByType["CL"]+=$totalSalary;
        }
        else if ($row['type']=='S'){
          $salariesByType["S"]+=$totalSalary;
        }
        else if ($row['type']=='E'){
          $salariesByType["E"]+=$totalSalary;
        }
        else if (strpos($row['type'],'VIN')){
          $salariesByType["VIN"]+=$totalSalary;
        }
        else {
          $salariesByType["VAP"]+=$totalSalary;
        }
      }
    }
    return $salariesByType;
  }
}
?>