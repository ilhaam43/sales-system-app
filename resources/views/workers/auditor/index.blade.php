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
                  <p><strong>Audit includes two parts: One is to audit research results and one is to audit inquiry results.</strong></p>

                  <p>&nbsp;</p>

                  <h2><strong>Research-Audit:</strong></h2>

                  <p>When you open the research pending parts, you will see a lot of companies list.</p>

                  <p>What you need to do is to open the company one by one to complete the information, Here are the poins you need to take care:</p>

                  <p><strong>Company website:&nbsp;</strong>Please check whether the website has<strong>&nbsp;http or https </strong>like<strong>&nbsp;<a href="https://solarafrica.org/">https://solarafrica.org/</a>&nbsp;not&nbsp;<a href="https://solarafrica.org/">solarafrica.org</a>. </strong>If there is no, please add it.</p>

                  <p><strong>Company email:&nbsp;</strong>&nbsp;Only one email for this part. If there is some mistakes for the email, please correct it. if there is no email on the website, please <strong>leave it blank</strong>. <strong>If the old one is a link, please delete the link and make it blank</strong>. For the email mistake, please check the FAQ&nbsp;part.</p>

                  <p>Country: <strong>No Chinese(including HK and Taiwan) and Indian</strong> companies, if it is from those countries, please disapprove them</p>

                  <p><strong>Form:</strong>&nbsp;Please confirm whether&nbsp;there is online inquiry form on the website or not. If you are not clear about what form is, please check the FAQ part.</p>

                  <p><strong>Category:</strong>&nbsp;It means what product do you find on the website. If you can find solar street light, solar panel, led street light all on one&nbsp;website, please take this priority: solar street light(first), solar panel(second), led street light(third).</p>

                  <p><strong>If the company&nbsp;does not belong to any of solar street light/solar panel/led street light&nbsp;companies, please&nbsp;input the &quot;others&quot;&nbsp;category and then disapprove it.</strong></p>

                  <p><strong>&nbsp;</strong>no email+no form=disapprove<br />
                  <br />
                  no email+with form=approve<br />
                  <br />
                  with email+no form=approve</p>

                  <p><br />
                  We will pay <strong>USD0.005</strong>&nbsp;for each record.</p>

                  <p>&nbsp;</p>

                  <h2><strong>Inquiry-Audit:</strong></h2>

                  <p>&nbsp;</p>

                  <p>You can find the inquiry part to see whether the screenshot on left side&nbsp;is based on the required inquiry content&nbsp;and&nbsp;same company information as the right side.</p>

                  <p>If it is right, please approve the inquiry. If not, please disapprove it.</p>

                  <p>&nbsp;</p>

                  <p>We will pay <strong>USD0.001</strong> for each inquiry result.</p>

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