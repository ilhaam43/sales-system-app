@extends('workers.researcher.layout.templates')

@section('content')
  <main id="main" data-aos="fade-up">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h3></h3>
          <ol>
            <li><a href="#">Researcher</a></li>
            <li>My Work</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <div class="container h-page-80">

	
<div class="form-group p-t-20 p-b-40">

    
<div class="card shadow  mb-3" >
<div class="card-header bg-primary text-white"> <i class="fa fa-building"> </i> My Work Statistics  </div>
<div class="card-body ">

  <div class="row m-b-20">
    <div class="col-md-4">
      <div class="shadow card text-center p-30 white text-white" style="background:#5cb85c">
        </br>
        <span><i class="fa fa-users fa-3x"></i>
        <span style="font-size:3em; font-family:Open Sans, sans-serif;"> 0</span> 
        </span>
        <h3 style="font-size:1em font-family:Open Sans, sans-serif;"> Companies Approved </h3>
      </div>
    </div>
    <div class="col-md-4">
      <div class="bg-dot bg-light shadow card text-center p-30">
      </br>
        <span><i class="fa fa-sync fa-spin fa-3x"> </i> 
        <span style="font-size:3em; font-family:Open Sans, sans-serif;"> 0</span> 
        </span>
        <h3 style="font-size:1em font-family:Open Sans, sans-serif;"> Companies Pending </h3>
      </div>
    </div>
    <div class="col-md-4">
      <div class="bg-dot bg-danger shadow card text-center p-30 text-white">
      </br>
        <span style="font-size:3em; font-family:Open Sans, sans-serif;"><i class="fa fa-times fa-1x"> </i> 
        <span> 
          0
        </span>
        </span>
        <h3 style="font-size:1em font-family:Open Sans, sans-serif;"> Companies Not Approved </h3>
      </div>
    </div>
   
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