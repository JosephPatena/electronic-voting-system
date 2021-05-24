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
	        <h1>Election Dashboard</h1>
	      </div>
	      <div class="col-sm-6">
	        <ol class="breadcrumb float-sm-right">
	          <li class="breadcrumb-item"><a href="/">Home</a></li>
	          <li class="breadcrumb-item active">Election Dashboard</li>
	        </ol>
	      </div>
	    </div>
	  </div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">
	  <div class="container-fluid">
	    <div class="row">
	      <div class="col-12">
			<div class="card">
	          <div class="card-header">
	            <h3 class="card-title">List</h3>
	          </div>
	          <!-- /.card-header -->
	          <div class="card-body">
	            <table id="example1" class="table table-bordered table-striped projects">
	              <thead>
	              <tr>
	                <th>Election Name</th>
	                <th>Candidates</th>
	                <th>Participation</th>
	                <th>Status</th>
	              </tr>
	              </thead>
	              <tbody>
	              	@foreach($elections as $election)
	              		<tr>
	              			<td>{{ $election->name }}</td>
	              			<td>
		                        <ul class="list-inline">
		                        	@foreach($election->candidates->take(10) as $candidate)
			                            <li class="list-inline-item">
			                                <img style="cursor: pointer;" title="{{ $candidate->name }}" alt="Avatar" class="table-avatar" src="{{ !empty($candidate->image->hash_name) ? url('storage/image/'. $candidate->image->hash_name) : asset('dist/img/default-candidate.png') }}">
			                            </li>
		                        	@endforeach
		                        </ul>
		                    </td>
	              			<td class="project_progress">
		                        <div class="progress progress-sm">
		                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="{{ $election->votes->groupBy('user_id')->count() }}" aria-valuemin="0" aria-valuemax="{{ $election->users->where('role_id', 3)->count() }}" style="width: {{ $election->votes->groupBy('user_id')->count() }}%">
		                            </div>
		                        </div>
		                        <small>
		                            {{ $election->votes->groupBy('user_id')->count() }} People Participates
		                        </small>
		                    </td>
		                    <td>
	              				<form action="{{ route('elections.destroy', encrypt($election->id)) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <i class="fas fa-ellipsis-v" style="float: right; cursor: pointer;" data-toggle="dropdown"></i>
                                    <div role="menu" class="dropdown-menu">
                                        <a href="{{ route('elections.show', $election->id) }}" class="dropdown-item">Manage Election</a>
                                        @if(\Carbon\Carbon::now()->format('Y-m-d H:i:s') < $election->date_start)
                                        	<a href="#" class="dropdown-item delete">Delete Election</a>
                                        @endif
                                        @if((\Carbon\Carbon::now()->format('Y-m-d H:i:s') > $election->date_start) && (\Carbon\Carbon::now()->format('Y-m-d H:i:s') < $election->date_end))
                                        	<a href="{{ route('end_election', encrypt($election->id)) }}" class="dropdown-item stop">End Election</a>
                                        @endif
                                    </div>
                                </form>
                                @if(\Carbon\Carbon::now()->format('Y-m-d H:i:s') > $election->date_end)
                                	<span class="badge badge-primary">Ended</span>
                                @elseif(($election->date_start <= \Carbon\Carbon::now()->format('Y-m-d H:i:s')) && ($election->date_end >= \Carbon\Carbon::now()->format('Y-m-d H:i:s')))
		                        	<span class="badge badge-success">On Going</span>
                                @else
                                	<span class="badge badge-warning">Not Yet Started</span>
                                @endif
		                    </td>
	              		</tr>
	              	@endforeach
	              </tbody>
	            </table>
              	<center>
              		{{ $elections->links() }}
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

  	    $('.delete').on('click', function(){
  	    	$(this).closest('form').submit()
  	    })
  	  });
  	</script>
@endsection