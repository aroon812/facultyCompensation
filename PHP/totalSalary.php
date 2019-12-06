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
                if ($adjustment["operation"] == "*"){
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
?>