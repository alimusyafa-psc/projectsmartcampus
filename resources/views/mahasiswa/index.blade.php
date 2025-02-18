@extends('layouts.master')

@section('content')
<a href="/datamahasiswa" class="btn btn-primary">Data Mahasiswa</a>
<a href="/jadwal" class="btn btn-primary">Jadwal Kelas</a>
<div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Data Akses Mahasiswa</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Mahasiswa</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">uid</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ID Mahasiswa</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kelas</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nilai</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Relay</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu akses</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($riwayatAkses as $akses)
                    <tr>
                        <td>{{ $akses->id_riwayat }}</td>
                        <td>{{ $akses->mahasiswa->nama ?? 'Nama tidak ditemukan' }}</td> <!-- Tampilkan nama mahasiswa -->
                        <td>{{ $akses->uid}}</td>
                        <td>{{ $akses->id_mahasiswa}}</td>
                        <td>{{ $akses->mahasiswa->kelas?? 'Nama tidak ditemukan'}}</td>
                        <td>{{ $akses->nilai}}</td>
                        <td>{{ $akses->relay }}</td>
                        <td>{{ $akses->waktu_tapping }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection