
//POST REQUEST

$(document).ready(function(){
    $('#post').click(function(e){
        e.preventDefault();

        //serialize form data
        var url = $('form').serialize();

        //function to turn url to an object
        function getUrlVars(url) {
            var hash;
            var myJson = {};
            var hashes = url.slice(url.indexOf('?') + 1).split('&');
            for (var i = 0; i < hashes.length; i++) {
                hash = hashes[i].split('=');
                myJson[hash[0]] = hash[1];
            }
            return JSON.stringify(myJson);
        }

        //pass serialized data to function
        var test = getUrlVars(url);

        //post with ajax
        $.ajax({
            type:"POST",
            url: "/secret_api/api/post/create.php",
            data: test,
            ContentType:"application/json",

            success:function(){
                alert('Successful Operation');
            },
            error:function(){
                alert('Error');
            }

        });
    });
});


//GET REQUEST

  document.addEventListener('DOMContentLoaded',function(){
  document.getElementById('get').onclick=function(){

        //var get_hash = document.getElementById("secret_hash").value;

       var req;
       req=new XMLHttpRequest();
       req.open("GET", '/secret_api/api/post/read.php',true);
       req.send();

       req.onload=function(){
       var json=JSON.parse(req.responseText);


      //limit data called
      var son = json.filter(function(val) {
        return (val.secret_hash >= 4);
            });

        var html = "";

        //loop and display data
        son.forEach(function(val) {
            var keys = Object.keys(val);


          html += "<div class='secret'>";
              keys.forEach(function(key) {
              html += "<strong>" + key + "</strong>: " + val[key] + "<br>";
              });
          html += "</div><br>";
        });

      //append in message class
      document.getElementsByClassName('secret')[0].innerHTML=html;
      };
    };
  });

