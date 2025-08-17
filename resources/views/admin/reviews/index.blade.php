@extends('layouts.app')
@section('title','Reviews')

@section('content')
<div class="section-header">
  <h1>Reviews</h1>
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
          <label class="mb-1">Search (title/content)</label>
          <input id="q" type="text" class="form-control" placeholder="e.g. mantap">
        </div>
        <div class="form-group col-md-2">
          <label class="mb-1">Product (slug / ID / name)</label>
          <input id="f-product" type="text" class="form-control" placeholder="laptop-pro / 12">
        </div>
        <div class="form-group col-md-2">
          <label class="mb-1">User (ID / email / name)</label>
          <input id="f-user" type="text" class="form-control" placeholder="25 / email@x.com">
        </div>
        <div class="form-group col-md-1">
          <label class="mb-1">Rating</label>
          <select id="f-rating" class="form-control">
            <option value="">Any</option>
            @for($i=5;$i>=1;$i--)
              <option value="{{ $i }}">{{ $i }}</option>
            @endfor
          </select>
        </div>
        <div class="form-group col-md-2">
          <label class="mb-1">Date From</label>
          <input id="f-from" type="date" class="form-control">
        </div>
        <div class="form-group col-md-1">
          <label class="mb-1">Sort</label>
          <select id="f-sort" class="form-control">
            <option value="newest">Newest</option>
            <option value="oldest">Oldest</option>
            <option value="rating_desc">Rating ↓</option>
            <option value="rating_asc">Rating ↑</option>
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

  <div class="card-body p-0 table-responsive">
    <table class="table table-striped mb-0">
      <thead>
        <tr>
          <th style="width:80px">#</th>
          <th>Product</th>
          <th>User</th>
          <th style="width:120px" class="text-center">Rating</th>
          <th>Title / Content</th>
          <th style="width:180px">Created</th>
          <th style="width:120px" class="text-right">Actions</th>
        </tr>
      </thead>
      <tbody id="reviews-tbody">
        <tr><td colspan="7" class="text-center text-muted">Loading…</td></tr>
      </tbody>
    </table>
  </div>

  <div class="card-footer d-flex justify-content-between align-items-center">
    <small id="summary" class="text-muted"></small>
    <nav id="reviews-pagination"></nav>
  </div>
</div>

<div id="api-error" class="alert alert-danger d-none"></div>
@endsection

@push('scripts')
<script>
(function(){
  const API_URL = '/api/reviews';

  // elements
  const $q       = document.getElementById('q');
  const $product = document.getElementById('f-product');
  const $user    = document.getElementById('f-user');
  const $rating  = document.getElementById('f-rating');
  const $from    = document.getElementById('f-from');
  const $sort    = document.getElementById('f-sort');
  const $limit   = document.getElementById('f-limit');
  const $apply   = document.getElementById('btn-apply');
  const $reset   = document.getElementById('btn-reset');
  const $tbody   = document.getElementById('reviews-tbody');
  const $pager   = document.getElementById('reviews-pagination');
  const $summary = document.getElementById('summary');
  const $apiError= document.getElementById('api-error');

  function escapeHtml(s){
    return String(s ?? '')
      .replaceAll('&','&amp;').replaceAll('<','&lt;')
      .replaceAll('>','&gt;').replaceAll('"','&quot;')
      .replaceAll("'","&#039;");
  }
  function debounce(fn, ms=300){ let t; return (...a)=>{ clearTimeout(t); t=setTimeout(()=>fn(...a),ms); }; }

  function rowHtml(item){
    const productEditUrl = item.product ? `{{ url('product') }}/${item.product.id}/edit` : '#';
    const reviewDestroy  = `{{ url('review') }}/${item.id}`;
    const pName = item.product?.name ?? '—';
    const pSlug = item.product?.slug ?? '';
    const uName = item.user?.name ?? '—';
    const uEmail= item.user?.email ?? '';

    return `
      <tr>
        <td>${item.id}</td>
        <td>
          ${item.product
            ? `<a href="${productEditUrl}"><strong>${escapeHtml(pName)}</strong></a>`
            : `<span class="text-muted">Product deleted</span>`
          }
          ${pSlug ? `<br><small class="text-muted">${escapeHtml(pSlug)}</small>` : ''}
        </td>
        <td>
          <strong>${escapeHtml(uName)}</strong>
          ${uEmail ? `<br><small class="text-muted">${escapeHtml(uEmail)}</small>` : ''}
        </td>
        <td class="text-center"><span class="badge badge-info">${item.rating}</span></td>
        <td>
          <strong>${escapeHtml(item.title ?? '')}</strong>
          <div class="text-muted small" style="max-width:520px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
            ${escapeHtml(item.content ?? '')}
          </div>
        </td>
        <td><span>${escapeHtml(item.created_at ?? '')}</span></td>
        <td class="text-right">
          <form action="${reviewDestroy}" method="POST" onsubmit="return confirm('Delete this review?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
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
    $tbody.innerHTML = `<tr><td colspan="7" class="text-center text-muted">Loading…</td></tr>`;
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

    const prod = ($product.value || '').trim();
    if(prod) params.set('product', prod);

    const usr = ($user.value || '').trim();
    if(usr) params.set('user', usr);

    const rate = ($rating.value || '').trim();
    if(rate) params.set('rating', rate);

    const from = ($from.value || '').trim();
    if(from) params.set('from', from);

    const sort = ($sort.value || '').trim();
    if(sort) params.set('sort', sort);

    return params.toString();
  }

  async function load(page=1){
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

  const debounced = debounce(()=>load(1), 300);
  $q.addEventListener('input', debounced);
  $product.addEventListener('input', debounced);
  $user.addEventListener('input', debounced);
  $rating.addEventListener('change', ()=>load(1));
  $from.addEventListener('change',  ()=>load(1));
  $sort.addEventListener('change',  ()=>load(1));
  $limit.addEventListener('change', ()=>load(1));
  $apply.addEventListener('click',  ()=>load(1));
  $reset.addEventListener('click',  ()=>{
    $q.value=''; $product.value=''; $user.value=''; $rating.value=''; $from.value='';
    $sort.value='newest'; $limit.value='20'; load(1);
  });

  load(1);
})();
</script>
@endpush
