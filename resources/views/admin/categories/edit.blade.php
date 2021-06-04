<x-dashboard-layout title="Edit Category">

<form action="/admin/categories/{{ $id }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    
    @include('admin.categories._form',
    [ 'button_lable' =>'Update'
    ])
</form>
</x-dashboard-layout>