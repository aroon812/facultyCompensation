#!/usr/bin/env nodejs
var express = require('express');
var app = express();
var addEmployee = require('./addEmployee.js');
var bodyParser = require('body-parser');
var http = require('http');

app.use(bodyParser.json()); 
app.use(bodyParser.urlencoded({ extended: true })); 
app.use('/addEmployee', addEmployee);

http.createServer(function (request, response) {
   response.writeHead(200, {'Content-Type': 'text/plain'});
   response.end('Hello World! Node.js is working correctly.\n');
}).listen(8080);