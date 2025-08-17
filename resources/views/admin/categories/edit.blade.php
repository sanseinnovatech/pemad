@extends('layouts.app')
@section('title','Edit Category')

@section('content')
<div class="section-header"><h1>Edit Category</h1></div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
  </div>
@endif

<form action="{{ route('category.update',$category) }}" method="POST">
@csrf @method('PUT')
<div class="card">
  <div class="card-body">
    <div class="form-group">
      <label>Name</label>
      <input name="name" class="form-control" value="{{ old('name',$category->name) }}" required>
    </div>
    <div class="form-group">
      <label>Slug <small class="text-muted">(optional)</small></label>
      <input name="slug" class="form-control" value="{{ old('slug',$category->slug) }}">
    </div>
  </div>
  <div class="card-footer">
    <a href="{{ route('category.index') }}" class="btn btn-secondary">Back</a>
    <button class="btn btn-primary float-right">Update</button>
  </div>
</div>
</form>
@endsection
