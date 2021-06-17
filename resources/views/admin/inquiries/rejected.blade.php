@extends('admin.layout.template')

@section('content')

        <!-- Begin Page Content -->
        <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Rejected Inquiries List</h1>
    
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
        <h6 class="m-0 font-weight-bold text-primary">Rejected Inquiries List</h6>
      </div>
      <div class="card-body">
      <button type="button" class="btn btn-primary btn-sm" id="selectAll" class="main"><i class="fa fa-check-circle"></i> Select All</button>
      <button type="button" class="btn btn-info btn-sm" id="openAll" class="main"><i class="fa fa-eye"></i> Open All</button>
      <button type="button" class="btn btn-danger btn-sm" style="float: right; margin-right:10px;" id="reject" class="main" onclick="rejectConfirmation()"><i class="fa fa-times"></i> Reject</button>
      <button type="button" class="btn btn-success btn-sm" style="float: right; margin-right:10px;" id="approve" class="main" onclick="approveConfirmation()"><i class="fa fa-check"></i> Approve</button>
      </br>
      </br>
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No</th>
                    <th>Company</th>
                    <th>Screenshot</th>
                    <th>Website Link</th>
                    <th>User</th>
                    <th>Status</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inquiryJobsLists as $inquiries)
                <tr id="{{$inquiries['id']}}">
                <td><input type="checkbox" name="id_inquiries[]" id="id_inquiries" value="{{ $inquiries['id'] }}"/></td>
                <td>{{ ++$i }}</td>
                <td>{{ $inquiries['research_jobs']['company_name'] }}</td>
                <td>@if($inquiries['screenshot_url'] !== NULL)
                <a class="btn btn-success btn-sm" href="{{ asset($inquiries['screenshot_url']) }}">Screenshot</a></td>
                @else
                DELETED</td>
                @endif
                <td><a class="btn btn-info btn-sm" href="{{ '//'.$inquiries['research_jobs']['company_website'] }}">Website Link</a></td>
                <td>{{ $inquiries['user']['name'] ?? "" }}</td>
                <td>{{ $inquiries['jobs_status']['status'] }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" href="{{ route('admin.users.show',$inquiries['id']) }}">Edit</a>
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
@include('admin.javascript.openAllInquiries')
</html>