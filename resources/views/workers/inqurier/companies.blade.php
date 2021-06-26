@extends('workers.inqurier.layout.templates')

@section('content')
  <main id="main" data-aos="fade-up">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
        <div class="d-flex justify-content-between align-items-center">
          <h3></h3>
          <ol>
            <li style="margin-left:20px;"><a href="#">Inqurier</a></li>
            <li style="margin-right:20px;">Companies</li>
          </ol>
        </div>
    </section><!-- End Breadcrumbs -->

    <div class="card shadow mb-4">
      <div class="card-body">
      <h4 style="margin-left:10px;">Companies List</h4>

      <a href="#" class="btn btn-outline-primary btn-icon-split" data-toggle="modal" data-target="#inquiryContentModal" style="float: right; margin-right:10px;"><i class="fa fa-envelope p-r-5"></i>
        <span class="text">Inquiry Content</span>
      </a>
    
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

              <table class="table table-responsive table-bordered" id="dataTable" width="100%" cellspacing="0">
                  </br>
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>Company</th>
                      <th>Website</th>
                      <th>Country</th>
                      <th width="15%">Inquiry</th>
                      <th width="10%">Website Problem</th>
                    </tr>
                  </thead>
                  
                </table>
              </div>
            </div>
        </div>
    </div>  
  
  </main><!-- End #main -->

  <!-- Inquiry Content Modal-->
  <div class="modal fade" id="inquiryContentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Template Message</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
        {!! $getTemplateMessage->setting_description !!}
        </div>
        
      </div>
    </div>
  </div>

    

  <!-- ======= Footer ======= -->
  
  <!-- Add Send Inquiry Modal-->
  <div class="modal fade" id="sendInquiry" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Inquiry</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
        <form method="POST" action="{{url('inqurier/add-inquiry')}}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="research_jobs_id" id="research_jobs_id"> 
        <div class="form-group">
          <label for="name"><b>Screenshot :</label></b>
          <input type="file" name="screenshot" class="form-control" id="screenshot" required>
        </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Send Report Modal-->
  <div class="modal fade" id="sendReport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Report Message</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
        <form method="POST" action="{{url('inqurier/add-report')}}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="research_jobs_id" id="research_id"> 
        <div class="form-group">
          <label for="name"><b>Report Message :</label></b>
          <textarea class="form-control" name="report_message" value="report_message" required></textarea>
        </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div id="preloader"></div>
  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
  @endsection

  
</body>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script language="javaScript" type="text/javascript">
            $(document).ready(function () {
              $("#sendInquiry").on("show.bs.modal", function (e) {
                    var id = $(e.relatedTarget).data('target-id');
                    $('#research_jobs_id').val(id);
                });
            });
</script>
<script language="javaScript" type="text/javascript">
            $(document).ready(function () {
              $("#sendReport").on("show.bs.modal", function (e) {
                    var id = $(e.relatedTarget).data('target-id');
                    $('#research_id').val(id);
                });
            });
</script>
@include('workers.javascript.showCompaniesData')
</html>