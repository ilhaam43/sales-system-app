@extends('workers.researcher.layout.templates')

@section('content')
  <main id="main" data-aos="fade-up">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h3></h3>
          <ol>
            <li><a href="index.html">Researcher</a></li>
            <li>Researches</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <div class="card shadow mb-4">
      <div class="card-body">
      <h4 style="position: absolute; left: 20;">Researches List</h4>
      <a href="#" class="btn btn-outline-danger" style="position: absolute; right: 470;"><i class="fa fa-search p-r-5"></i>
        <span class="text">Repeat Check</span>
      </a>

      <a href="#" class="btn btn-outline-info" style="position: absolute; right: 215;"><i class="fa fa-info-circle p-r-5"></i>
        <span class="text">Current Countries Records</span>
      </a>
      
      <a href="#" class="btn btn-outline-primary" style="position: absolute; right: 20;"><i class="fa fa-building p-r-5"></i>
        <span class="text">Add New Company</span>
      </a>
      </br>
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  </br>
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Name</th>
                      <th>Email</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>Ilhaam</td>
                      <td>Akmale</td>
                    </tr>
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