@extends('layouts.app')
@section('title','Products')

@section('content')
<div class="section-header">
  <h1>Products</h1>
  <div class="section-header-breadcrumb">
    <a href="{{ route('product.create') }}" class="btn btn-primary">
      <i class="fas fa-plus"></i> Add Product
    </a>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card">
  <div class="card-header">
    <div class="w-100">
      <div class="form-row align-items-end">
        <div class="form-group col-md-3">
          <label class="mb-1">Search (name/desc)</label>
          <input id="q" type="text" class="form-control" placeholder="e.g. laptop">
        </div>
        <div class="form-group col-md-2">
          <label class="mb-1">Category (slug / ID)</label>
          <input id="f-category" type="text" class="form-control" placeholder="electronics / 3">
        </div>
        <div class="form-group col-md-2">
          <label class="mb-1">Min Price</label>
          <input id="f-min" type="number" step="0.01" min="0" class="form-control" placeholder="100">
        </div>
        <div class="form-group col-md-2">
          <label class="mb-1">Max Price</label>
          <input id="f-max" type="number" step="0.01" min="0" class="form-control" placeholder="500">
        </div>
        <div class="form-group col-md-2">
          <label class="mb-1">Sort</label>
          <select id="f-sort" class="form-control">
            <option value="">Newest</option>
            <option value="name_asc">Name A-Z</option>
            <option value="name_desc">Name Z-A</option>
            <option value="price_asc">Price ↑</option>
            <option value="price_desc">Price ↓</option>
          </select>
        </div>
        <div class="form-group col-md-1">
          <label class="mb-1">Limit</label>
          <select id="f-limit" class="form-control">
            <option>10</option>
            <option selected>20</option>
            <option>50</option>
            <option>100</option>
          </select>
        </div>
      </div>
      <div class="d-flex">
        <button id="btn-apply" class="btn btn-secondary mr-2"><i class="fas fa-filter"></i> Apply</button>
        <button id="btn-reset" class="btn btn-light"><i class="fas fa-undo"></i> Reset</button>
      </div>
    </div>
  </div>

  <div class="card-body table-responsive p-0">
    <table class="table table-striped mb-0">
      <thead>
        <tr>
          <th style="width:70px">#</th>
          <th>Name</th>
          <th style="width:200px">Category</th>
          <th class="text-right" style="width:160px">Price</th>
          <th class="text-right" style="width:120px">Stock</th>
          <th class="text-center" style="width:140px">Rating</th>
          <th class="text-right" style="width:150px">Actions</th>
        </tr>
      </thead>
      <tbody id="products-tbody">
        <tr><td colspan="7" class="text-center text-muted">Loading…</td></tr>
      </tbody>
    </table>
  </div>

  <div class="card-footer d-flex justify-content-between align-items-center">
    <small id="summary" class="text-muted"></small>
    <nav id="products-pagination"></nav>
  </div>
</div>
<div id="api-error" class="alert alert-danger d-none"></div>
@endsection

@push('scripts')
<script>
(function(){
  const API_URL = '/api/products';
  const $q        = document.getElementById('q');
  const $cat      = document.getElementById('f-category');
  const $min      = document.getElementById('f-min');
  const $max      = document.getElementById('f-max');
  const $sort     = document.getElementById('f-sort');
  const $limit    = document.getElementById('f-limit');
  const $apply    = document.getElementById('btn-apply');
  const $reset    = document.getElementById('btn-reset');
  const $tbody    = document.getElementById('products-tbody');
  const $pager    = document.getElementById('products-pagination');
  const $summary  = document.getElementById('summary');
  const $apiError = document.getElementById('api-error');
  let currentPage = 1;
  function fmtRupiah(n){
    const num = Number(n ?? 0);
    return 'Rp ' + num.toLocaleString('id-ID',{minimumFractionDigits:2, maximumFractionDigits:2});
  }
  function escapeHtml(s){
    return String(s ?? '')
      .replaceAll('&','&amp;').replaceAll('<','&lt;')
      .replaceAll('>','&gt;').replaceAll('"','&quot;')
      .replaceAll("'","&#039;");
  }
  function debounce(fn, ms=300){
    let t; return (...args)=>{ clearTimeout(t); t = setTimeout(()=>fn(...args), ms); };
  }
  function thumbOrPlaceholder(item){
    const url = item.image_url || item.image || '';
    const alt = escapeHtml(item.name || 'product');
    if(url){
      return `<img src="${escapeHtml(url)}" alt="${alt}" loading="lazy" decoding="async"
                 class="rounded mr-2"
                 style="width:44px;height:44px;object-fit:cover;border:1px solid #e9ecef;background:#f8f9fa;">`;
    }
    return `<div class="rounded mr-2"
                style="width:44px;height:44px;background:#f1f3f5;border:1px dashed #dee2e6;
                       display:flex;align-items:center;justify-content:center;font-size:10px;color:#adb5bd;">
              N/A
            </div>`;
  }
  function rowHtml(item){
    const editUrl = `{{ url('product') }}/${item.id}/edit`;
    const destroyUrl = `{{ url('product') }}/${item.id}`;
    return `
      <tr>
        <td>${item.id}</td>
        <td>
          <div class="d-flex align-items-center">
            ${thumbOrPlaceholder(item)}
            <div class="text-truncate" style="max-width:420px">
              <a href="${editUrl}"><strong>${escapeHtml(item.name)}</strong></a><br>
              <small class="text-muted">${escapeHtml(item.slug)}</small>
            </div>
          </div>
        </td>
        <td>${escapeHtml(item.category?.name ?? '-')}</td>
        <td class="text-right">${fmtRupiah(item.price)}</td>
        <td class="text-right">${item.stock ?? 0}</td>
        <td class="text-center">${(item.rating?.avg ?? 0)} (${item.rating?.count ?? 0})</td>
        <td class="text-right">
          <a href="${editUrl}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
          <form action="${destroyUrl}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
          </form>
        </td>
      </tr>
    `;
  }

  function renderTable(items){
    if(!items || items.length === 0){
      $tbody.innerHTML = `<tr><td colspan="7" class="text-center text-muted">No data</td></tr>`;
      return;
    }
    $tbody.innerHTML = items.map(rowHtml).join('');
  }

  function renderPager(meta){
    if(!meta) { $pager.innerHTML = ''; return; }
    const cur = meta.current_page, last = meta.last_page;
    const disablePrev = cur <= 1 ? ' disabled' : '';
    const disableNext = cur >= last ? ' disabled' : '';
    $pager.innerHTML = `
      <ul class="pagination mb-0">
        <li class="page-item${disablePrev}">
          <a class="page-link" href="#" data-page="1">&laquo;&laquo;</a>
        </li>
        <li class="page-item${disablePrev}">
          <a class="page-link" href="#" data-page="${cur-1}">&laquo;</a>
        </li>
        <li class="page-item disabled"><span class="page-link">Page ${cur} / ${last}</span></li>
        <li class="page-item${disableNext}">
          <a class="page-link" href="#" data-page="${cur+1}">&raquo;</a>
        </li>
        <li class="page-item${disableNext}">
          <a class="page-link" href="#" data-page="${last}">&raquo;&raquo;</a>
        </li>
      </ul>
    `;
    $pager.querySelectorAll('[data-page]').forEach(a=>{
      a.addEventListener('click', e=>{
        e.preventDefault();
        const p = Number(a.dataset.page);
        if(p>=1 && p<=last){ load(p); }
      });
    });
  }

  function renderSummary(meta){
    if(!meta){ $summary.textContent=''; return; }
    $summary.textContent = `Showing page ${meta.current_page} of ${meta.last_page} — total ${meta.total} items`;
  }

  function showLoading(){
    $tbody.innerHTML = `
      <tr><td colspan="7" class="text-center text-muted">Loading…</td></tr>
    `;
  }

  function showError(msg){
    $apiError.textContent = msg || 'Failed to load data.';
    $apiError.classList.remove('d-none');
    setTimeout(()=> $apiError.classList.add('d-none'), 4000);
  }
  function buildQuery(page){
    const params = new URLSearchParams();
    params.set('page', page || 1);
    params.set('limit', $limit.value || 20);

    const term = ($q.value || '').trim();
    if(term) params.set('search', term);

    const cat = ($cat.value || '').trim();
    if(cat) params.set('category', cat);

    const min = ($min.value || '').trim();
    if(min) params.set('min_price', min);

    const max = ($max.value || '').trim();
    if(max) params.set('max_price', max);

    const sort = ($sort.value || '').trim();
    if(sort) params.set('sort', sort);

    return params.toString();
  }

  async function load(page=1){
    currentPage = page;
    showLoading();
    try{
      const res = await fetch(`${API_URL}?${buildQuery(page)}`, { headers: { 'Accept':'application/json' }});
      if(!res.ok) throw new Error(`HTTP ${res.status}`);
      const json = await res.json();
      renderTable(json.data || []);
      renderPager(json.meta);
      renderSummary(json.meta);
    }catch(err){
      console.error(err);
      showError(err.message);
    }
  }

  const debouncedSearch = debounce(()=>load(1), 300);
  $q.addEventListener('input', debouncedSearch);
  $limit.addEventListener('change', ()=>load(1));
  $sort.addEventListener('change', ()=>load(1));
  $apply.addEventListener('click', ()=>load(1));
  $reset.addEventListener('click', ()=>{
    $q.value = ''; $cat.value = ''; $min.value = ''; $max.value = ''; $sort.value = ''; $limit.value = '20';
    load(1);
  });

  load(1);
})();
</script>
@endpush
