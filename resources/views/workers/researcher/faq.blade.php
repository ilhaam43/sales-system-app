@extends('workers.researcher.layout.templates')

@section('content')
  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h3></h3>
          <ol>
            <li><a href="#">Researcher</a></li>
            <li>FAQ (Frequently Asked Questions)</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <div class="card shadow mb-4">
      <div class="card-body">
          <h2 class="text-center em4"> Frequently Asked Questions </h2> <hr class="hr-short-auto">
            <img src="https://searchclientnow.com/images/faq.png" width="280" height="250" alt="upgrade" class="m-w-600 d-block m-auto"><hr>
                <div class="form-group">
                    <p><strong>Q:&nbsp;</strong>When I input company&nbsp;for research, there are some&nbsp;repeat. What should I do?</p>
              
                    <p><strong>A:&nbsp;</strong>yes, currently there are already some companies in the system so it will be easy to come cross repeat problem. What you need to do is to check &ldquo;Researches-Current Countries Records part&rdquo; to see which countries are with less records then you can search the companies in that area.</p>
                    
                    <p>&nbsp;</p>
                    
                    <p><strong>Q:&nbsp;</strong>How to get paid?</p>
                    
                    <p><strong>A:&nbsp;</strong>There are two kinds of way for payment:</p>
                    
                    <p>If you want the payment in advance, you can send me the offer through upwork, such as you can send us offer of USD10, then we make you the contract, you start the job. When your amount of system has reached USD10, we will release the payment on upwork.</p>
                    
                    <p>There is another way is the payment after work. There is real-time approved quantity of research/inquiry&nbsp;in your payment&nbsp;part. When you want payment, please send inner message to&nbsp;request payment, then we will pay you the total amount based on your real-time approved quantity through paypal or payoneer.</p>
                    
                    <p>&nbsp;</p>
                    
                    <p><strong>Q:</strong>&nbsp;How to start work?</p>
                    
                    <p><strong>A:&nbsp;</strong>If you are interested in this job, please send your job application in the system and send a offer of USD10 on upwork&nbsp;at the same time. We will test the amount of USD10 work first. If everything works well, we will work by upwork/paypal/payoneer in future based on your choice.</p>
                    
                    <p>&nbsp;</p>
                    
                    <p><strong>Q: </strong>Why my account does not work?</p>
                    
                    <p><strong>A: </strong>If the user does not work for seven continuous days, the system will think you give up the job and block your account. If you want to continue the work, you need to send the application again to restart the work.</p>
                    <p>&nbsp;</p>
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