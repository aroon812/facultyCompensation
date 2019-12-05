PRAGMA foreign_keys= ON;
drop table if exists Employee;
drop table if exists Department;
drop table if exists SalaryScale;
drop table if exists SalaryAdjustments;
drop table if exists EmployeeAdjustments;
drop table if exists EmployeePositionInformationByYear;
Create table Department(
	deptID Text Primary Key check(length(deptID)<=4),
	deptName Text Unique Not Null);
Create table Employee(
	upsID Integer Primary Key,
	lastName Text not null,
	firstName Text not null,
    type Text check(type='T' or type='I' or type='CL' or type='S' or type='E' or type like 'VAP%' or type like 'VIN%'),
    dept Text not null,
    Foreign Key (dept) References Department(deptID)
        On Update Cascade
        On Delete Set null);
Create table SalaryScale(
	rank Text check(rank='Asst' or rank='Assc' or rank='Full' or rank='CLAsst' or rank='CLAssc' or rank='Inst'),
	step Integer,
	baseSalary Real,
	Primary Key (rank,step));
Create table SalaryAdjustments(
	adjID Integer Primary Key,
	adjVal Real Not Null,
    operation Text check(operation='x' or operation='+'),
	description Text Not Null);
Create table EmployeePositionInformationByYear(
    year Integer check(year>1950) not Null,
    upsID Integer not Null,
    positionNumber Integer not Null,
    includeNext Text check(includeNext='tenative' or includeNext='yes' or includeNext='no'),
    rank Text not null,
    step Integer not null,
    stepYear Integer,
    Primary Key(year,upsID),
    Foreign Key (rank,step) References SalaryScale(rank,step)
        On Update Cascade
    Foreign Key (upsID) References Employee(upsID)
        On Update Cascade);
Create table EmployeeAdjustments(
	year Integer check(year>1950),
	upsID Integer not null,
	adjID Integer not Null,
    Primary Key (year,upsID,adjID),
    Foreign Key (year,upsID) References EmployeePositionInformationByYear(year,upsID)
    Foreign Key (adjID) References SalaryAdjustments(adjID)
        On Update Cascade
        On Delete Cascade);


   
