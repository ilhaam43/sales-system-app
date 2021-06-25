@extends('admin.layout.template')

@section('content')

        <!-- Begin Page Content -->
        <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Edit Inquiries</h1>
    
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
        <h6 class="m-0 font-weight-bold text-primary">Edit Inquiries</h6>
        </div>
        <div class="card-body">
        <form method="POST" action="{{ route('admin.inquiries.update',$inquiryJobsLists['id']) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
        <div class="col-md-7">
        <img src="{{$inquiryJobsLists['screenshot_url'] ? asset($inquiryJobsLists['screenshot_url']) : "https://via.placeholder.com/600x600?text=Image+Deleted" }}" style="width:100%; max-width:600; height:auto;" width="600" height="600">
            </div>
        <div class="col-md-5">
                <hr>
                <b><h3>Company Information :</h3></b>
                <hr>
                <p>Company Name : {{$inquiryJobsLists['research_jobs']['company_name']}}</p>
                <hr>
                <p>Company Website : {{$inquiryJobsLists['research_jobs']['company_website']}}</p>
                <hr>
                <label>Inquiries Status : </label>
                <select name="job_status_id" class="form-control">
                    @foreach($listJobsStatus as $jobsStatus)
                    <option value="{{$jobsStatus->id}}" {{ ( $jobsStatus->id == $inquiryJobsLists['job_status_id']) ? 'selected' : '' }}>{{$jobsStatus->status}}</option>
                    @endforeach
                </select>
                </br>
                <a href="{{url('admin/inquiries')}}" class="btn btn-danger">Cancel</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
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