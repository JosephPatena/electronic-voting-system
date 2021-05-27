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
	        <h1>Student Dashboard</h1>
	      </div>
	      <div class="col-sm-6">
	        <ol class="breadcrumb float-sm-right">
	          <li class="breadcrumb-item"><a href="/">Home</a></li>
	          <li class="breadcrumb-item active">Student Dashboard</li>
	        </ol>
	      </div>
	    </div>
	  </div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">
	  <div class="container-fluid">
	    <div class="row">
	      @php
  		  	$election = Helper::get_active_election();
      	  @endphp
      	  
      	  @if(count(Helper::get_elections()) > 1)
      	  <div class="col-md-12">
            <div class="btn-group">
              <button type="button" class="btn btn-info btn-sm">{{ $election->name ? $election->name : "No Election Found" }}</button>
                <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu" role="menu">
                  @foreach(Helper::get_elections() as $value)
                    <a class="dropdown-item" href="{{ route('navigate', encrypt($value->id)) }}">{{ $value->name }}</a>
                  @endforeach
                </div>
            </div>
          </div>
          <br><br>
          @endif
	      <div class="col-12">
			<div class="card">
	          <div class="card-header">
	            <h3 class="card-title">List</h3>
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
			                        <a href="{{ route('enable_disable_access', encrypt($value->id)) }}" class="dropdown-item">{{ $value->restricted ? "Enable Access" : "Disable Access" }}</a>
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