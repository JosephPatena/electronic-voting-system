@extends('layout.student')

@section('stylesheets')
  	<!-- Google Font: Source Sans Pro -->
  	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  	<!-- Font Awesome -->
  	<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  	<!-- Theme style -->
  	<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
@endsection

@section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row" style="justify-content: center;">
          <!-- left column -->
          <div class="col-md-4">
          	<!-- Widget: user widget style 1 -->
		    <form class="form-horizontal" action="{{ route('update_profile', encrypt(Auth::id())) }}" method="post" enctype="multipart/form-data">
			    @csrf
	            <div class="card card-widget widget-user">
	              <!-- Add the bg color to the header using any of the bg-* classes -->
	              <div class="widget-user-header bg-info">
	                <h3 class="widget-user-username">{{ Auth::user()->name }}</h3>
	                <h5 class="widget-user-desc">Student</h5>
	              </div>
	              <div class="widget-user-image">
	                <img class="img-circle elevation-2 change" src="{{ !empty(Helper::get_user_image()) ? url('storage/image/'.Helper::get_user_image()->hash_name) : asset('dist/img/default-user.png') }}" alt="User Avatar" style="cursor: pointer;" title="Click to Change Photo">
	                <input class="file" type="file" name="image" hidden="">
	              </div>
	              <div class="card-footer">
	              </div>
	            </div>
	            <!-- /.widget-user -->
				<!-- Horizontal Form -->
			    <div class="card card-info">
			      <!-- form start -->
			        <div class="card-body">
			          <div class="form-group row">
			            <label for="inputName" class="col-sm-4 col-form-label">Name</label>
			            <div class="col-sm-8">
			              <input type="text" class="form-control" id="inputName" placeholder="Email" name="name" required="" value="{{ Auth::user()->name }}">
			            </div>
			          </div>
			          <div class="form-group row">
			            <label for="inputUsername" class="col-sm-4 col-form-label">Username</label>
			            <div class="col-sm-8">
			              <input type="text" class="form-control" id="inputUsername" placeholder="Username" name="email" required="" value="{{ Auth::user()->email }}">
			            </div>
			          </div>
			          <br>
			          <div class="form-group">
	                    <div class="custom-control custom-switch">
	                      <input type="checkbox" class="custom-control-input" id="customSwitch1" name="change_pass">
	                      <label class="custom-control-label" for="customSwitch1" style="cursor: pointer;">Change Password</label>
	                    </div>
	                  </div>
			          <div class="form-group row">
			            <label for="inputPassword" class="col-sm-4 col-form-label">Password</label>
			            <div class="col-sm-8">
			              <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="password">
			            </div>
			          </div>
			          <div class="form-group row">
			            <label for="inputRetypePassword" class="col-sm-4 col-form-label">Retype Password</label>
			            <div class="col-sm-8">
			              <input type="password" class="form-control" id="inputRetypePassword" placeholder="Retype Password" name="confirm_password">
			            </div>
			          </div>
			        </div>
			        <!-- /.card-body -->
			        <div class="card-footer">
			          <button type="submit" class="btn btn-info btn-sm float-right">Update</button>
			        </div>
			        <!-- /.card-footer -->
			    </div>
		    </form>
		    <!-- /.card -->
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
	<!-- bs-custom-file-input -->
	<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
	<!-- AdminLTE App -->
	<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="{{ asset('dist/js/demo.js') }}"></script>
	<!-- Page specific script -->
	<script type="text/javascript">
		$('img.change').on('click', function(){
			$('input.file').click()
		})

		$('input.file').on('change', function(){
			if (event.target.files[0]) {
            	$('img.change').attr("src", URL.createObjectURL(event.target.files[0]));
            	return true;
			}
			$('img.change').attr("src", "{{ !empty(Helper::get_user_image()) ? url('storage/image/'.Helper::get_user_image()->hash_name) : asset('dist/img/default-user.png') }}");
        })
	</script>
@endsection