/*
  Codedicate Copyright Javascript
*/

var start_barang = 0;
var limit_barang = 10;

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

if($(".pilih-kategori").length){
  $.ajax({
    url : base_url('admin/list_kategori'),
    dataType : 'json',
    success : function(data){
      var del = 500;
      $.each(data, function(index, element){
        $(".pilih-kategori").append("<option value='"+element.idkategori+"'>"+element.nama+"</option>");
      });
    }
  });
};

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

  $("small").each(function(){
    if($(this).text() == 'Administrator'){
      $(this).css('background','#2196F3');
    }
  });

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

  $(".bg-hitam").click(function(){
    closeModal();
  });

  $(".quantity").change(function(){
    var harga = $(this).parents('tr').attr('hargabarang');
    var qty = $(this).val();

    harga = parseInt(harga);
    qty = parseInt(qty);

    $(this).parents("tr").find('td:nth-child(4)').text( toRupiah(harga*qty) );

    keranjang_hitung_total();

  });

  function closeModal()
  {
    $(".modal").animate({
      top: '-100px',
    },300,function(){
      $(".modal").hide();
      $(".bg-hitam").remove();
    })
    reset_alert();
  }

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
          baru += "<a href='#!' class='hapus' onclick='delete_kategori("+kategori_id+")'><i class='fa fa-trash'></i></a> ";
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

$("#keranjang tbody").bind("DOMSubtreeModified", function() {
  keranjang_hitung_total();
});

function keranjang_hitung_total()
{
  var total = 0;
  $("#keranjang tbody > tr").each(function(){
    var harga_barang = $(this).attr('hargabarang');
    var qty = $(this).find('select').val();

    harga_barang = parseInt(harga_barang);
    qty = parseInt(qty);

    total += (harga_barang*qty);
  });

  $("#keranjang .panel-footer").html( toRupiah(total) );
}

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

function openModal(str)
{
  $(".bg-hitam").remove();
  $("#"+str).after("<div class='bg-hitam'></div>");
  $("#"+str).show();
  $("#"+str).animate({
    top: 30,
  },300);
}

function tambah_barang()
{
  var nama = $("#nama-barang").val();
  var deskripsi = $("#deskripsi-barang").val();
  var kategori = $("#tambah-barang .pilih-kategori").val();
  var harga = $("#harga-barang").val();
  var stok = $("#stok-barang").val();
  $("#tambah-barang button").html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Loading&hellip;');

  $.ajax({
    url : base_url('admin/add_barang'),
    type : 'POST',
    dataType : 'json',
    data : {nama:nama, deskripsi:deskripsi, kategori:kategori, harga:harga, stok:stok},
    success : function(data){
      reset_alert();
      if(data.success){
        add_alert("<div class='peringatan hijau'>Barang berhasil ditambahkan</div>");
        get_list_barang();
        $("#nama-barang").val('');
        $("#deskripsi-barang").val('');
        $("#pilih-kategori").val('');
        $("#harga-barang").val('');
        $("#stok-barang").val('');
      }else{
        $.each(data.error, function(index, element){
          add_alert("<div class='peringatan merah'>"+element+"</div>");
        });
      }
      $("#tambah-barang button").html('Tambah');
    }
  });
}

function get_list_barang(start = 0, limit = 10)
{
  start_barang = start;
  limit_barang = 10;
  $("#list-barang tbody").html('');

  $.get(base_url('admin/list_barang/'+start+'/'+limit), function(data){
    if(data){
      var no = start+1;
      var total_barang = 0;
      $.each(data, function(index, element){
        var tr = '<tr>';
        tr += '<td>'+no+'</td>';
        tr += '<td>'+element.nama_barang+'</td>';
        tr += '<td>'+element.nama_kategori+'</td>';
        tr += '<td>'+toRupiah(parseInt(element.harga))+'</td>';
        tr += '<td>'+element.stok+'</td>';
        tr += '<td><label class="hapus" onclick="hapus_barang('+element.idbarang+')"><i class="fa fa-trash"></i></label> <label class="ubah" onclick="ubah_barang('+element.idbarang+')"><i class="fa fa-pencil"></i></label></td>';
        tr += '</tr>';
        $("#list-barang tbody").append(tr);
        no++;
        total_barang = element.total_barang;
      });

      // $("#navigasi > label").remove();

      // alert(start+","+limit);

      if(start > 0){
        // if($("#navigasi .prev").length == 0){
        //   $("#navigasi").append("<label class='prev' onclick='get_list_barang("+(start-limit)+","+limit+")'>Prev</label>");
        // }
        $("#navigasi .prev").attr('onclick','get_list_barang('+(start-limit)+','+limit+')');
        $("#navigasi .prev").removeClass('non-aktif');
      }else{
        $("#navigasi .prev").removeAttr('onclick');
        $("#navigasi .prev").addClass('non-aktif');
      }

      if(start+limit < total_barang){
        // $("#navigasi").append("<label class='next' onclick='get_list_barang("+(start+limit)+","+limit+")'>Next</label>");
        $("#navigasi .next").attr('onclick','get_list_barang('+(start+limit)+','+limit+')');
        $("#navigasi .next").removeClass('non-aktif');
      }else{
        $("#navigasi .next").removeAttr('onclick');
        $("#navigasi .next").addClass('non-aktif');
      }

    }else{
      alert("Data tidak ditemukan");
    }
  }, 'json');
}

function toRupiah(isi)
{
  return 'Rp '+isi.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
}

function ubah_barang(idbarang)
{
  idbarang = parseInt(idbarang);
  openModal('edit-barang');

  $.get(base_url('admin/get_barang/'+idbarang), function(data){
    $("#edit-barang .nama-barang").val(data.nama_barang);
    $("#edit-barang .deskripsi-barang").val(data.deskripsi);
    $("#edit-barang .harga-barang").val(data.harga);
    $("#edit-barang .stok-barang").val(data.stok);
    $("#edit-barang .id-barang").val(data.idbarang);
    var kategori = data.idkategori;

    $("#edit-barang .pilih-kategori option").each(function(){
      if( $(this).attr('value') == kategori ){
        $(this).attr('selected', 'selected');
      }
    });
  },'json');

}

function hapus_barang(id)
{
  id = parseInt(id);
  var conf = confirm("Yakin ingin menghapus barang ini?");

  if(conf){
    $.get(base_url('admin/hapus_barang/'+id), function(data){
      get_list_barang();
    });
  }
}

function do_edit_barang()
{
  var nama = $("#edit-barang .nama-barang").val();
  var deskripsi = $("#edit-barang .deskripsi-barang").val();
  var kategori = $("#edit-barang .pilih-kategori").val();
  var harga = $("#edit-barang .harga-barang").val();
  var stok = $("#edit-barang .stok-barang").val();
  var id = $("#edit-barang .id-barang").val();

  $.ajax({
    url : base_url('admin/edit_barang'),
    type : 'POST',
    data : {nama:nama, deskripsi:deskripsi, kategori:kategori, harga:harga, stok:stok, id:id},
    dataType : 'json',
    success : function(data){
      reset_alert();
      if(data.success){
        add_alert("<div class='peringatan hijau'>Barang berhasil diubah</div>");
        get_list_barang(start_barang, limit_barang);
      }else{
        $.each(data.error, function(index, element){
          add_alert("<div class='peringatan merah'>"+element+"</div>");
        });
      }
    }
  });
}

$("#cari-barang input").change(function(){

  var q = $(this).val();

  $.ajax({
    url : base_url('petugas/cari_barang'),
    data : {q:q},
    type : 'POST',
    dataType : 'json',
    success : function(data){
      $("#cari-barang tbody").html('');

      var no = 1;
      $.each(data, function(index, element){
        var tr = '<tr>';
        tr += '<td>'+no+'</td>';
        tr += '<td>'+element.nama_barang+'</td>';
        tr += '<td>'+element.nama_kategori+'</td>';
        tr += '<td>'+toRupiah(parseInt(element.harga))+'</td>';
        tr += '<td>'+element.stok+'</td>';
        tr += '<td><label onclick="tambah_transaksi('+element.idbarang+')"><i class="fa fa-plus"></i></label></td>';
        tr += '</tr>';
        no++;
        $("#cari-barang tbody").append(tr);
      });

    }
  });

});

function tambah_transaksi(num)
{
  var banyak_tr = $("#keranjang tbody tr").length;
  $.ajax({
    url : base_url('petugas/tambah_transaksi'),
    type : 'POST',
    dataType : 'json',
    data : {id:num},
    success : function(data){
      reset_alert();
      if(data.success){
        var lanjut = true;
        $("#keranjang tbody tr").each(function(){
          if($(this).attr('idbarang')==data.item.idbarang){
            lanjut = false;
            add_alert("<div class='peringatan merah'>Barang sudah ada di keranjang</div>");
          }
        });

        if(lanjut){
          var tr = '<tr idbarang="'+data.item.idbarang+'" hargabarang="'+data.item.harga+'">';
          tr += '<td>'+data.item.nama_barang+'</td>';
          tr += '<td>'+toRupiah(parseInt(data.item.harga))+'</td>';

          var tr_select = '<select class="quantity">';
          for(i=1;i<=data.item.stok;i++){
            tr_select += "<option value='"+i+"'>"+i+"</option>";
          }
          tr_select += '</select>';

          tr += '<td>'+tr_select+'</td>';

          tr += '<td>'+toRupiah(parseInt(data.item.harga))+'</td>';

          tr += '</tr>';

          $("#keranjang tbody").append(tr);
        }
      }
    }
  });
}

function keranjang_proses()
{

  if( $("#keranjang tbody > tr").length > 0 ){

    var keranjang = [];
    $("#keranjang tbody > tr").each(function(){
      var idbarang = parseInt($(this).attr('idbarang'));
      var hargabarang = parseInt($(this).attr('hargabarang'));
      var qty = parseInt($(this).find('select').val());

      var barang = {id:idbarang, harga:hargabarang, qty:qty};
      keranjang.push(barang);
    });

    $.post(base_url('petugas/keranjang_proses'), {keranjang:JSON.stringify(keranjang)}, function(data){
      window.location.reload();
      window.open(base_url('petugas/print_transaksi/'+data));
    });

  }else{
    add_alert("<div class='peringatan merah'>Belum ada barang di keranjang</div>");
  }

}
