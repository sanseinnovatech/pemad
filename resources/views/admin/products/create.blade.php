@extends('layouts.app')
@section('title','Add Product')

@section('content')
<div class="section-header"><h1>Add Product</h1></div>

@if ($errors->any())
  <div class="alert alert-danger">
    <strong>Whoops!</strong> Please fix the following:<ul class="mb-0">
      @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
  </div>
@endif

<form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header"><h4>Main</h4></div>
      <div class="card-body">
        <div class="form-group">
          <label>Category</label>
          <select name="category_id" class="form-control" required>
            <option value="">-- choose --</option>
            @foreach($categories as $id => $name)
              <option value="{{ $id }}" @selected(old('category_id')==$id)>{{ $name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>Name</label>
          <input name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
          <label>Slug <small class="text-muted">(optional)</small></label>
          <input name="slug" class="form-control" value="{{ old('slug') }}">
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Base Price</label>
            <input type="number" step="0.01" min="0" name="base_price" class="form-control" value="{{ old('base_price') }}" required>
          </div>
          <div class="form-group col-md-6">
            <label>Stock</label>
            <input type="number" min="0" name="stock" class="form-control" value="{{ old('stock',0) }}" required>
          </div>
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea name="description" rows="5" class="form-control">{{ old('description') }}</textarea>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Variants</h4>
        <button type="button" class="btn btn-sm btn-primary" onclick="addVariantRow()"><i class="fas fa-plus"></i> Add Variant</button>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table mb-0" id="variants-table">
            <thead>
              <tr>
                <th style="width:16%">Option</th>
                <th>Value</th>
                <th>SKU</th>
                <th style="width:16%">Price</th>
                <th style="width:12%">Stock</th>
                <th style="width:8%"></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>

  <div class="col-lg-4">
    <div class="card">
      <div class="card-header"><h4>Image</h4></div>
      <div class="card-body">
        <div class="form-group">
          <div class="mb-2 text-center">
            <img id="imagePreview"
                 alt="Preview"
                 class="img-fluid rounded border"
                 style="max-height:240px;width:100%;object-fit:contain;background:#f8f9fa;display:none;">
          </div>
          <input type="file"
                 name="image"
                 id="imageInput"
                 class="form-control-file"
                 accept="image/*">
          <small class="form-text text-muted">
            Format: JPG, PNG, WEBP, GIF. Maks 4 MB.
          </small>
          <div class="mt-2">
            <button type="button" id="btnClearImage" class="btn btn-sm btn-outline-secondary">Clear</button>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <a href="{{ route('product.index') }}" class="btn btn-secondary">Back</a>
        <button class="btn btn-primary float-right">Save</button>
      </div>
    </div>
  </div>
</div>
</form>

<template id="variant-row-tpl">
<tr>
  <td>
    <select class="form-control" name="__NAME__[option_name]">
      <option value="">-</option>
      <option>Color</option>
      <option>Size</option>
      <option>Style</option>
      <option>Material</option>
    </select>
  </td>
  <td><input class="form-control" name="__NAME__[option_value]"></td>
  <td><input class="form-control" name="__NAME__[sku]" placeholder="AUTO if empty"></td>
  <td><input type="number" step="0.01" min="0" class="form-control" name="__NAME__[price]"></td>
  <td><input type="number" min="0" class="form-control" name="__NAME__[stock]" value="0"></td>
  <td class="text-right">
    <button type="button" class="btn btn-sm btn-danger" onclick="removeVariantRow(this)"><i class="fas fa-trash"></i></button>
  </td>
</tr>
</template>

@push('scripts')
<script>
let vIndex = 0;
function addVariantRow(prefill = null){
  const tpl = document.querySelector('#variant-row-tpl').innerHTML;
  const name = `variants[${vIndex++}]`;
  const tr = document.createElement('tbody');
  tr.innerHTML = tpl.replaceAll('__NAME__', name);
  const row = tr.firstElementChild;
  if(prefill){
    row.querySelector(`[name="${name}[option_name]"]`).value  = prefill.option_name ?? '';
    row.querySelector(`[name="${name}[option_value]"]`).value = prefill.option_value ?? '';
    row.querySelector(`[name="${name}[sku]"]`).value          = prefill.sku ?? '';
    row.querySelector(`[name="${name}[price]"]`).value        = prefill.price ?? '';
    row.querySelector(`[name="${name}[stock]"]`).value        = prefill.stock ?? 0;
  }
  document.querySelector('#variants-table tbody').appendChild(row);
}
function removeVariantRow(btn){
  const tr = btn.closest('tr');
  tr.parentNode.removeChild(tr);
}
addVariantRow();

const imageInput   = document.getElementById('imageInput');
const imagePreview = document.getElementById('imagePreview');
const btnClear     = document.getElementById('btnClearImage');

imageInput.addEventListener('change', function (e) {
  const file = e.target.files && e.target.files[0] ? e.target.files[0] : null;
  if (!file) {
    resetPreview();
    return;
  }
  if (!file.type.startsWith('image/')) {
    alert('File harus berupa gambar.');
    imageInput.value = '';
    resetPreview();
    return;
  }
  const url = URL.createObjectURL(file);
  imagePreview.src = url;
  imagePreview.style.display = 'block';
});

btnClear.addEventListener('click', function(){
  imageInput.value = '';
  resetPreview();
});

function resetPreview(){
  imagePreview.removeAttribute('src');
  imagePreview.style.display = 'none';
}
</script>
@endpush
@endsection
