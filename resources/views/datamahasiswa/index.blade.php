@extends('layouts.master')

@section('content')
<a href="/datamahasiswa" class="btn btn-secondary">Data Mahasiswa</a>
<a href="/jadwal" class="btn btn-primary">Jadwal Kelas</a>
<div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Data Mahasiswa</h6>
              <a href="/datamahasiswa/create" class="btn btn-primary float-end">Tambah Data Mahasiswa</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">RFID</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Mahasiswa</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">NRP</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kelas</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Relay</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($tbmahasiswa as $mahasiswa)
                    <tr>
                        <td>{{ $mahasiswa->uid }}</td>
                        <td>{{ $mahasiswa->nama }}</td>
                        <td>{{ $mahasiswa->nrp }}</td>
                        <td>{{ $mahasiswa->kelas }}</td>
                        <td>{{ $mahasiswa->relay->relay ?? 'Tidak ada relay' }}</td>
                        <td>
                          <form action="/datamahasiswa/{{ $mahasiswa->id_mahasiswa }}" method="POST">
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