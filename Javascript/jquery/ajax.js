//Jquery- Ajax code is available below.....

// Get Method

$.get("Url", function(res, status){
    console.log(data);
});


//Post method

$.post("Url", data, function(res, status){  // passing data to the server 
    console.log(res);
});


//Ajax method.....
var request = $.ajax({
    url: "script.php",
    method: "POST",
    data: { id : menuId }, //data, passing to the server
    dataType: "html"
  });
   
  request.done(function( res ) {
    console.log(res);
  });
   
  request.fail(function( jqXHR, textStatus ) {
    alert( "Request failed: " + textStatus );
  });


  //When ajax metod is used for Laravel, You could use either $.post() method or $.ajax() method

var person = {
    name : $('#name').val(),
    email : $('#email').val(),
    address : $('#address').val(),
};

var data = {
    _token : _token,  //CSRF field will generate token automatically
    person: person
};

$.post("Url", data, function(res, status){  // passing data to the server 
    console.log(res);
});

//Or


var request = jQuery.ajax({
    url: "{{ route('create.company') }}",  //route or Url to connect with laravel server
    data: data,
    method: "POST",
    dataType: "json"
});
request.done(function (response) {
    console.log(response);
})

request.fail(function (jqXHT, textStatus) {
    $.notify(textStatus, "error");
});



