#!/usr/bin/env nodejs
var express = require('express');
var app = express();
var addEmployee = require('./addEmployee.js');
var bodyParser = require('body-parser');
var http = require('http');

app.use(bodyParser.json()); 
app.use(bodyParser.urlencoded({ extended: true })); 
app.use('/addEmployee', addEmployee);
app.listen(8080);

