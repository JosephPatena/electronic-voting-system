@extends('layout.admin')

@section('stylesheets')
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
@endsection

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
	  <div class="container-fluid">
	    <div class="row mb-2">
	      <div class="col-sm-6">
	        <h1>Manage Teacher</h1>
	      </div>
	      <div class="col-sm-6">
	        <ol class="breadcrumb float-sm-right">
	          <li class="breadcrumb-item"><a href="/">Home</a></li>
	          <li class="breadcrumb-item active">Manage Teacher</li>
	        </ol>
	      </div>
	    </div>
	  </div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">
	  <div class="container-fluid">
	    <div class="row">
	      <div class="col-4">
    		<!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-info">
                <h3 class="widget-user-username">{{ $teacher->name }}</h3>
                <h5 class="widget-user-desc">Educator</h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle elevation-2" src="{{ !empty($teacher->image->hash_name) ? url('storage/image/'.$teacher->image->hash_name) : asset('dist/img/default-user.png') }}" alt="User Avatar">
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">{{ Helper::unregistered_students($teacher)->count() }}</h5>
                      <span class="description-text">UNREGISTERED STUDENTS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">{{ Helper::students($teacher->id)->count() }}</h5>
                      <span class="description-text">REGISTERED STUDENTS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">
                        @if($teacher->restricted)
                          <span class="badge badge-warning">Access Disabled</span>
                        @else
                          <span class="badge badge-success">Access Enabled</span>
                        @endif
                      </h5>
                      <span class="description-text">STATUS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.widget-user -->
	      </div>
	      <div class="col-8">
			    <div class="card">
	          <div class="card-header">
	            <h3 class="card-title">Students</h3>
	          </div>
	          <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Course</th>
                  <th>Teacher</th>
                  <th>Date Registered</th>
                  <th>Status</th>
                </tr>
                </thead>
                <tbody>
                  @php
                    $students = Helper::students($teacher->id)->simplePaginate(20);
                  @endphp
                  @foreach($students as $value)
                    <tr>
                      <td>{{ $value->name }}</td>
                      <td>{{ $value->email }}</td>
                      <td>{{ $value->students_key->email }}</td>
                      <td>{{ $value->degree->name." ".$value->area_of_study }}</td>
                      <td>{{ Helper::user($value->teacher_id)->name }}</td>
                      <td><span class="badge badge-primary">{{ $value->created_at }}</span></td>
                      <td>
                        <i class="fas fa-ellipsis-v" style="float: right; cursor: pointer;" data-toggle="dropdown"></i>
                        <div role="menu" class="dropdown-menu">
                            <a href="#" class="dropdown-item delete-contact">Disable Access</a>
                        </div>
                        @if($value->votes->count())
                          <span class="badge badge-success">Has Voted</span>
                        @else
                          <span class="badge badge-warning">Hasn't Voted Yet</span>
                        @endif
                        @if($value->restricted)
                          <span class="badge badge-warning">Access Disabled</span>
                        @else
                          <span class="badge badge-success">Access Enabled</span>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              <center>
                  {{ $students->links() }}
              </center>
            </div>
            <!-- /.card-body -->
	        </div>
	      </div>
	  	</div>
	  </div>
	</section>
@endsection

@section('scripts')
	<!-- jQuery -->
  	<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  	<!-- Bootstrap 4 -->
  	<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  	<!-- DataTables  & Plugins -->
  	<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
  	<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  	<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  	<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
  	<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
  	<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
  	<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
  	<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
  	<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
  	<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
  	<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
  	<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
  	<!-- AdminLTE App -->
  	<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
  	<!-- AdminLTE for demo purposes -->
  	<script src="{{ asset('dist/js/demo.js') }}"></script>
  	<!-- Page specific script -->
  	<script>
  	  $(function () {
  	    $("#example1").DataTable({
  	      "responsive": true, "lengthChange": false, "autoWidth": false,
  	      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
  	    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  	    $('#example2').DataTable({
  	      "paging": true,
  	      "lengthChange": false,
  	      "searching": false,
  	      "ordering": true,
  	      "info": true,
  	      "autoWidth": false,
  	      "responsive": true,
  	    });
  	  });
  	</script>
@endsection