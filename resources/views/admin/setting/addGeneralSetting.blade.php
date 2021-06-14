@extends('admin.layout.template')

@section('content')

        <!-- Begin Page Content -->
        <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Add Settings</h1>
    
    </br>
    @if (session('error'))
        <div class="alert alert-danger">
            <ul>
                <li>{{ session('error') }}</li>
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            <ul>
                <li>{{ session('success') }}</li>
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Add Settings</h6>
      </div>
      <div class="card-body">
      <form method="POST" action="{{ route('admin.settings.store') }}">
      @csrf
          <div class="form-row">
            <div class="col-sm-12">
              <label for="name"><b>Setting Name :</label></b>
              <input type="text" class="form-control" placeholder="Setting Name" name="setting_name" required>
            </div>
            <div class="col-sm-12">
              </br>
              <label for="name"><b>Setting Description :</label></b>
              <textarea class="ckeditor form-control" name="setting_description" value="setting_description" required></textarea>
            </div>
          </div>
          </br>
          <a href="{{url('superadmin/setting')}}" class="btn btn-danger">Cancel</a>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>

    </div>
    <!-- /.container-fluid -->

    </div>

  
    <!-- End of Main Content -->
    
@endsection
</body>
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.ckeditor').ckeditor();
    });
</script>

</html>
