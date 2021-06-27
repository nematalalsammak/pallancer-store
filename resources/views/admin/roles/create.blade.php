<x-dashboard-layout title="Add roles">

<form action="{{ route('admin.roles.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @include('admin.roles._form',
    [ 'button_lable'=>'Add'
    ])

</form>
</x-dashboard-layout>