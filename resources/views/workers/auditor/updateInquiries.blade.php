@extends('workers.auditor.layout.templates')

@section('content')
    <main id="main" data-aos="fade-up">

        <!-- ======= Breadcrumbs ======= -->
        <section class="breadcrumbs">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
            <h3></h3>
            <ol>
                <li><a href="#">Auditor</a></li>
                <li>Inquiries Data</li>
            </ol>
            </div>

        </div>
    </section><!-- End Breadcrumbs -->

    <div class="container h-page-80">

	
	<div class="form-group p-t-20 p-b-40">

        
    <div class="card mb-3">
    <div class="card-header bg-primary text-white"><i class="fa fa-envelope"></i> Inquiries Data</div>
    <div class="card-body shadow b-b-5">
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

        <form method="POST" action="{{ route('auditor.update.inquiries',$inquiryJobsLists['id']) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
        <div class="col-md-7">
        <img src="{{asset($inquiryJobsLists['screenshot_url'])}}" style="width:100%; max-width:600; height:auto;" width="600" height="600">
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
                <a href="{{url('auditor/inquiries')}}" class="btn btn-danger">Cancel</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>

        

        </form>
            </div>

        </div>
    </div>
	</div>

</div>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  

  <div id="preloader"></div>
  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
  @endsection

</body>

</html>