@extends('layouts.master')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header text-white text-center rounded-top">
                <h5 class="m-0 pt-0 fw-bold">Sign Up</h5>
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="/sesi" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label for="nama" class="form-label fw-semibold">Nama</label>
                        <input name='nama' type="text" class="form-control" id="nama" placeholder="Nama Mahasiswa">
                    </div>
                    <div class="mb-2">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input name='email' type="email" class="form-control" id="email" placeholder="Masukkan Email">
                    </div>
                    <div class="mb-2">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input name='password' type="password" class="form-control" id="password" placeholder="Password">
                    </div>
                    <div class="mb-2">
                        <label for="role" class="form-label fw-semibold">Role</label>
                        <select class="form-select" name="role" id="role">
                            <option selected disabled>Pilih Peran</option>
                            <option value="ADMIN">Admin</option>
                            <option value="TAMU">Admin Tamu</option>
                            <option value="MAHASISWA">Admin Mahasiswa</option>
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection