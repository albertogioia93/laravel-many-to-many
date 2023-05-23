@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
      <h2 class="fs-4 text-secondary my-4">
          Lista dei post
      </h2>
      <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">Crea post</a>
    </div>

    @if (session('message'))
    {{-- <div class="alert alert-success">
      {{ session('message') }}
    </div> --}}
    
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
      <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
          <strong class="me-auto">Notifica</strong>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
          {{ session('message') }}
        </div>
      </div>
    </div>
    @endif

    <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Slug</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($posts as $post)  
          <tr>
            <th scope="row">{{ $post->id }}</th>
            <td>{{ $post->title }}</td>
            <td>{{ $post->slug }}</td>
            <td>
                <ul class="list-unstyled d-flex m-0 gap-1 justify-content-end">
                    <li><a href="{{ route('admin.posts.show', $post->slug) }}" class="btn btn-sm btn-primary">Show</a></li>
                    <li><a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-warning">Edit</a></li>
                    <li>
                      <form action="{{ route('admin.posts.destroy', $post) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-sm btn-danger">Delete</button>
                      </form>
                    </li>
                </ul>
            </td>
          </tr>
          @endforeach
        </tbody>
    </table>
</div>
@endsection