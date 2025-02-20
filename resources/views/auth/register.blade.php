@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <h6>Sign Up</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <form action="/sesi" method="POST">
              @csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Nama</label>
                  <input name='nama' type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nama Mahasiswa">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input name='email' type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="ex: Praktikum Rangkaian Listrik">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Password</label>
                    <input name='password' type="text" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                </div>
                <div>
                  <label for="exampleInputEmail1">Role</label>
                  <select class="form-select" name="role" aria-label="Default select example">
                      <option selected disabled>Pilih Peran</option>
                      <option value="ADMIN">Admin</option>
                      <option value="TAMU">Admin Tamu</option>
                      <option value="MAHASISWA">Admin Mahasiswa</option>
                  </select>                                        
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
      </div>
    </div>
</div>   
@endsection