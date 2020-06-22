PRAGMA foreign_keys = ON;
drop table if exists Employee;
drop table if exists Department;
drop table if exists SalaryScale;
drop table if exists SalaryAdjustments;
drop table if exists EmployeeAdjustments;
drop table if exists EmployeePositionInformationByYear;
Create table Department(
    deptID Integer Primary Key,
    deptName Text Unique Not Null
);
Create table Employee(
    upsID Integer Primary Key,
    lastName Text not null,
    firstName Text not null,
    type Text check(
        type = 'T'
        or type = 'I'
        or type = 'CL'
        or type = 'S'
        or type = 'E'
        or type like 'VAP%'
        or type like 'VIN%'
    ),
    deptID Integer,
    Foreign Key (deptID) References Department(deptID) On Update Cascade On Delete
    Set null
);
Create table SalaryScale(
    rank Text check(
        rank = 'Asst'
        or rank = 'Assc'
        or rank = 'Full'
        or rank = 'CLAsst'
        or rank = 'CLAssc'
        or rank = 'Inst'
    ),
    step Integer not null,
    baseSalary Real,
    Primary Key (rank, step)
);
Create table SalaryAdjustments(
    adjID Integer Primary Key,
    adjVal Real Not Null,
    operation Text check(
        operation = 'x'
        or operation = '+'
    ) Not Null,
    description Text Not Null
);
Create table EmployeePositionInformationByYear(
    year Integer check(year > 1950) not Null,
    upsID Integer,
    positionNumber Integer,
    includeNext Text check(
        includeNext = 'tenative'
        or includeNext = 'yes'
        or includeNext = 'no'
    ) not null,
    rank Text,
    step Integer,
    stepYear Integer,
    Primary Key(year, upsID),
    Foreign Key (rank, step) References SalaryScale(rank, step) On Update Cascade On Delete
    set null Foreign Key (upsID) References Employee(upsID) On Update Cascade On Delete
    set null
);
Create table EmployeeAdjustments(
    year Integer check(year > 1950),
    upsID Integer not null,
    adjID Integer not Null,
    Primary Key (year, upsID, adjID),
    Foreign Key (year, upsID) References EmployeePositionInformationByYear(year, upsID) On Update Cascade On Delete Cascade Foreign Key (adjID) References SalaryAdjustments(adjID) On Update Cascade On Delete Cascade
);