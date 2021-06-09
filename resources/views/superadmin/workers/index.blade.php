@extends('superadmin.layout.template')

@section('content')

        <!-- Begin Page Content -->
        <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{ucwords($workers)}} List</h1>
    
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
        <h6 class="m-0 font-weight-bold text-primary">{{ucwords($workers)}} List</h6>
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
              @foreach ($workersLists as $worker)
              <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $worker['name'] }}</td>
                <td>{{ $worker['email'] }}</td>
                <td>{{ $worker['country'] }}</td>
                <td>{{ $worker['product_category']['category_name'] ?? "" }}</td>
                <td>{{ $worker['users_status']['status'] }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" href="{{ route('workers.show',['workers' => $workers, 'id' => $worker['id']]) }}">Edit</a>

                    <button class="btn btn-danger btn-sm remove-user" data-id="{{$worker['id']}}" data-action="{{ route('workers.destroy',['workers' => $workers, 'id' => $worker['id']]) }}" onclick="deleteConfirmation({{$worker['id']}}, '{{$workers}}')">Delete</button>
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
<script src="{{ asset('assets/superadmin/js/ajax/deleteWorkers.js') }}"></script>
</html>
