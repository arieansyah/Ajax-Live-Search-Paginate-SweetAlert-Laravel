@extends('layouts.app')

@section('content')

    <div class="container">
      <input type="text" name="search" id="search" placeholder="Search by Customer Details" class="form-control" />
    </div>

    <div class="result">

    </div>

    @include('form')
@endsection

@section('script')
  <script type="text/javascript">
  var save_method;
  $(document).ready(function(){

    $('#modal-form form').validator().on('submit', function(e){
       if(!e.isDefaultPrevented()){
          var id = $('#id').val();
          if(save_method == "add") url = "{{ route('siswa.store') }}";
          else url = "siswa/"+id;

          $.ajax({
            url : url,
            type : "POST",
            data : $('#modal-form form').serialize(),
            dataType: 'JSON',
            success : function(data){
              if (data.msg == "error") {
                swal("Failed", "NISN sudah ada", "warning");
              }else {
                swal("Success", "Successfully", "success");
                $('#modal-form').modal('hide');
                fetch_siswa_data();
              }
            },
            error : function(){
              alert("Tidak dapat menyimpan data!");
            }
          });
          return false;
      }
    });

    fetch_siswa_data();

     $(document).on('keyup', '#search', function(){
      var search = $(this).val();
      fetch_siswa_data(search);
     });

     $(document).on('click', '.pagination a', function(event){
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        fetch_data(page, $('#search').val());
      });
    });

  function fetch_data(page)
  {
     $.ajax({
      url:"/siswa/search?page="+page,
      type: "get",
      //dataType:'json',
      success:function(data)
      {
       $('.result').html(data);
      }
     });
  }

  function addForm(){
      save_method = "add";
     $('input[name=_method]').val('POST');
     $('#modal-form').modal('show');
     $('#modal-form form')[0].reset();
     $('.modal-title').text('Tambah Siswa');
  }

  function fetch_siswa_data(search = '')
  {
   $.ajax({
    url:"/siswa/search",
    method:'GET',
    data : {'search' : search},
    //dataType:'json',
    success:function(data)
    {
     $('.result').html(data);
    }
   })
  }

  function editForm(id){
     save_method = "edit";
     $('input[name=_method]').val('PATCH');
     $('#modal-form form')[0].reset();
     $.ajax({
       url : "siswa/"+id+"/edit",
       type : "GET",
       dataType : "JSON",
       success : function(data){
         $('#modal-form').modal('show');
         $('.modal-title').text('Edit Kategori');

         $('#id').val(data.id_siswa);
         $('#nisn').val(data.nisn);
         $('#nama').val(data.nama_siswa);

       },
       error : function(){
         alert("Tidak dapat menampilkan data!");
       }
     });
  }

  function deleteData(id){
    swal({
      title: "Apakah Anda Yakin?",
      text: "data akan dihapus?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url : "siswa/"+id,
          type : "POST",
          data : {'_method' : 'DELETE', '_token' : $('meta[name=csrf-token]').attr('content')},
          success : function(data){
              fetch_siswa_data();
            },
          error: function (xhr, ajaxOptions, thrownError) {
                swal("Error deleting!", "Please try again", "error");
            }
        });
    }});
  }
  </script>

@endsection
