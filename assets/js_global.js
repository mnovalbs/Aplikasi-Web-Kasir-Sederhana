/*
  Codedicate Copyright Javascript
*/

function inputKeyPress(e)
{
  if(e.keyCode==13)
  {
    do_login();
  }
}

function do_login()
{
  var email = $("input[name=email]").val();
  var password = $("input[name=password]").val();

  var button_awal = $(".form-login button").html();
  var benar = 1;

  $("#peringatan-js").html("");

  if(!email){
    $("#peringatan-js").append("<div class='peringatan merah'>Email harus terisi</div>");
    benar = 0;
  }
  if(!password){
    $("#peringatan-js").append("<div class='peringatan merah'>Password harus terisi</div>");
    benar = 0;
  }

  if(benar == 1){
    $(".form-login button").html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Loading&hellip;');

    $.ajax({
      url : 'js_login',
      type : 'POST',
      dataType : 'json',
      data : {email: email, password: password},
      success : function(data)
      {
        if(data.success=='yes')
        {
          $("#peringatan-js").append("<div class='peringatan hijau'><i class='fa fa-circle-o-notch fa-spin fa-fw'></i> Berhasil login</div>");
          setTimeout(function(){
            // window.location = window.location.protocol+"//"+window.location.hostname+"/petugas";
            window.location = data.redirect;
          },1500);
        }
        else
        {
          $("#peringatan-js").append("<div class='peringatan merah'>Periksa kembali email dan password</div>");
        }
        $(".form-login button").html("Login");
      }
    });
  }
}

function form_login_location()
{
  var tinggi_layar = $(window).height();

  var form_login = $(".form-login");

  if(tinggi_layar > form_login.height())
  {
    form_login.css('top', (tinggi_layar - form_login.height())/2);
  }
}

$(document).ready(function(){
  $(".form-login").parents('body').css('background','#CFD8DC');
});

$(window).bind("load resize", function(){
  form_login_location();
});
$("body").bind("DOMSubtreeModified", function() {
  form_login_location();
});
