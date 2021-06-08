@extends('superadmin.layout.template')

@section('content')

        <!-- Begin Page Content -->
        <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">List Settings</h1>
    
    <a href="#" class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#addSettingModal">
        <span class="text">Add New Setting</span>
    </a>
    </br></br>
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

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Settings List</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Title</th>
                <th>Description</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($settings as $setting)
              <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $setting->setting_name }}</td>
                <td>{{ $setting->setting_description }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" href="{{ route('settings.detail',$setting->id) }}">Edit</a>

                    <button class="btn btn-danger btn-sm remove-user" data-id="{{ $setting->id }}" data-action="{{ route('settings.destroy',$setting->id) }}" onclick="deleteConfirmation({{$setting->id}})"> Delete</button>
                  </form>
                </td>
              </tr>
            </tbody>
            @endforeach
          </table>
        </div>
      </div>
    </div>

    </div>
    <!-- /.container-fluid -->

    </div>

    <!-- Add Product Modal-->
    <div class="modal fade" id="addSettingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add New Setting</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
        <form method="POST" action="{{url('superadmin/setting')}}">
        {{ csrf_field() }}
        <div class="form-group">
          <label for="name"><b>Name Setting :</label></b>
          <input type="text" name="setting_name" class="form-control" id="setting_name" required>
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

  
    <!-- End of Main Content -->
    
@endsection
</body>
<script src="{{ asset('assets/superadmin/js/ajax/deleteProductCategory.js') }}"></script>
</html>
