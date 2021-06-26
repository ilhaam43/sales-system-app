@extends('admin.layout.template')

@section('content')

    <div class="container h-page-80">

	<div class="form-group p-t-20 p-b-40">

    <div class="card mb-3">
    <div class="card-header bg-primary text-white"><i class="fa fa-edit"></i> Edit Research Job</div>
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

        <form method="POST" action="{{ route('admin.researches.update',$researchJobsLists['id']) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
        <div class="form-group col-md-6">
                <label>Company Name :</label>
                <input type="text" class="form-control" name="company_name" placeholder="Enter your name" value="{{$researchJobsLists['company_name']}}">
            </div>
        <div class="form-group col-md-6">
                <label>Company Email :</label>
                <input type="text" class="form-control" name="company_email" value="{{$researchJobsLists['company_email']}}"> 
            </div>
        </div>

        <div class="row">
        <div class="form-group col-md-6">
                <label>Company Website :</label>
                <input type="text" class="form-control" name="company_website" placeholder="Enter your name" value="{{$researchJobsLists['company_website']}}">
            </div>
        <div class="form-group col-md-6">
                <label>Company Phone :</label>
                <input type="text" class="form-control" name="company_phone" value="{{$researchJobsLists['company_phone']}}"> 
            </div>
        </div>

        <div class="row">
        <div class="form-group col-md-6">
                <label>Company Product Page :</label>
                <input type="text" class="form-control" name="company_product_url" placeholder="Enter your name" value="{{$researchJobsLists['company_product_url']}}">
            </div>
        <div class="form-group col-md-6">
        <label>Country :</label>
                    <select type="text" class="form-control" name="country_id">
                        @foreach($listCountries as $countries) 
                            <option value="{{$countries->id}}" {{ ( $countries->id == $researchJobsLists['country']['id']) ? 'selected' : '' }}>{{$countries->country_name}}</option>
                        @endforeach
                    </select>
            </div>
        </div>

        </br>
        <a href="{{url('admin/researches')}}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
            </div>

        </div>
    </div>
	</div>

</div>

  <!-- ======= Footer ======= -->
  

  <div id="preloader"></div>
  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
  @endsection

</body>

</html>