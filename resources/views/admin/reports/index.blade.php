@extends('admin.layout.template')

@section('content')

        <!-- Begin Page Content -->
        <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">All Reports List</h1>
    
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
        <h6 class="m-0 font-weight-bold text-primary">All Reports List</h6>
      </div>
      <div class="card-body">
      <button type="button" class="btn btn-primary btn-sm" id="selectAll" class="main"><i class="fa fa-check-circle"></i> Select All</button>
      <button type="button" class="btn btn-info btn-sm" id="openAll" class="main"><i class="fa fa-eye"></i> Open All</button>
      <button type="button" class="btn btn-danger btn-sm" style="float: right; margin-right:10px;" id="remove" class="main" onclick="removeConfirmation()"><i class="fa fa-times"></i> Remove All</button>
      </br>
      </br>
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No</th>
                    <th>Company</th>
                    <th>User</th>
                    <th>Message</th>
                    <th>Action</th>
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
@include('admin.javascript.openAllReports')
@include('admin.javascript.reports.showAllReports')
</html>
