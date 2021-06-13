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
                  <tbody>
                    @foreach($companiesList as $companies)
                    <tr>
                      <td>{{++$i}}</td>
                      <td>{{$companies['company_name']}}</td>
                      <td>{{$companies['company_website']}}</td>
                      <td>{{$companies['country']['country_name']}}</td>
                      <td><button data-toggle="modal" data-target-id="{{ $companies['id'] }}" data-target="#sendInquiry" class="btn btn-primary btn-md"><i class="fa fa-envelope p-r-5"></i> Send Inquiry</button></td>
                      <td><button data-toggle="modal" data-target-id="{{ $companies['id'] }}" data-target="#sendReport" class="btn btn-danger btn-md"><i class="fa fa-info p-r-5"></i> Report</a></td>
                    </tr>
                    @endforeach
                  </tbody>
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
        <p>Hi,</p>

        <p>This is DEL ILLUMINATION who specializes in SOLAR LED LIGHT.</p>

        <p>We are a German company, whose designs are all from the German R&amp;D team.</p>

        <p>Recently we have updated our product line, please check them as follows:</p>

        <p>40W/60W/80W/100W/120W/160W All-in-One Solar LED Street Light</p>

        <p>40W/60W/80W/100W/120W/160W All-in-Two Solar LED Street Light</p>

        <p>180W Solar LED High Mast/Stadium Light</p>

        <p>20W Solar LED Billboard Light</p>

        <p>20W Solar LED Flood Light</p>

        <p>20W Solar LED Garden Light</p>

        <p>Here is our German patent design, please check this video:</p>

        <p><a href="https://youtu.be/nTxK8aLghQU">https://youtu.be/nTxK8aLghQU</a></p>

        <p>Here is our online latest German product catalog, please check it:</p>

        <p>https://bit.ly/3gP0iZC</p>

        <p>If you are interested in our products, please feel free to let us know&nbsp;by <a href="mailto:delsolarlight@hotmail.com" target="_blank">delsolarlight@hotmail.com</a>. We will send you further information.</p>

        <p>PS: If you do not want to receive such a message, please feel free to let us know the website where you received it. All unsubscribe requests will be done immediately, if it is not successfully unsubscribed, please also let us know. Sometimes there is an error for the email system. We are sorry for bothering you.</p>

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
</html>