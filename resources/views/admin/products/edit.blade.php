@extends('layouts.app')

@section('content')
<h1>Edit Produk Barang</h1>
<form action="{{ route('admin.products.update', $product) }}" method="POST">
    @method('PUT')
    @include('admin.products.form')
</form>
@endsection
