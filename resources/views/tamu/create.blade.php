@extends('layouts.master')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header text-white text-center rounded-top">
                <h5 class="m-0 pt-0 fw-bold">Tambah Tamu</h5>
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
                <form action="/tamu" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label for="name" class="form-label fw-semibold">Nama Visitor</label>
                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nama visitor">
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-2">
                        <label for="asal" class="form-label fw-semibold">Asal Instansi</label>
                        <input name="asal" type="text" class="form-control @error('asal') is-invalid @enderror" id="asal" placeholder="Asal Instansi">
                        @error('asal') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-2">
                        <label for="rfid" class="form-label fw-semibold">UID</label>
                        <input name="rfid" type="text" class="form-control @error('rfid') is-invalid @enderror" id="rfid" placeholder="Tempelkan Kartu Ke RFID Reader">
                        @error('rfid') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-2">
                        <label for="pekerjaan" class="form-label fw-semibold">Pekerjaan</label>
                        <input name="pekerjaan" type="text" class="form-control @error('pekerjaan') is-invalid @enderror" id="pekerjaan" placeholder="Gunakan huruf kapital">
                        @error('pekerjaan') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-2">
                        <label for="preferences" class="form-label fw-semibold">Preference</label>
                        <select class="form-select @error('preferences') is-invalid @enderror" name="preferences" id="preferences">
                            <option selected disabled>Pilih Peran</option>
                            <option value="Tenaga Didik">TENAGA DIDIK</option>
                            <option value="Tenaga Ajar">TENAGA AJAR</option>
                            <option value="Mahasiswa">MAHASISWA</option>
                            <option value="Tamu Luar">TAMU LUAR</option>
                        </select>
                        @error('preferences') <span class="invalid-feedback">{{ $message }}</span> @enderror
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