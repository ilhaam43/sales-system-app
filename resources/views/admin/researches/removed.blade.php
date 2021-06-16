@extends('admin.layout.template')

@section('content')

        <!-- Begin Page Content -->
        <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Removed Companies List</h1>
    
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
        <h6 class="m-0 font-weight-bold text-primary">Removed Companies List</h6>
      </div>
      <div class="card-body">
      <button type="button" class="btn btn-primary btn-sm" id="selectAll" class="main"><i class="fa fa-check-circle"></i> Select All</button>
      <button type="button" class="btn btn-info btn-sm" id="openAll" class="main"><i class="fa fa-eye"></i> Open Website</button>
      <button type="button" class="btn btn-danger btn-sm" style="float: right; margin-right:10px;" id="reject" class="main" onclick="rejectConfirmation()"><i class="fa fa-times"></i> Reject</button>
      <button type="button" class="btn btn-success btn-sm" style="float: right; margin-right:10px;" id="approve" class="main" onclick="approveConfirmation()"><i class="fa fa-check"></i> Approve</button>
      </br>
      </br>
        <div class="table-responsive">
          <table class="table table-bordered display" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No</th>
                    <th>Name</th>
                    <th>Website</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Product Page</th>
                    <th>Country</th>
                    <th>Status</th>
                    <th>Researches</th>
                    <th>Auditor</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($researchesList as $researches)
                <tr>
                <td><input type="checkbox" name="id_researcher[]" id="id_researcher" value="{{ $researches['id'] }}"/></td>
                <td>{{ ++$i }}</td>
                <td>{{ $researches['company_name'] }}</td>
                <td><a class="btn btn-primary btn-sm" href="{{ '//'.$researches['company_website'] }}">Website</a></td>
                <td>{{ $researches['company_email'] }}</td>
                <td>{{ $researches['company_phone'] }}</td>
                <td><a class="btn btn-info btn-sm" href="{{ '//'.$researches['company_product_url'] }}">Product</a></td>
                <td>{{ $researches['country']['country_name'] }}</td>
                <td>{{ $researches['jobs_status']['status'] }}</td>
                <td><a href="{{ '/admin/users/'.$researches['user']['id'] }}">{{ $researches['user']['name'] ?? "" }}</a></td>
                <td>{{ $researches['auditor_research_jobs']['user']['name'] ?? "No" }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" href="{{ route('admin.users.show',$researches['id']) }}">Edit</a>
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
@include('admin.javascript.openAllResearches')
</html>
