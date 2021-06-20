@extends('workers.auditor.layout.templates')

@section('content')
  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
        <div class="d-flex justify-content-between align-items-center">
          <h3></h3>
          <ol>
            <li style="margin-left:20px;"><a href="#">Auditor</a></li>
            <li style="margin-right:20px;">FAQ</li>
          </ol>
        </div>
    </section><!-- End Breadcrumbs -->

    <div class="card shadow mb-4">
      <div class="card-body">
          <h2 class="text-center em4"> Frequently Asked Questions </h2> <hr class="hr-short-auto">
            <img src="https://searchclientnow.com/images/faq.png" width="280" height="250" alt="upgrade" class="m-w-600 d-block m-auto"><hr>
                <div class="form-group">
                {!! $auditorFAQ->setting_description ?? "" !!}
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