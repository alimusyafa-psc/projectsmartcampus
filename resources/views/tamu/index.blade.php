@extends('layouts.master')

@section('content')
<div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Data Tamu</h6>
              <a href="/tamu/create" class="btn btn-primary float-end">Add</a>
              <a href="/tamu/path" class="btn btn-primary float-end me-2">Video Path</a>              
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Tamu</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Asal</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Pekerjaan</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu akses</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($riwayatTamu as $akses)
                    <tr>
                        <td>{{ $loop->iteration + ($riwayatTamu->currentPage() - 1) * $riwayatTamu->perPage() }}</td>
                        <td>{{ $akses->tamu->name ?? 'Nama tidak ditemukan' }}</td>
                        <td>{{ $akses->tamu->asal ?? 'Asal tidak ditemukan' }}</td>
                        <td>{{ $akses->tamu->pekerjaan ?? 'Pekerjaan tidak ditemukan' }}</td>
                        <td>{{ $akses->access_time }}</td>
                    </tr>
                    @endforeach
                </tbody>         
                </table>
                <div class="d-flex justify-content-center mt-3">
                  {{ $riwayatTamu->links('pagination::bootstrap-5') }}
                </div>              
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection