var express = require('express');
var path = require('path');
var app = express();
const googleTrends = require('google-trends-api');

// Define the port to run on
app.set('port', 3030);
app.use(express.static(path.join(__dirname, 'public')));

// Listen for requests
var server = app.listen(app.get('port'), function() {
  var port = server.address().port;
  console.log('Magic happens on port: ' + port);
});

/*
googleTrends.interestOverTime({keyword: 'litecoin'})
    .then(function(results){
        console.log('These results are awesome', results);
    })
    .catch(function(err){
        console.error('Oh no there was an error', err);
    });
*/
