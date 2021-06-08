@extends('superadmin.layout.template')

@section('content')

        <!-- Begin Page Content -->
        <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">List Settings</h1>
    
    <a href="/superadmin/setting/create" class="btn btn-success btn-icon-split">
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
                <td>{{ "$setting->setting_description" }}</td>
                <td width="15%">
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
    <!-- End of Main Content -->
    
@endsection
</body>
<script src="{{ asset('assets/superadmin/js/ajax/deleteProductCategory.js') }}"></script>
</html>
