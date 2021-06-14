@extends('workers.researcher.layout.templates')

@section('content')
  <main id="main" data-aos="fade-up">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
        <div class="d-flex justify-content-between align-items-center">
          <h3></h3>
          <ol>
            <li style="margin-left:20px;"><a href="#">Researcher</a></li>
            <li style="margin-right:20px;">Researches</li>
          </ol>
        </div>
    </section><!-- End Breadcrumbs -->

    <div class="card shadow mb-4">
      <div class="card-body">
      <h4 style="margin-left:10px;">Researches List</h4>

      <a href="#" class="btn btn-outline-primary btn-icon-split" data-toggle="modal" data-target="#addCompanyModal" style="float: left; margin-left:10px;"><i class="fa fa-building p-r-5"></i>
        <span class="text">Add New Company</span>
        
      <a href="#" class="btn btn-outline-danger btn-icon-split" data-toggle="modal" data-target="#checkCompanyModal" style="float: left; margin-left:10px;"><i class="fa fa-search p-r-5"></i>
        <span class="text">Repeat Check</span>
      </a>

      <a href="{{ url('researcher/country-records') }}" class="btn btn-outline-info btn-icon-split" style="float: left; margin-left: 10px;"><i class="fa fa-info-circle p-r-5"></i>
        <span class="text">Current Countries Records</span>
      </a>
    
      </br>
      </br>
      </br>
      </br>

      @if (session('error'))
      </br>
        <div class="alert alert-danger">
            <ul>
                <li>{{ session('error') }}</li>
            </ul>
        </div>
    @endif
    @if (session('success'))
      </br>
        <div class="alert alert-success">
            <ul>
                <li>{{ session('success') }}</li>
            </ul>
        </div>
    @endif
    <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  </br>
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>Company Name</th>
                      <th>Website</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Product Page</th>
                      <th>Country</th>
                      <th>Status</th>
                      <th>Edit</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      @foreach($researchJobsLists as $researchLists)
                      <td>{{ ++$i }}</td>
                      <td>{{ $researchLists['company_name'] }}</td>
                      <td>{{ $researchLists['company_website'] }}</td>
                      <td>{{ $researchLists['company_email'] }}</td>
                      <td>{{ $researchLists['company_phone'] }}</td>
                      <td>{{ $researchLists['company_product_url'] }}</td>
                      <td>{{ $researchLists['country']['country_name'] }}</td>
                      <td>{{ $researchLists['jobs_status']['status']}}</td>
                      <td><a class="btn btn-primary btn-sm" href="{{ route('researcher.detail.researches',$researchLists['id']) }}">Edit</a></td>
                    </tr>
                  </tbody>
                  @endforeach
                </table>
              </div>
            </div>
        </div>
    </div>  
</div>
  
  </main><!-- End #main -->

  <!-- Add Company Modal-->
  <div class="modal fade" id="addCompanyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add New Company</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
        <form method="POST" action="{{url('researcher/add-company')}}">
        {{ csrf_field() }}
        <input type="hidden" name="user_id" value="{{$user->id}}">
        <input type="hidden" name="job_status_id" value="3">
        <input type="hidden" name="is_blacklist" value="No">
        <div class="form-group">
          <label for="name">Company Name :</label>
          <input type="text" name="company_name" class="form-control" id="company_name" required>
        </div>
        <div class="form-group">
          <label for="name">Company Website :</label>
          <input type="text" name="company_website" class="form-control" id="company_website" required>
        </div>
        <div class="form-group">
          <label for="name">Company Email :</label>
          <input type="text" name="company_email" class="form-control" id="company_email" required>
        </div>
        <div class="form-group">
          <label for="name">Company Phone :</label>
          <input type="text" name="company_phone" class="form-control" id="company_phone" required>
        </div>
        <div class="form-group">
          <label for="name">Company Product Page :</label>
          <input type="text" name="company_product_url" class="form-control" id="company_product_url" required>
        </div>
        <div class="form-group">
        <label>Country :</label>
                <select type="text" class="form-control" name="country_id">
                @foreach($listCountries as $countries)
                    <option value="{{$countries->id}}">{{$countries->country_name}}</option>
                @endforeach
        </select>
        </div>
        <div class="form-group">
        <label>Form :</label>
                <select type="text" class="form-control" name="is_form">
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
        </select>
        </div>
        <div class="form-group">
        <label>Select Category :</label>
                <select type="text" class="form-control" name="product_category_id">
                @foreach($productCategories as $category)
                    <option value="{{$category['product_category']['id']}}">{{$category['product_category']['category_name']}}</option>
                @endforeach
        </select>
        </div>

        </div>
        <div class="modal-footer">
          <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Check Company Modal-->
  <div class="modal fade" id="checkCompanyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Repeat Check Company Data</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
        <form method="POST" action="{{url('researcher/check-company')}}">
        {{ csrf_field() }}
        <div class="form-group">
          <label for="name">Check data :</label>
          <input type="text" name="input_data" class="form-control" id="input_data" required>
        </div>
        <div class="form-group">
          <label>Type search :</label>
                  <select type="text" class="form-control" name="type_search">
                      <option value="name">Company Name</option>
                      <option value="website">Company Website</option>
                      <option value="email">Company Email</option>
                      <option value="phone">Company Phone</option>
                      <option value="product_url">Company Product Url</option>
                  </select>
        </div>

        </div>
        <div class="modal-footer">
          <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Submit</button>
          </form>
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