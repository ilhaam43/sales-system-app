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
            <li>Notice</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->


    <div class="container h-page-80">

	
	<div class="form-group p-t-20 p-b-40">

      

<div class="card mb-3">
  
  <div class="card-body shadow">
    <h2 class="text-center em4"> Notices </h2> <hr class="hr-short-auto">
      <img src="https://searchclientnow.com/images/notice.png" width="250" height="250" alt="upgrade" class=" d-block m-auto"> <hr>

      <div class="form-group">
            {!! $auditorNotice->setting_description ?? "" !!}
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