<x-dashboard-layout title="Add Category">

<form action="/admin/categories/create" method="post" enctype="multipart/form-data">
    @csrf
    @include('admin.categories._form',
    [ 'button_lable'=>'Add'
    ])

</form>
</x-dashboard-layout>