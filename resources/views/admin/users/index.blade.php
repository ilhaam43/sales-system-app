@extends('admin.layout.template')

@section('content')

        <!-- Begin Page Content -->
        <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Users List</h1>
    
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
        <h6 class="m-0 font-weight-bold text-primary">Users List</h6>
      </div>
      <div class="card-body">
      <button type="button" class="btn btn-danger btn-sm" style="float: right; margin-right:10px;" id="reject" class="main" onclick="blockConfirmation()"><i class="fa fa-times"></i> Block Users</button>
      </br></br>
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>#</th>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Country</th>
                <th>Category</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            
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
<script src="{{ asset('assets/admin/js/ajax/deleteUsers.js') }}"></script>
<script src="{{ asset('assets/admin/js/ajax/blockUsers.js') }}"></script>
@include('admin.javascript.users.showAllUsers')
</html>
