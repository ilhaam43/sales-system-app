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
            <li>How We Work</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

  <div class="container h-page-80">
    <div class="form-group p-t-20 p-b-40">
      <div class="form-group shadow card p-40">
        <div class="alert alert-info text-center p-20 m-b-30"> Thank you for registering system, here is the working way: </div>
          <div class="form-group m-b-30"> 
            <div class="card-body">
            <table class="table-responsive">
            <tbody>
              <tr>
                <td>
                {!! $howWeWork->setting_description ?? "" !!}
                </td>
                <td>&nbsp;</td>
                  </tr>
                </tbody>
              </table>
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