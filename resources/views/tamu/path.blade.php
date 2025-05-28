@extends('layouts.master')

@section('content')
<div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Data Video Path</h6>
              <a href="/tamu/path/create" class="btn btn-primary float-end">Add</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Title</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Path</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Category</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($videos as $video)
                    <tr>
                      <td>{{ $video->id }}</td>
                      <td>{{ $video->title }}</td>
                      <td>{{ $video->path }}</td>
                      <td>{{ $video->category }}</td>
                      <td>
                        <a href="/tamu/path/{{ $video->id }}/edit" class="btn btn-warning">Edit</a>
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