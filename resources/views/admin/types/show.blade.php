@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fs-4 text-secondary my-4">
            {{ $type->name }}
        </h2>


        <ul>
        @foreach ($type->posts as $post)
            <li><a href="{{ route('admin.posts.edit', $post) }}">{{ $post->title }}</a></li>
        @endforeach
        </ul>
        <hr>
        <a href="{{ route('admin.types.edit', $type) }}" class="btn btn-sm btn-warning">Edit</a>

    </div>
@endsection