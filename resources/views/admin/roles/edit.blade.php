<x-dashboard-layout title="Edit role">

<form action="{{ route('admin.roles.update',$role->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    
    @include('admin.roles._form',
    [ 'button_lable' =>'Update'
    ])
</form>
</x-dashboard-layout>