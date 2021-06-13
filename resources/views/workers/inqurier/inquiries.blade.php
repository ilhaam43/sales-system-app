@extends('workers.inqurier.layout.templates')

@section('content')
  <main id="main" data-aos="fade-up">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
        <div class="d-flex justify-content-between align-items-center">
          <h3></h3>
          <ol>
            <li style="margin-left:20px;"><a href="#">Inqurier</a></li>
            <li style="margin-right:20px;">Inquiries</li>
          </ol>
        </div>
    </section><!-- End Breadcrumbs -->

    <div class="card shadow mb-4">
      <div class="card-body">
      <h4 style="margin-left:10px;">My Inquiries List</h4>

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

              <table class="table table-responsive table-bordered" id="dataTable" width="100%" cellspacing="0">
                  </br>
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>Company</th>
                      <th>Country</th>
                      <th>Website</th>
                      <th>Inquiry Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($inquiriesJobs as $inquiries)
                    <tr>
                      <td>{{++$i}}</td>
                      <td>{{$inquiries['research_jobs']['company_name']}}</td>
                      <td>{{$inquiries['research_jobs']['country']['country_name']}}</td>
                      <td>{{$inquiries['research_jobs']['company_website']}}</td>
                      <td>{{$inquiries['jobs_status']['status']}}</td>
                    </tr>
                    @endforeach
                  </tbody>
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