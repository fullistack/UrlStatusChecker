@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route("start_check") }}" class="btn btn-primary">Active</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered sitesTable">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">Website</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Last Error</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            @foreach($sites as $site)
                                <tr>
                                    <td class="text-center w-25">{{ $site->url }}</td>
                                    <td class="text-center w-25">
                                        <kbd class="@if($site->check->status == "No data") bg-dark @elseif($site->check->status == "Available") bg-success @elseif($site->check->status == "Unavailable") bg-danger @else bg-info @endif">
                                        {{ $site->check->status }}
                                        </kbd>
                                    </td>
                                    <td class="text-center w-25">
                                        {!! $site->last_check ? $site->last_check->created_at."<br>".$site->last_check->error : "Never" !!}
                                    </td>
                                    <td class="text-center w-25">
                                        <div class="d-flex justify-content-center w-100">
                                            <a class="btn btn-success" href="{{ route("start_check_single",$site->id) }}">Check</a>
                                            &nbsp;
                                            <a class="btn btn-primary" href="{{ route("home.edit",$site->id) }}">Edit</a>
                                            &nbsp;
                                            <form onsubmit="return confirm('Delete Site ?')" method="POST" action="{{ route("home.destroy",$site->id) }}">
                                                @method("delete")
                                                @csrf
                                                <button class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
