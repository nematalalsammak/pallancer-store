<x-dashboard-layout title="Trashed Categories">
<x-alert type="success">
</x-alert>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Parent Name</th>
            <th>Deleted At</th>
            <th>Status</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categories as $category)
        <tr>
            <td>{{ $category->id }} </td>
            <td><a href="{{ route('admin.categories.edit', $category->id) }}">{{ $category->name }}</a></td>
            <td>{{ $category->parent->name }}</td>
            <td>{{ $category->deleted_at }}</td>
            <td>{{ $category->status }}</td>
            <td>
                <form action="{{ route('admin.categories.restore', $category->id) }}" method="POST">
                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-sm btn-primary">Restor</button>
                </form>
            </td>
            <td>
                <form action="{{ route('admin.categories.force-delete', $category->id) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</x-dashboard-layout>