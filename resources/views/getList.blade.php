<div class="container">
  <div class="container-fluid">
    <div class="row">
        <h2>Siswa</h2>
        <button type="button" class="btn btn-success" onclick="addForm()">Tambah</button>
    </div>
    <div class="row">
      <div id="table_data">
        <table class="table">
          <thead>
            <tr>
              <th width="30">ID</th>
              <th>NISN</th>
              <th>Nama</th>
              <th width="100">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($guru as $value)
              <tr>
                <td>{{$value->id_siswa}}</td>
                <td>{{$value->nisn}}</td>
                <td>{{$value->nama_siswa}}</td>
                <td>
                  <div class="btn-group">
                    <a onclick="editForm('{{$value->id_siswa}}')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                    <a onclick="deleteData('{{$value->id_siswa}}')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="row">
      {!! $guru->links() !!}
    </div>

    <div class="row">
        Data <strong>{{$search}}</strong>  Not found
    </div>
  </div>
</div>
