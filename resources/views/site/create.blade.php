@extends('layouts.app')

@section('content')
    <div class="container" id="siteAddPage">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route("home.store") }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Url</label>
                        <input placeholder="google.com" class="form-control" name="url" value="{{ old("url") ?? $site->url }}">
                    </div>
                    <div class="form-group">
                        <div class="card">
                            <div class="card-header">
                                <input id="type_http" @if(old("type") == "http" || $site->type == "http") checked @endif type="radio" value="http" name="type">
                                <label class="type_label btn btn-primary" for="type_http">HTTP Code</label>
                                <input id="type_string" @if(old("type") == "string" || $site->type == "string") checked @endif type="radio" value="string" name="type">
                                <label class="type_label btn btn-primary" for="type_string">String</label>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Required HTTP Code (or Required String)</label>
                                    <input placeholder="200 / string" class="form-control" name="response" value="{{ old("url") ?? $site->response }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email address for notification </label>
                        <input placeholder="email@site.com" class="form-control" name="email" value="{{ old("email") ?? $site->email }}">
                    </div>
                    <div class="d-flex justify-content-end">
                        <a class="btn-primary btn mr-2" href="{{ route("home.index") }}">Cancel</a>
                        <button class="btn-success btn">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
