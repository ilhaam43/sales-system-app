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
    <div class="card-header bg-primary text-white"><i class="fa fa-building"></i> Researches Data</div>
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

        <form method="POST" action="{{ route('auditor.update.researches',$researchJobsLists['id']) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
        <div class="col-md-6">
                <b><h3>Company Information :</h3></b>
        </div>
        </div>
        </br>
        <div class="row">
        <div class="form-group col-md-6">
                <label>Company Name :</label>
                <input type="text" class="form-control" value="{{$researchJobsLists['company_name']}}" disabled>
        </div>
        <div class="form-group col-md-6">
                <label>Company Website :</label>
                <input type="text" class="form-control" value="{{$researchJobsLists['company_website']}}" disabled>
        </div>
        </div>
        <div class="row">
        <div class="form-group col-md-6">
                <label>Company Email :</label>
                <input type="text" class="form-control" value="{{$researchJobsLists['company_email']}}" disabled>
        </div>
        <div class="form-group col-md-6">
                <label>Company Product Page :</label>
                <input type="text" class="form-control" value="{{$researchJobsLists['company_product_url']}}" disabled>
        </div>
        </div>
        <div class="row">
        <div class="form-group col-md-6">
                <label>Company Phone :</label>
                <input type="text" class="form-control" value="{{$researchJobsLists['company_phone']}}" disabled>
        </div>
        <div class="form-group col-md-6">
                <label>Product Category :</label>
                <input type="text" class="form-control" value="{{$researchJobsLists['product_category']['category_name']}}" disabled>
        </div>
        </div>
        <div class="row">
        <div class="form-group col-md-6">
                <label>Form Available :</label>
                <select name="is_form" class="form-control">
                    <option value="Yes" {{ ( 'Yes' == $researchJobsLists['is_form']) ? 'selected' : '' }}>Yes</option>
                    <option value="Yes" {{ ( 'No' == $researchJobsLists['is_form']) ? 'selected' : '' }}>No</option>
                </select>
        </div>
        <div class="form-group col-md-6">
        <label>Research Status : </label>
                <select name="job_status_id" class="form-control">
                    @foreach($listJobsStatus as $jobsStatus)
                    <option value="{{$jobsStatus->id}}" {{ ( $jobsStatus->id == $researchJobsLists['job_status_id']) ? 'selected' : '' }}>{{$jobsStatus->status}}</option>
                    @endforeach
                </select>
        </div>
        </div>
                </br>
                <a href="{{url('auditor/researches')}}" class="btn btn-danger">Cancel</a>
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