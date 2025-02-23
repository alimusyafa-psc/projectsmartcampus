@extends('layouts.master')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header text-white text-center rounded-top">
                <h5 class="m-0 pt-0 fw-bold">Profil</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('profile.update', Auth::user()->id) }}" method="post">
                    @csrf
                    @method('patch')

                    <div class="mb-2">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" disabled>
                    </div>

                    <div class="mb-2">
                        <label for="role" class="form-label fw-semibold">Role</label>
                        <input type="text" class="form-control" id="role" name="role" value="{{ Auth::user()->role }}" disabled>
                    </div>

                    <div class="mb-2">
                        <label for="nama" class="form-label fw-semibold">Nama</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ Auth::user()->nama }}">
                        @error('nama') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <hr>

                    <div class="mb-2">
                        <label for="password_lama" class="form-label fw-semibold">Password Lama</label>
                        <input type="password" class="form-control @error('password_lama') is-invalid @enderror" id="password_lama" name="password_lama" required>
                        @error('password_lama') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-2">
                        <label for="password_baru" class="form-label fw-semibold">Password Baru</label>
                        <input type="password" class="form-control @error('password_baru') is-invalid @enderror" id="password_baru" name="password_baru" required>
                        @error('password_baru') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-2">
                        <label for="password_konfirmasi" class="form-label fw-semibold">Konfirmasi Password</label>
                        <input type="password" class="form-control @error('password_konfirmasi') is-invalid @enderror" id="password_konfirmasi" name="password_konfirmasi" required>
                        @error('password_konfirmasi') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection