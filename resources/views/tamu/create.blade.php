@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <h6>Add Mahasiswa</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            @if ($errors->any())
              <div class="alert alert-danger" >
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            <form action="/tamu" method="POST">
                @csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Nama visitor</label>
                  <input name="name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nama visitor">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Asal Instansi</label>
                    <input name="asal" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Asal Instansi">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">UID</label>
                    <input name="rfid" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Tempelkan Kartu Ke RFID Reader">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Pekerjaan</label>
                    <input name="pekerjaan" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Gunakan huruf kapital">
                </div>
                <div>
                    <label for="exampleInputEmail1">preference</label>
                    <select class="form-select" name="preferences" aria-label="Default select example">
                        <option selected disabled>Pilih Peran</option>
                        <option value="Tenaga Didik">TENAGA DIDIK</option>
                        <option value="Tenaga Ajar">TENAGA AJAR</option>
                        <option value="Mahasiswa">MAHASISWA</option>
                        <option value="Tamu Luar">TAMU LUAR</option>
                    </select>                                        
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
      </div>
    </div>
</div>   
@endsection