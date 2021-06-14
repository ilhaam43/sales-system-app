@extends('workers.auditor.layout.templates')

@section('content')
  <main id="main" data-aos="fade-up">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
        <div class="d-flex justify-content-between align-items-center">
          <h3></h3>
          <ol>
            <li style="margin-left:20px;"><a href="#">Auditor</a></li>
            <li style="margin-right:20px;">Researches</li>
          </ol>
        </div>
    </section><!-- End Breadcrumbs -->

    <div class="card shadow mb-4">
      <div class="card-body">
      <h4 style="margin-left:10px;">Researches List</h4>
      
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
                      <th>Product Page</th>
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
                      <td>{{ $researchLists['company_product_url'] }}</td>
                      <td>{{ $researchLists['jobs_status']['status']}}</td>
                      <td><a class="btn btn-primary btn-sm" href="{{ route('auditor.detail.researches',$researchLists['id']) }}">Edit</a></td>
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

  <!-- ======= Footer ======= -->
  

  <div id="preloader"></div>
  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
  @endsection

  
</body>


</html>