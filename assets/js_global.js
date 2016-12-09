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
          },500);
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

function base_url(str)
{
  return window.location.protocol+'//'+window.location.hostname+'/'+str;
}

// $("#kategori-list").ready(function(){
//   get_list_kategori();
// });

function get_list_kategori()
{
  var hasil = '';
  $("#kategori-list").html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Loading&hellip;');
  $.ajax({
    url : base_url('admin/list_kategori'),
    dataType : 'json',
    success : function(data){
      $("#kategori-list").html("");
      var del = 500;
      $.each(data, function(index, element){
        var kat = '';
        kat += "<div class='li-kategori' kategori-id='"+element.idkategori+"'>";
        kat += "<table><tr>";
        kat += "<td width='30'><span>";
        kat += "<a href='#!' onclick='delete_kategori("+element.idkategori+")' class='hapus'><i class='fa fa-trash'></i></a> ";
        kat += "<a href='#!' class='ubah'><i class='fa fa-pencil'></i></a></span></td>";
        kat += "<td><label><span class='nama'>"+element.nama+"</span></label></td></tr></table>";
        kat += "</div>";
        var new_kat = $(kat).hide();
        $("#kategori-list").append(new_kat);
        new_kat.fadeIn(500+del);
        del += 500;
      });
    }
  });

  $("#kategori-list").html(hasil);
}

function reset_alert()
{
  // $("#error-message").html('');
  // $("#error-message").animate({
  //   opacity : 0,
  //   height: 0,
  // }, 2000, function(){
  //   $("#error-message").html("");
  // });
  $("#error-message > div").each(function(){
    $(this).fadeOut(500, function(){
      $(this).remove();
    });
  })
}

function add_alert(str)
{
  var new_alert = $(str).hide();
  $("#error-message").append(new_alert);
  new_alert.fadeIn(1000);
}

function delete_kategori(id)
{
  var conf = confirm("Yakin ingin menghapus kategori ini?");
  if(conf){
    reset_alert();
    $.ajax({
      url : base_url('admin/delete_kategori'),
      data : {id:id},
      type : 'POST',
      dataType : 'json',
      success : function(data){
        if(data.success){
          get_list_kategori();
        }else{
          add_alert("<div class='peringatan merah'>Kategori tidak dapat dihapus (mungkin) karena ada barang yang memakai kategori tersebut.</div>");
        }
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
  $(".form-login").parents('.cd-container').removeClass('cd-container');
  $(".form-login").parents('body').css('background','#CFD8DC');

  $("#menu-atas li a").each(function(){
    var thisHref = $(this).attr('href');
    var locationNow = window.location.href;

    if(thisHref == locationNow)
    {
      $(this).addClass('aktif');
    }
  });

  $(".li-kategori .ubah").click(function(){
    var kategori_name = $(this).parents('.li-kategori').find('label').find('span').text();

    var input_baru = "<table width='100%'><tr><td><input autofocus style='border:0px;border-bottom:1px solid #eee;background:transparent;width:100%;' placeholder='Nama kategori' nama='nama' value='"+kategori_name+"'/></td><td><a href='#!' class='do_edit'><i class='fa fa-check'></i></a></td></tr></table>";

    $(this).parents('.li-kategori').html(input_baru);
  });
});

$(window).bind("load resize", function(){
  form_login_location();
});
$("body").bind("DOMSubtreeModified", function() {
  form_login_location();

  $(".li-kategori .do_edit").click(function(){
    var kategori_id = $(this).parents('.li-kategori').attr('kategori-id');
    var kategori_name = $(this).parents('.li-kategori').find('input').val();
    var kategori_div = $(this).parents('.li-kategori');
    $("#error-message").html('');

    $.ajax({
      url : 'edit_kategori',
      type : 'POST',
      data : {id: kategori_id, nama: kategori_name},
      dataType : 'json',
      success : function(data){
        if(data.success == false)
        {
          // alert(data.error);
          $("#error-message").append('<div class="peringatan merah">'+data.error+'</div>');
        }
        else
        {
          var baru = '';
          baru += "<table><tr><td width='30'><span>";
          baru += "<a href='#!' class='hapus'><i class='fa fa-trash'></i></a> ";
          baru += "<a href='#!' class='ubah'><i class='fa fa-pencil'></i></a>";
          baru += "</span></td>";
          baru += "<td><label><span class='nama'>"+kategori_name+"</span></label></td></tr></table>";
          kategori_div.html(baru);
        }
      }
    });
  });

  $(".li-kategori .ubah").click(function(){
    var kategori_name = $(this).parents('.li-kategori').find('label').find('span').text();

    var input_baru = "<table width='100%'><tr><td><input autofocus style='border:0px;border-bottom:1px solid #eee;background:transparent;width:100%;' placeholder='Nama kategori' nama='nama' value='"+kategori_name+"'/></td><td><a href='#!' class='do_edit'><i class='fa fa-check'></i></a></td></tr></table>";

    $(this).parents('.li-kategori').html(input_baru);
  });

});


$("#add-kategori label").click(function(){
  reset_alert();
  var nama_kategori = $(this).parents('#add-kategori').find('input').val();
  var label = $(this);
  if(nama_kategori){
    label.html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
    $.ajax({
      url : base_url('admin/add_kategori'),
      type : 'POST',
      dataType : 'json',
      data : {nama:nama_kategori},
      success : function(data){
        if(data.success){
          get_list_kategori();
          label.parents("#add-kategori").find('input').val('');
        }else{
          $.each(data.error, function(index, element){
            add_alert("<div class='peringatan merah'>"+element+"</div>");
          });
        }
        label.html("<i class='fa fa-plus'></i>");
      }
    });
  }
});

function get_list_petugas()
{
  var div_list_petugas = $("#list-petugas");

  $.ajax({
    url : base_url('admin/list_petugas'),
    dataType : 'json',
    success : function(data){
      $.each(data, function(index, element){
        var petugas = '';
        petugas += '<div class="petugas">';
      });
    }
  });
}
