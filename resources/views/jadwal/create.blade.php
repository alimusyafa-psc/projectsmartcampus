@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <h6>Add Mahasiswa</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <form action="/jadwal" method="POST">
              @csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Kelas</label>
                  <input name='kelas' type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nama Mahasiswa">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Mata Kuliah</label>
                    <input name='mata_kuliah' type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="ex: Praktikum Rangkaian Listrik">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Waktu Mulai</label>
                    <input name='waktu_mulai' type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="ex: 13:50">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Waktu Selesai</label>
                    <input name='waktu_selesai' type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="ex: 14:50">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
      </div>
    </div>
</div>   
@endsection