
@section('content')
<div class="container">
    <h3>Edit Product Size</h3>
    <form action="{{ route('product_size.update', $size->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="size">Size</label>
            <input type="text" class="form-control" name="size" id="size" value="{{ $size->size }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Size</button>
    </form>
</div>
@endsection