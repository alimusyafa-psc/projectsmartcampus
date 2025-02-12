@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <h6>Add Mahasiswa</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <form action="/datamahasiswa" method="POST">
              @csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Nama</label>
                  <input name='nama' type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nama Mahasiswa">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">NRP</label>
                    <input name='nrp' type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="NRP">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Kelas</label>
                    <input name='kelas' type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="ex: 1 D3 TELKOM A, 3 D4 MMB B">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">UID</label>
                    <input name='uid' type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Tempelkan Kartu ke RFID Reader">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Departemen</label>
                  <input name='Departemen' type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="ex: Teknik Elektro">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
      </div>
    </div>
</div>   
@endsection