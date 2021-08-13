@extends('admin.layout.template')

@section('content')

        <!-- Begin Page Content -->
        <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Edit Product Sources</h1>
    
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
        <h6 class="m-0 font-weight-bold text-primary">Edit Product Sources</h6>
      </div>
      <div class="card-body">
      <form method="POST" action="{{ route('admin.sources.update',$sources->id) }}">
          @csrf
          @method('PUT')
          <div class="form-row">
            <div class="col-sm-6">
              <label for="name"><b>Sources :</label></b>
              <input type="text" class="form-control" placeholder="Sources" name="sources" value="{{$sources->sources}}" required>
            </div>
          </div>
          </br>
          <a href="{{url('admin/sources')}}" class="btn btn-danger">Cancel</a>
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

</html>
