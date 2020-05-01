var express = require('express');
var path = require('path');
var mongoose = require('mongoose');
var config = require('./config/database');
var bodyParser = require('body-parser')
var session = require('express-session')
var expressValidator = require('express-validator');
var fileUpload = require('express-fileupload');

//connect to db
mongoose.connect(config.database);
var db = mongoose.connection;
db.on('error', console.error.bind(console, 'connection error:'));
db.once('open', function() {
  console.log('connected to MongoDB');
});

//init app
var app = express();

//view engine setup
app.set('views', path.join(__dirname,'views'));
app.set('view engine', 'ejs');

//set public folder
app.use(express.static(path.join(__dirname,'public')));

//Set global errors variable
app.locals.errors = null;

//Get page Model
var Page = require('./models/page');

//Get all pages to pass header.ejs
Page.find({}).sort({sorting: 1}).exec(function(err, pages){
    if(err) {
        console.log(err)
    }else{
        app.locals.pages = pages;
    }
});

//Get category model
var Category = require('./models/category');
Category.find(function(err, categories){
    if(err) {
        console.log(err)
    }else{
        app.locals.categories = categories;
    }
});

// Express fileUpload middleware
app.use(fileUpload());

// parse application/x-www-form-urlencoded
app.use(bodyParser.urlencoded({ extended: false }))

// parse application/json
app.use(bodyParser.json())

//Express Session
app.use(session({
    secret: 'keyboard cat',
    resave: true,
    saveUninitialized: true,
   // cookie: { secure: true }
  }));

// Express Validator middleware
app.use(expressValidator({
    errorFormatter: function (param, msg, value) {
        var namespace = param.split('.')
                , root = namespace.shift()
                , formParam = root;

        while (namespace.length) {
            formParam += '[' + namespace.shift() + ']';
        }
        return {
            param: formParam,
            msg: msg,
            value: value
        };
    },
    customValidators: {
        isImage: function(value,filename){
            var extension = (path.extname(filename)).toLocaleLowerCase();
            switch(extension){
                case '.jpg':
                    return '.jpg';
                case '.jpeg':
                    return '.jpeg';
                case '.png':
                    return '.png';
                case '':
                    return '.jpg';
                default :
                    return false;

            }
        }
    }

}));

//Express message Middleware
app.use(require('connect-flash')());
app.use(function (req, res, next) {
  res.locals.messages = require('express-messages')(req, res);
  next();
});

//set routes
var pages = require('./routes/pages.js');
var products = require('./routes/products.js');
var adminpages = require('./routes/adminpages.js');
var adminCategories = require('./routes/admin_categories.js');
var adminProducts = require('./routes/admin_products.js');

app.use('/admin/pages',adminpages);
app.use('/admin/categories',adminCategories);
app.use('/admin/products',adminProducts);
app.use('/products',products);
app.use('/',pages);

//start server
var port = 3000;
app.listen(port,function(){
    console.log("Server starting " +port );
});