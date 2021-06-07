<x-dashboard-layout title="Add Products">

<form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @include('admin.products._form',
    [ 'button_lable'=>'Add'
    ])

</form>
</x-dashboard-layout>