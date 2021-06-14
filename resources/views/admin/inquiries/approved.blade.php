@extends('admin.layout.template')

@section('content')

        <!-- Begin Page Content -->
        <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Approved Companies List</h1>
    
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
        <h6 class="m-0 font-weight-bold text-primary">Approved Companies List</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
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
                <td>{{ ++$i }}</td>
                <td>{{ $researches['company_name'] }}</td>
                <td>{{ $researches['company_website'] }}</td>
                <td>{{ $researches['company_email'] }}</td>
                <td>{{ $researches['company_phone'] }}</td>
                <td>{{ $researches['company_product_url'] }}</td>
                <td>{{ $researches['country']['country_name'] }}</td>
                <td>{{ $researches['jobs_status']['status'] }}</td>
                <td>{{ $researches['user']['name'] }}</td>
                <td>{{ $researches['auditor_research_jobs']['user']['name'] ?? "No" }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" href="{{ route('admin.users.show',$researches['id']) }}">Edit</a>
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
</html>
