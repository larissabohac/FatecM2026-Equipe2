@extends('admin.layout')

@section('title','Admin - Editar Produto')

@section('content')

<div class="container-fluid">

<h2 class="mb-4">Editar Produto</h2>

<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="card shadow-sm mb-4">

<div class="card-header bg-dark text-white">
Dados do Produto
</div>

<div class="card-body">

<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label fw-bold">Nome</label>
<input type="text"
       name="name"
       class="form-control"
       value="{{ old('name',$product->name) }}"
       required>
</div>

<div class="col-md-6 mb-3">
<label class="form-label fw-bold">Categoria</label>

<select name="category_id" class="form-select">

@foreach($categories as $category)

<option value="{{ $category->id }}"
{{ old('category_id',$product->category_id)==$category->id ? 'selected':'' }}>

{{ $category->name }}

</option>

@endforeach

</select>

</div>

<div class="col-md-6 mb-3">
<label class="form-label fw-bold">Slug</label>
<input type="text"
       name="slug"
       class="form-control"
       value="{{ old('slug',$product->slug) }}">
</div>

<div class="col-md-6 mb-3">
<label class="form-label fw-bold">Preço</label>
<input type="text"
       name="price"
       class="form-control"
       value="{{ old('price',$product->price) }}"
       required>
</div>

<div class="col-md-6 mb-3">
<label class="form-label fw-bold">Estoque</label>
<input type="number"
       name="stock"
       class="form-control"
       value="{{ old('stock',$product->stock) }}"
       required>
</div>

<div class="col-md-6 mb-3">
<label class="form-label fw-bold">Imagem atual</label><br>

@if($product->image)

<img src="{{ asset('storage/'.$product->image) }}"
     style="width:160px;height:120px;object-fit:cover;border-radius:8px">

@endif

</div>

<div class="col-md-6 mb-3">
<label class="form-label fw-bold">Trocar imagem</label>
<input type="file"
       name="image"
       class="form-control">
</div>

<div class="col-md-12 mb-3">
<label class="form-label fw-bold">Descrição</label>
<textarea name="description"
          class="form-control"
          rows="4">{{ old('description',$product->description) }}</textarea>
</div>

<div class="col-md-12 mb-3">

<div class="form-check">

<input type="checkbox"
       name="featured"
       value="1"
       class="form-check-input"
       {{ $product->featured ? 'checked':'' }}>

<label class="form-check-label">
Produto em destaque
</label>

</div>

</div>

</div>

</div>

<div class="card-footer text-end">

<button class="btn btn-success btn-lg">
✔ Salvar Alterações
</button>

</div>

</div>

</form>

</div>

@endsection