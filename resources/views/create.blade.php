
@section('content')
<div class="container">
    <h3>Add New Product Size</h3>
    <form action="{{ route('product_size.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="size">Size</label>
            <input type="text" class="form-control" name="size" id="size" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Size</button>
    </form>
</div>
@endsection