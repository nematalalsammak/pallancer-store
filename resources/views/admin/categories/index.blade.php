<x-dashboard-layout title="Categories List">

<x-alert title="Title" type="success">
<x-slot name="actions">
<a href="#" class="btn btn-danger">Action Button</a>
</x-slot>
    My Message body
</x-alert>

<form action="/admin/categories" method="get" class="d-flex mb-4">

    <input type="text" name="name" class="form-control me-2" placeholder="Search by name">
    <select name="parent_id" class="form-control me-2">
        <option value="">All Categories</option>
        @foreach ($parents as $parent)
        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
        @endforeach

    </select>
    <button type="submit" class="btn btn-secondary">Search</button>
</form>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Parent Name</th>
            <th>Status</th>
            <th>Description</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categories as $category)
        <tr>
            <td>{{ $category->id }} </td>
            <td><a href="/admin/categories/{{ $category->id }}/edit">{{ $category->name }}</a></td>
            <td>{{ $category->parent->name }}</td>
            <td>{{ $category->status }}</td>
            <td>{{ $category->description }}</td>
            <td>
                <form action="/admin/categories/{{ $category->id }}" method="POST">
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