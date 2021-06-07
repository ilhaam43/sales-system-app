@extends('superadmin.layout.template')

@section('content')

        <!-- Begin Page Content -->
        <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Add Workers User</h1>
    
    </br>
    @if (session('error'))
        <div class="alert alert-danger">
            <ul>
                <li>{{ session('error') }}</li>
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            <ul>
                <li>{{ session('success') }}</li>
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Add Workers User</h6>
        </div>
        <div class="card-body">
        <form method="POST" action="{{ route('workers.store') }}">
            @csrf
            <input type="hidden" name="role_id" value="2">
            <input type="hidden" name="status_id" value="1">
            <div class="form-row">
                <div class="col-sm-6">
                <label for="name"><b>Name :</label></b>
                <input type="text" class="form-control" placeholder="Name" name="name" required>
                </div>
                <div class="col-sm-6">
                <label for="email"><b>Email :</label></b>
                <input type="text" class="form-control" placeholder="Email" name="email" required>
                </div>
            </div>
            </br>
            <div class="form-row">
                <div class="col-sm-6">
                <label for="password"><b>Pasword :</label></b>
                <input type="password" class="form-control" placeholder="Password" name="password" required>
                </div>
                <div class="col-sm-6">
                <label for="confirm_password"><b>Confirm Password :</label></b>
                <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" required>
                </div>
            </div>
            </br>
            <div class="form-row">
            <div class="col-sm-4">
                <label for="country"><b>Country :</label></b>
                <select class="form-control" name="country">
                    @foreach($listCountries as $countries)
                    <option value="{{$countries}}">{{$countries}}</option>
                    @endforeach
                </select>
                </div>
            <div class="col-sm-4">
                <label for="name"><b>Product Category :</label></b>
                <select class="form-control" name="product_category_id">
                    @foreach($productCategory as $categories)
                    <option value="{{$categories->id}}">{{$categories->category_name}}</option>
                    @endforeach
                </select>
                </div>
            <div class="col-sm-4">
                <label for="name"><b>Workers Role :</label></b>
                <select class="form-control" name="role_id">
                    @foreach($usersRole as $roles)
                    <option value="{{$roles->id}}">{{$roles->role}}</option>
                    @endforeach
                </select>
                </div>
            </div>
            </br>
            <a href="{{url('superadmin/admin')}}" class="btn btn-danger">Cancel</a>
            <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    </div>
    <!-- /.container-fluid -->

    </div>

  
    <!-- End of Main Content -->
    
@endsection
</body>

</html>
