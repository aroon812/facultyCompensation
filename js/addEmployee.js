const sqlite3 = require('sqlite3').verbose();
var express = require('express');
var app = express();
var router = express.Router();

/* 
function employeeByType(){
  let sql = `SELECT * FROM Employee WHERE type = ?`;
  console.log(db);

db.all(sql, ['T'], (err, row) => {
if (err) {
  throw err;
}
  console.log(row);
});
}

employeeByType();

*/

router.get('/', function(req, res){
   res.send('GET route on add.');
});
router.post('/', function(req, res){
  let db = new sqlite3.Database('/home/dbteam/public_html/bigTuba.db', (err) => {
    if (err) {
      console.error(err.message);
    }
    console.log('Connected to spaghetti');
  });
  res.send(`<h1>Full name is:${req.body.fname} ${req.body.lname}.<\h1>`);
  
  db.run('insert into Employee values(?, ?, ?, ?)', [parseInt(req.body.upsID), req.body.fname, req.body.lname, req.body.type], function(err) {
    if (err) {
      return console.log(err.message);
    }
    console.log('An employee had been added');
  });
  db.close();
});

module.exports = router;