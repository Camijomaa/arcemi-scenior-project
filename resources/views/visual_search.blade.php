@extends('frontend.layouts.master')

@section('title', 'Visual Product Search')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Search Products by Image</h2>

    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('visual.search') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="image" class="form-label">Upload or Capture Image</label>
            <input type="file" name="image" class="form-control" accept="image/*" capture="environment" required>
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    @isset($products)
        <hr>
        <h4>AI Suggested Products:</h4>
        <div class="row">
            @forelse ($products as $product)
                <div class="col-md-3">
                    <div class="card mt-3">
                        <img src="{{ asset('storage/product_images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-success">${{ number_format($product->price, 2) }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-muted">No matching products found.</p>
                </div>
            @endforelse
        </div>
    @endisset
</div>
@endsection
