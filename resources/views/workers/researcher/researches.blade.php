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

      <a href="#" class="btn btn-outline-primary btn-icon-split" style="float: left; margin-left:10px;"><i class="fa fa-building p-r-5"></i>
        <span class="text">Add New Company</span>
        
      <a href="#" class="btn btn-outline-danger btn-icon-split" style="float: left; margin-left:10px;"><i class="fa fa-search p-r-5"></i>
        <span class="text">Repeat Check</span>
      </a>

      <a href="{{ url('researcher/country-records') }}" class="btn btn-outline-info btn-icon-split" style="float: left; margin-left: 10px;"><i class="fa fa-info-circle p-r-5"></i>
        <span class="text">Current Countries Records</span>
      </a>
    
      </br>
      </br>
      </br>
      </br>

              <table class="table table-responsive table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                      <td><a class="btn btn-primary btn-sm" href="{{ route('users.show',$researchLists['id']) }}">Edit</a></td>
                    </tr>
                  </tbody>
                  @endforeach
                </table>
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