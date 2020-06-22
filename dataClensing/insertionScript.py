import pandas
import numpy


def deleteLastComma(insertion):
    comma = len(insertion)-3
    is1 = insertion[:comma]
    is2 = insertion[comma+1:]
    insertion = is1 + is2
    return insertion


data = pandas.read_excel('mockData.xlsx')
data.drop([0], inplace=True)
attributeTuples = [('Department', ['deptID', 'deptName']),
                   ('Employee', ['upsID', 'lastName',
                                 'firstName', 'type', 'dept']),
                   ('SalaryScale', ['rank', 'step', 'baseSalary']),
                   ('SalaryAdjustments', [
                    'adjID', 'adjVal', 'operation', 'description']),
                   ('EmployeePositionInformationByYear', [
                       'year', 'upsID', 'positionNumber', 'includeNext', 'rank', 'step', 'stepYear']),
                   ('EmployeeAdjustments', ['year', 'upsID', 'adjID'])]

data.replace(to_replace='y', value='yes', inplace=True)
data.replace(to_replace='n', value='no', inplace=True)
data.replace(to_replace='t', value='tenative', inplace=True)
print(data)


itemNum = len(data.index)
counter = 0
for i in range(0, itemNum):
    for (relation, attributes) in attributeTuples:
        attributesFilled = True
        insertion = '('
        for attribute in attributes:
            if pandas.isnull(data.iloc[i][attribute]):
                attributesFilled = False

        if attributesFilled:
            for attribute in attributes:
                if attribute is 'adjID':
                    addition = counter
                    counter += 1
                else:
                    addition = '\'' + str(data.iloc[i][attribute]) + '\''
                insertion = insertion + addition + ','
            insertion = insertion + ');'
            insertion = deleteLastComma(insertion)
            print('INSERT INTO ' + relation + ' VALUES ' + insertion)
