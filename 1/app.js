var express = require("express"),
    app = express(),
    bodyParser  = require("body-parser"),
    methodOverride = require("method-override"),
    ip2loc = require("ip2location-nodejs"),
    js2xmlparser = require("js2xmlparser"),
    json2csv = require('json2csv');

app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());
app.use(methodOverride());

var router = express.Router();

router.get('/', function(req, res) {
   res.send("Hello World!");
});

router.get('/json/:ip', function(req, res) {
   var ip = req.params.ip;

   if (ip == "random") {
    ip = (Math.floor(Math.random() * (255 - 1)) + 1)+"."+(Math.floor(Math.random() * (255 - 1)) + 1)+"."+(Math.floor(Math.random() * (255 - 1)) + 1)+"."+(Math.floor(Math.random() * (255 - 1)) + 1);
   }

   temp = ip2loc.IP2Location_get_all(ip);

   res.send(temp);
});

router.get('/xml/:ip', function(req, res) {
   var ip = req.params.ip;

 if (ip == "random") {
    ip = (Math.floor(Math.random() * (255 - 1)) + 1)+"."+(Math.floor(Math.random() * (255 - 1)) + 1)+"."+(Math.floor(Math.random() * (255 - 1)) + 1)+"."+(Math.floor(Math.random() * (255 - 1)) + 1);
   }

   temp = ip2loc.IP2Location_get_all(ip);

   res.send(js2xmlparser.parse("Response", temp));
});


router.get('/csv/:ip', function(req, res) {
   var ip = req.params.ip;

  if (ip == "random") {
    ip = (Math.floor(Math.random() * (255 - 1)) + 1)+"."+(Math.floor(Math.random() * (255 - 1)) + 1)+"."+(Math.floor(Math.random() * (255 - 1)) + 1)+"."+(Math.floor(Math.random() * (255 - 1)) + 1);
   }

   temp = ip2loc.IP2Location_get_all(ip);

   res.send(js2xmlparser.parse("Response", temp));
});

app.use(router);

app.listen(80, function() {
  console.log("Node server running on http://localhost:80");
});

ip2loc.IP2Location_init("IP2LOCATION-LITE-DB11.BIN");
