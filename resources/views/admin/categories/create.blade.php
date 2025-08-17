@extends('layouts.app')
@section('title','Add Category')

@section('content')
<div class="section-header"><h1>Add Category</h1></div>

@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
  </div>
@endif

<form action="{{ route('category.store') }}" method="POST">
@csrf
<div class="card">
  <div class="card-body">
    <div class="form-group">
      <label>Name</label>
      <input name="name" class="form-control" value="{{ old('name') }}" required>
    </div>
    <div class="form-group">
      <label>Slug <small class="text-muted">(optional)</small></label>
      <input name="slug" class="form-control" value="{{ old('slug') }}">
    </div>
  </div>
  <div class="card-footer">
    <a href="{{ route('category.index') }}" class="btn btn-secondary">Back</a>
    <button class="btn btn-primary float-right">Save</button>
  </div>
</div>
</form>
@endsection
