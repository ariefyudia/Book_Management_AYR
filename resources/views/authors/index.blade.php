@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Auhtors </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('authors.create') }}" title="Create a project"> 
                    <i class="fas fa-plus-circle"></i> Create
                </a>
            </div>
        </div>
    </div>
    <hr>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    @if ($message = Session::get('danger'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered table-responsive-lg">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($authors as $author)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $author->name }}</td>
                <td>
                    <form action="{{ route('authors.destroy', $author->id) }}" method="POST">

                        <!-- <a href="{{ route('authors.show', $author->id) }}" title="show">
                            <i class="fas fa-eye text-success  fa-lg"></i>
                        </a> -->

                        <a href="{{ route('authors.edit', $author->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit  fa-lg"></i>
                            Edit
                        </a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" title="delete" class="btn btn-danger">
                            <i class="fas fa-trash fa-lg text-danger"></i>
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {!! $authors->links() !!}

@endsection
