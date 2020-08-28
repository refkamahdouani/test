require('./register.css');

$(document).ready(function(params) {
    $( "#signupbtn" ).on('click',function() {
var firstname = $("#firstname").val();
var lasttname = $("#lastname").val();
var email = $("#email").val();
var password =$("#password").val();

var form = new FormData();
form.append("firstname", firstname);
form.append("lastname", lasttname);
form.append("email", email);
form.append("password", password);

var settings = {
  "url": "http://localhost:8080/register",
  "method": "POST",
  "timeout": 0,
  "processData": false,
  "mimeType": "multipart/form-data",
  "contentType": false,
  "data": form
};

$.ajax(settings).done(function (response) {
  console.log(response);
});
});
})

