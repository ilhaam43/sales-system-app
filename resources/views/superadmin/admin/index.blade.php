@extends('superadmin.layout.template')

@section('content')

        <!-- Begin Page Content -->
        <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Admin List</h1>
    
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

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Admin List</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Country</th>
                <th>Category</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($admins as $admin)
              <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $admin['name'] }}</td>
                <td>{{ $admin['email'] }}</td>
                <td>{{ $admin['country']['country_name'] }}</td>
                <td>{{ $admin['product_category']['category_name'] }}</td>
                <td>{{ $admin['users_status']['status'] }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" href="{{ route('admins.show',$admin['id']) }}">Edit</a>

                    <button class="btn btn-danger btn-sm remove-user" data-id="{{ $admin['id'] }}" data-action="{{ route('admins.destroy',$admin['id']) }}" onclick="deleteConfirmation({{$admin['id']}})"> Delete</button>
                  </form>
                </td>
              </tr>
            </tbody>
            @endforeach
          </table>
        </div>
      </div>
    </div>

    </div>
    <!-- /.container-fluid -->

    </div>

    <!-- End of Main Content -->
    
@endsection
</body>
<script src="{{ asset('assets/superadmin/js/ajax/deleteAdmin.js') }}"></script>
</html>
