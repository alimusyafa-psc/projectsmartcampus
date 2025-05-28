@extends('layouts.master')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header text-white text-center rounded-top">
                <h5 class="m-0 pt-0 fw-bold">{{ isset($video) ? 'Edit Video Path' : 'Tambah Video Path' }}</h5>
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

                <form action="{{ isset($video) ? url('/tamu/path/' . $video->id) : url('/tamu/path') }}" method="POST">
                    @csrf
                    @if(isset($video))
                        @method('PUT')
                    @endif

                    <div class="mb-2">
                        <label for="title" class="form-label fw-semibold">Judul Video</label>
                        <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                               placeholder="Judul Video"
                               value="{{ old('title', $video->title ?? '') }}">
                        @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-2">
                        <label for="path" class="form-label fw-semibold">Path</label>
                        <input name="path" type="text" class="form-control @error('path') is-invalid @enderror" id="path"
                               placeholder="Tanpa tanda petik"
                               value="{{ old('path', $video->path ?? '') }}">
                        @error('path') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="category" class="form-label fw-semibold">Preference</label>
                        <select class="form-select @error('category') is-invalid @enderror" name="category" id="category">
                            <option disabled {{ isset($video) ? '' : 'selected' }}>Pilih Peran</option>
                            @foreach(['TENAGA DIDIK', 'TENAGA AJAR', 'MAHASISWA', 'TAMU LUAR'] as $option)
                                <option value="{{ $option }}" {{ (old('category', $video->category ?? '') == $option) ? 'selected' : '' }}>
                                    {{ strtoupper($option) }}
                                </option>
                            @endforeach
                        </select>
                        @error('category') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            {{ isset($video) ? 'Update Data' : 'Simpan Data' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
