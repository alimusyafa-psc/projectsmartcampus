@extends('layouts.master')

@section('content')
<a href="/datamahasiswa" class="btn btn-primary">Data Mahasiswa</a>
<a href="/jadwal" class="btn btn-secondary">Jadwal Kelas</a>
<div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Jadwal Kelas</h6>
              <a href="/jadwal/create" class="btn btn-primary float-end">Tambah Jadwal Kelas</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kelas</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mata Kuliah</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu Mulai</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu Selesai</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($tbkelas as $tbkelas)
                    <tr>
                        <td>{{ $tbkelas->kelas }}</td>
                        <td>{{ $tbkelas->mata_kuliah }}</td> <!-- Tampilkan nama mahasiswa -->
                        <td>{{ $tbkelas->waktu_mulai}}</td>
                        <td>{{ $tbkelas->waktu_selesai }}</td>
                        <td>
                          <form action="/jadwal/{{ $tbkelas->id_kelas }}" method="POST">
                            @method("DELETE")
                            @csrf
                            <input type="submit" class="btn btn-danger" value="Delete">
                          </form>
                        </td>
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