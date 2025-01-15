@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                @if (!auth()->user()->is_admin)
                    <div class="card">
                        <div class="card-header">
                            Add New Post
                        </div>
                        <div class="card-body">
                            <form action="{{ route('posts.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id="title"
                                        aria-describedby="titleHelp" placeholder="Enter Title">
                                    <small id="titleHelp" class="form-text text-muted">We'll never share your email with
                                        anyone
                                        else.</small>
                                </div>
                                <div class="form-group">
                                    <label for="body">Body</label>
                                    <textarea name="body" class="form-control" id="body" rows="3"></textarea>
                                </div>
                                <button type="submit" class="mt-3 btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-header">
                            Show Notification
                        </div>
                        <div class="card-body">
                            <div id="notification"></div>
                        </div>
                    </div>
                @endif



            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        All Post

                    </div>

                    <div class="card-body">
                        {{-- Make Boostrap Table --}}
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Body</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $post)
                                    <tr>
                                        <td>{{ $post->id }}</td>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->body }}</td>
                                        <td style="width: 220px;" class="text-center">
                                            <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">View</a>
                                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @if (auth()->user()->is_admin)
        <script type="module">
            window.Echo.channel('posts')
                .listen('.create', (e) => {
                    // console.log(e);
                    // document.getElementById('notification').insertAdjacentHTML = `
            // <div class="alert alert-success" role="alert">${e.message}</div>`;
                    // insertAdjacentHTML Using
                    document.getElementById('notification').insertAdjacentHTML('beforeend',
                        `<div class="alert alert-success" role="alert">${e.message}</div>`);
                });
        </script>
    @endif
@endsection
