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
                      <th>Sources</th>
                      <th>Status</th>
                      <th>Edit</th>
                    </tr>
                  </thead>
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
            <span aria-hidden="true">??</span>
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
          <input type="text" name="company_name" class="form-control" id="company_name" required onblur="checkName()">
        </div>
        <div class="form-group">
          <label for="name">Company Website :</label>
          <input type="text" name="company_website" class="form-control" id="company_website" required onblur="checkWebsite()">
        </div>
        <div class="form-group">
          <label for="name">Company Email :</label>
          <input type="text" name="company_email" class="form-control" id="company_email" required onblur="checkEmail()">
          <small id="email-notes" class="form-text text-muted"> Notes : if company email not available just fill "no" in the company email form.</small>
        </div>
        <div class="form-group">
          <label for="name">Company Phone :</label>
          <input type="text" name="company_phone" class="form-control" id="company_phone" required onblur="checkPhone()">
        </div>
        <div class="form-group">
          <label for="name">Company Product Page :</label>
          <input type="text" name="company_product_url" class="form-control" id="company_product_url" required onblur="checkProduct()">
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

        <div class="form-group">
        <label>Select Source :</label>
                <select type="text" class="form-control" name="product_sources_id">
                @foreach($productSources as $sources)
                    <option value="{{$sources['id']}}">{{$sources['sources']}}</option>
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
            <span aria-hidden="true">??</span>
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
@include('workers.javascript.showResearcherData')
<script>
function checkName(){
    let companyName = document.getElementById("company_name");
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    companyName = companyName.value;
    
    $.ajax({
                type: 'POST',
                url: "/researcher/data/validation/company-name",
                cache: false,
                data: {_token: CSRF_TOKEN, company_name:companyName},
                dataType: 'JSON',
                success: function (results) {
                  
                    if (results.success == true && results.empty == false) {
                        $('#company_name').css('border', '3px solid #16e445');
                        $('#company_name').nextAll().remove();
                    } else if(results.success == false && results.empty == false) {
                        $('#company_name').css({"border":"3px solid red"});
                        $('#company_name').nextAll().remove();
                        $('#company_name').after("<p style=color:red;>This company already exists, please re-enter another company</p>");
                    } else if(results.success == false && results.empty == true){
                        $('#company_name').css({"border":""});
                        $('#company_name').nextAll().remove();
                    }
                }
      });
}

function checkWebsite(){
    let companyWebsite = document.getElementById("company_website");
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    companyWebsite = companyWebsite.value;
    
    $.ajax({
                type: 'POST',
                url: "/researcher/data/validation/company-website",
                cache: false,
                data: {_token: CSRF_TOKEN, company_website:companyWebsite},
                dataType: 'JSON',
                success: function (results) {
                  console.log(results.success);
                    if (results.success == true && results.empty == false) {
                        $('#company_website').css('border', '3px solid #16e445');
                        $('#company_website').nextAll().remove();
                    } else if(results.success == false && results.empty == false) {
                      console.log('error');
                        $('#company_website').css({"border":"3px solid red"});
                        $('#company_website').nextAll().remove();
                        $('#company_website').after("<p style=color:red;>This company already exists, please re-enter another company</p>");
                    } else if(results.success == false && results.empty == true){
                        $('#company_website').css({"border":""});
                        $('#company_website').nextAll().remove();
                    }
                }
      });
}

function checkEmail(){
    let companyEmail = document.getElementById("company_email");
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    companyEmail = companyEmail.value;
    
    $.ajax({
                type: 'POST',
                url: "/researcher/data/validation/company-email",
                cache: false,
                data: {_token: CSRF_TOKEN, company_email:companyEmail},
                dataType: 'JSON',
                success: function (results) {
                  console.log(results.success);
                    if (results.success == true && results.empty == false) {
                        $('#company_email').css('border', '3px solid #16e445');
                        $('#company_email').nextAll().remove();
                    } else if(results.success == false && results.empty == false) {
                      console.log('error');
                        $('#company_email').css({"border":"3px solid red"});
                        $('#company_email').nextAll().remove();
                        $('#company_email').after("<p style=color:red;>This company already exists, please re-enter another company</p>");
                    } else if(results.success == false && results.empty == true){
                        $('#company_email').css({"border":""});
                        $('#company_email').nextAll().remove();
                    }
                }
      });
}

function checkPhone(){
    let companyPhone = document.getElementById("company_phone");
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    companyPhone = companyPhone.value;
    
    $.ajax({
                type: 'POST',
                url: "/researcher/data/validation/company-phone",
                cache: false,
                data: {_token: CSRF_TOKEN, company_phone:companyPhone},
                dataType: 'JSON',
                success: function (results) {
                  console.log(results.success);
                    if (results.success == true && results.empty == false) {
                        $('#company_phone').css('border', '3px solid #16e445');
                        $('#company_phone').nextAll().remove();
                    } else if(results.success == false && results.empty == false) {
                      console.log('error');
                        $('#company_phone').css({"border":"3px solid red"});
                        $('#company_phone').nextAll().remove();
                        $('#company_phone').after("<p style=color:red;>This company already exists, please re-enter another company</p>");
                    } else if(results.success == false && results.empty == true){
                        $('#company_phone').css({"border":""});
                        $('#company_phone').nextAll().remove();
                    }
                }
      });
}

function checkProduct(){
    let companyProduct = document.getElementById("company_product_url");
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    companyProduct = companyProduct.value;
    
    $.ajax({
                type: 'POST',
                url: "/researcher/data/validation/company-product",
                cache: false,
                data: {_token: CSRF_TOKEN, company_product_url:companyProduct},
                dataType: 'JSON',
                success: function (results) {
                  console.log(results.success);
                    if (results.success == true && results.empty == false) {
                        $('#company_product_url').css('border', '3px solid #16e445');
                        $('#company_product_url').nextAll().remove();
                    } else if(results.success == false && results.empty == false) {
                      console.log('error');
                        $('#company_product_url').css({"border":"3px solid red"});
                        $('#company_product_url').nextAll().remove();
                        $('#company_product_url').after("<p style=color:red;>This company already exists, please re-enter another company</p>");
                    } else if(results.success == false && results.empty == true){
                        $('#company_product_url').css({"border":""});
                        $('#company_product_url').nextAll().remove();
                    }
                }
      });
}
</script>
</html>