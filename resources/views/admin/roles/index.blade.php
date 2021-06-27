<x-dashboard-layout title="Roles List">

<div class="table-toolbar mb-3">
<a href="{{ route('admin.roles.create') }}"class="btn btn-info">create</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Abilities</th>
            <th>Created At</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($roles as $role)
        <tr>
            <td>{{ $role->id }} </td>
            <td><a href="{{ route('admin.roles.edit', $role->id) }}">{{ $role->name }}</a></td>
            <td>{{ count($role->abilities) }}</td>
            <td>{{ $role->created_at }}</td>
            <td>
                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form> 
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$roles->links()}}
</x-dashboard-layout>