@extends('layouts.master')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header text-white text-center rounded-top">
                <h5 class="m-0 pt-0 fw-bold">Tambah Mahasiswa</h5>
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
                <form action="/datamahasiswa" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label for="nama" class="form-label fw-semibold">Nama</label>
                        <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" placeholder="Nama Mahasiswa">
                        @error('nama') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-2">
                        <label for="nrp" class="form-label fw-semibold">NRP</label>
                        <input name="nrp" type="text" class="form-control @error('nrp') is-invalid @enderror" id="nrp" placeholder="NRP">
                        @error('nrp') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-2">
                        <label for="kelas" class="form-label fw-semibold">Kelas</label>
                        <input name="kelas" type="text" class="form-control @error('kelas') is-invalid @enderror" id="kelas" placeholder="ex: 1 D3 TELKOM A, 3 D4 MMB B">
                        @error('kelas') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-2">
                        <label for="uid" class="form-label fw-semibold">UID</label>
                        <input name="uid" type="text" class="form-control @error('uid') is-invalid @enderror" id="uid" placeholder="Tempelkan Kartu ke RFID Reader">
                        @error('uid') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-2">
                        <label for="relay" class="form-label fw-semibold">Relay</label>
                        <input name="relay" type="text" class="form-control @error('relay') is-invalid @enderror" id="relay" placeholder="Tempelkan Kartu ke RFID Reader">
                        @error('relay') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="Departemen" class="form-label fw-semibold">Departemen</label>
                        <input name="Departemen" type="text" class="form-control @error('Departemen') is-invalid @enderror" id="Departemen" placeholder="ex: Teknik Elektro">
                        @error('Departemen') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection