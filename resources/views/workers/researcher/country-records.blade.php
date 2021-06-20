@extends('workers.researcher.layout.templates')

@section('content')
    <main id="main" data-aos="fade-up">

        <!-- ======= Breadcrumbs ======= -->
        <section class="breadcrumbs">
            <div class="d-flex justify-content-between align-items-center">
            <h3></h3>
            <ol>
                <li style="margin-left:20px;"><a href="#">Researcher</a></li>
                <li style="margin-right:20px;">Country Records</li>
            </ol>
            </div>
        </section><!-- End Breadcrumbs -->

        <div class="card shadow mb-4">
        <div class="card-body">
        <h4 style="margin-left:10px;">Country Records List</h4>
        <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    </br>
                    <thead>
                        <tr>
                        <th width="10%">No</th>
                        <th width="50%">Country</th>
                        <th width="40%">Current Records Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($countriesRecords as $records)
                        <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $records['country_name'] }}</td>
                        <td>{{ $records['count'] }}</td>
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