<x-dashboard-layout title="Products List">
<x-alert/>

@can('create', App\Models\Product::class)
<div class="table-toolbar mb-3">
<a href="{{ route('admin.products.create') }}"class="btn btn-info">create</a>
</div>
@endcan
<form action="{{ URL::current() }}" method="get" class="d-flex mb-4">

    <input type="text" name="name" class="form-control me-2" placeholder="Search by name">
    <select name="parent_id" class="form-control me-2">
        <option value="">All categories</option>
        @foreach ($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach

    </select>
    <button type="submit" class="btn btn-secondary">Search</button>
</form>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>category</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Created At</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
        <tr>
            <td>{{ $product->id }} </td>
            <td><a href="{{ route('admin.products.edit', $product->id) }}">{{ $product->name }}</a></td>
            <td>{{ $product->category->name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->quantity }}</td>
            <td>{{ $product->status }}</td>
            <td>{{ $product->created_at }}</td>
            <td>
            {{-- @if(Auth::user()->can('delete',$product)) --}}
            @can('delete',$product)
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            @endcan    
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$products->links()}}
</x-dashboard-layout>