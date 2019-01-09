@extends('poster::layouts.poster')

@section('content')
<div class="container">
    <table class="table mt-4">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Content</th>
                <th scope="col">Image</th>
                <th scope="col">Via</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <th scope="row">1</th>
                    <td>{{ $post->content }}</td>
                    <td>
                        <a href="{{ $post->image }}" target="_blank">Click to view</a>
                    </td>
                    <td>
                        @foreach($post->via as $medium)
                            {{ $medium }},
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
