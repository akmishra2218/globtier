@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Uploaded Files</h2>


        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        <form action="{{ url('/upload') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">Choose File</label>
                <input type="file" name="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>


        @if (count($files) > 0)
            <h3 class="mt-4">List of Files</h3>
            <ul>
                @foreach ($files as $file)
                    <li>
                        {{ $file->original_name }}
                        <a href="{{ url('/download', $file->id) }}" class="btn btn-sm btn-success">Download</a>
                        <form action="{{ url('/delete', $file->id) }}" method="post" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No files uploaded yet.</p>
        @endif
    </div>
@endsection
