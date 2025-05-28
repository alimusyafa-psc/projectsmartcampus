@extends('layouts.master')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header text-white text-center rounded-top">
                <h5 class="m-0 pt-0 fw-bold">Tambah Jadwal Kelas</h5>
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
                <form action="/jadwal" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label for="kelas" class="form-label fw-semibold">Kelas</label>
                        <input name="kelas" type="text" class="form-control @error('kelas') is-invalid @enderror" id="kelas" placeholder="Nama Kelas">
                        @error('kelas') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                     <div class="mb-2">
                        <label for="id_kelas" class="form-label fw-semibold">ID Kelas</label>
                        <input name="id_kelas" type="text" class="form-control @error('id_kelas') is-invalid @enderror" id="id_kelas" placeholder="ID Kelas">
                        @error('id_kelas') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-2">
                        <label for="mata_kuliah" class="form-label fw-semibold">Mata Kuliah</label>
                        <input name="mata_kuliah" type="text" class="form-control @error('mata_kuliah') is-invalid @enderror" id="mata_kuliah" placeholder="ex: Praktikum Rangkaian Listrik">
                        @error('mata_kuliah') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-2">
                        <label for="waktu_mulai" class="form-label fw-semibold">Waktu Mulai</label>
                        <input name="waktu_mulai" type="time" class="form-control @error('waktu_mulai') is-invalid @enderror" id="waktu_mulai">
                        @error('waktu_mulai') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-2">
                        <label for="waktu_selesai" class="form-label fw-semibold">Waktu Selesai</label>
                        <input name="waktu_selesai" type="time" class="form-control @error('waktu_selesai') is-invalid @enderror" id="waktu_selesai">
                        @error('waktu_selesai') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Simpan Jadwal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection