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
	        <h1>Courses</h1>
	      </div>
	      <div class="col-sm-6">
	        <ol class="breadcrumb float-sm-right">
	          <li class="breadcrumb-item"><a href="/">Home</a></li>
	          <li class="breadcrumb-item active">Courses</li>
	        </ol>
	      </div>
	    </div>
	  </div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">
	  <div class="container-fluid">
	    <div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">Add New Degree</div>  
            <div class="card-body">
              <form action="{{ route('courses.store') }}" method="post">
                @csrf
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Degree <span style="color: red">*</span></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="name" placeholder="Ex: Bachelor's" value="{{ old('name') }}" required="">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">&nbsp;</label>
                  <div class="col-sm-8">
                    <button class="btn btn-success btn-sm" type="suubmit"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                  </div>
                </div>
              </form>
            </div>
            <div class="card-footer"></div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">List</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th>Title</th>
                  <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($courses as $key => $value)
                    <tr>
                      <form action="{{ route('courses.update', $value->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <td class="text-center">{{ $key+1 }}.</td>
                        <td>
                          <span>{{ $value->name }}</span>
                          <input type="text" style="display: none;" name="name" value="{{ $value->name }}" class="form-control" required="">
                        </td>
                        <td class="text-center">
                          <div class="btn-group">
                            <button class="btn btn-primary btn-sm edit"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-success btn-sm save" type="submit" style="display: none;"><i class="fas fa-save"></i></button>
                            <button class="btn btn-danger btn-sm delete" data-key={{ $key }}><i class="fas fa-trash-alt"></i></button>
                          </div>
                        </td>
                      </form>
                      <form action="{{ route('courses.destroy', $value->id) }}" method="post" class="delete{{ $key }}">
                        @csrf
                        @method('DELETE')
                      </form>
                    </tr>
                  @endforeach
                </tbody>
              </table>
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
    <script type="text/javascript">
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

      $(document).on('click', 'button.edit', function(evt){
        evt.preventDefault();

        $(this).parent().parent().siblings().children('span').hide()
        $(this).parent().parent().siblings().children('input').show()
        $(this).hide()
        $(this).siblings('button.save').show()
      })

      $(document).on('click', 'button.delete', function(evt){
        evt.preventDefault();
        let element = $(this)

        let check = confirm("Are you sure you want to remove this item? All associated data with this item will also going to be deleted. This process cannot be undone.");
        if (check) {
          $('form.delete' + element.data('key')).submit()
        }

      })
    </script>
@endsection