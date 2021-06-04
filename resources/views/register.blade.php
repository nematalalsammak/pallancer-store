<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h3 class="mt-4 mb-4">Registeration page</h3>
        @if(session('success'))
        <div class="col-md-8 alert alert-success">
        {{session('success')}}
        </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger">
            Errors!
            <ul>
                @foreach($errors->all() as $message)
                <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="/register" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="form-group mb-4">
                <label for="">Name:</label>
                <input type="text" name="name" value="{{ old('name',$register->name) }}" class="form-control @error('name') is-invalid @enderror">
                @error('name')
                <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mb-4">
                <label for="">Email:</label>
                <input type="email" name="email" value="{{ old('email',$register->email) }}" class="form-control @error('email') is-invalid @enderror" placeholder="example@gmail.com">
                @error('email')
                <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mb-4">
                <label for="">Password:</label>
                <input type="password" name="password" value="" class="form-control">
                @error('password')
                <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mb-4">
                <label for="">Gender:</label>
                <div>
                    <label><input type="radio" name="gender" value="male" class="form-check-input @error('status') is-invalid @enderror" @if(old('gender',$register->gender) == 'active') checked @endif>
                        Male:</label>
                    <label><input type="radio" name="gender" value="female" class="form-check-input @error('status') is-invalid @enderror" @if(old('gender',$register->gender) == 'active') checked @endif>
                        Female:</label>
                </div>
                @error('gender')
                <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mb-4">
                <label for="">Birthday:</label>
                <input type="date" name="birthday" value="{{ old('birthday',$register->birthday) }}" class="form-control @error('birthday') is-invalid @enderror">
                @error('birthday')
                <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mb-4">
                <label for="">Phone:</label>
                <input type="tel" name="phone" value="{{ old('phone',$register->phone) }}" class="form-control @error('phone') is-invalid @enderror">
                @error('phone')
                <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mb-4">
                <button type="submit" class="btn btn-primary">Sign Up</button>
            </div>
        </form>
    </div>
</body>

</html>