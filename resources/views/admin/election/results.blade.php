@extends('layout.admin')

@section('stylesheets')
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- Animate style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endsection

@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Overview</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active">Overview</li>
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
        @endif
        
        @if(!empty($election))
	        <br><br>
	        <div class="col-md-4">
	          <!-- Widget: user widget style 2 -->
	          <div class="card card-widget widget-user-2">
	            <!-- Add the bg color to the header using any of the bg-* classes -->
	            <div class="widget-user-header bg-warning">
	              <!-- /.widget-user-image -->
	              <h3>
	                {{ $election->name }}
	              </h3>
	              <small>
	                {{ \Carbon\Carbon::parse($election->date_start)->format('F d, Y h:i A') }} - {{ \Carbon\Carbon::parse($election->date_end)->format('F d, Y h:i A') }}
	              </small>
	            </div>
	            <div class="card-footer p-0">
	              <ul class="nav flex-column">
	                <li class="nav-item">
	                  <a href="#" class="nav-link">
	                    Participation <span class="float-right badge bg-primary">31%</span>
	                  </a>
	                </li>
	                <li class="nav-item">
	                  <a href="#" class="nav-link">
	                    Voters <span class="float-right badge bg-info">5</span>
	                  </a>
	                </li>
	                <li class="nav-item">
	                  <a href="#" class="nav-link">
	                    Teachers <span class="float-right badge bg-success">12</span>
	                  </a>
	                </li>
	                <li class="nav-item">
	                  <a href="#" class="nav-link">
	                    Course <span class="float-right badge bg-danger">842</span>
	                  </a>
	                </li>
	                <li class="nav-item">
	                  <a href="#" class="nav-link">
	                    Position <span class="float-right badge bg-danger">842</span>
	                  </a>
	                </li>
	                <li class="nav-item">
	                  <a href="#" class="nav-link">
	                    Candidates <span class="float-right badge bg-danger">842</span>
	                  </a>
	                </li>
	                <li class="nav-item">
	                  <a href="/" class="nav-link text-center">
	                    <small>Overview</small>
	                  </a>
	                </li>
	              </ul>
	            </div>
	          </div>
	          <div class="card card-widget widget-user-2">
	            <div class="card-header">
	              Election Details
	            </div>
	            <div class="card-body description">
	              {!! $election->description !!}
	            </div>
	            <div class="card-footer">
	            </div>
	          </div>
	          <!-- /.widget-user -->
	        </div>
	        <div class="col-md-8">
	        	@foreach($election->positions as $position)
		          	<!-- Default box -->
				    <div class="card">
				      <div class="card-header">
				        <h3 class="card-title">{{ $position->name }}&nbsp;&nbsp;&nbsp;&nbsp;<span class="badge bg-primary">{{ $position->number_elected }}</span></h3>

				        <div class="card-tools">
				          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
				            <i class="fas fa-minus"></i>
				          </button>
				          <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
				            <i class="fas fa-times"></i>
				          </button>
				        </div>
				      </div>
				      <div class="card-body p-0">
				        <table class="table table-striped projects">
				            <tbody class="positions" data-id="{{ encrypt($position->id) }}">
			                    <div class="overlay-wrapper">
			                        <div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">&nbsp;&nbsp;&nbsp;Loading...</div></div>
			  			            	  @foreach($position->candidates as $candidate)
			  			                  <tr>
			  			                    <td style="width: 20%">
			  			                        <img alt="Avatar" class="table-avatar" src="{{ !empty($candidate->image->hash_name) ? url('storage/image/'. $candidate->image->hash_name) : asset('dist/img/default-candidate.png') }}">
			  			                        <a>
			  			                            &nbsp;&nbsp;{{ $candidate->name }}
			  			                        </a>
			  			                    </td>
			  			                    <td class="project_progress" style="width: 80%">
			  			                        <div class="progress progress-sm">
			  			                            <div class="progress-bar bg-green progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="0" style="width: 0%">
			  			                            </div>
			  			                        </div>
			  			                        <small>
			  			                            Counting...
			  			                        </small>
			  			                    </td>
			  			                  </tr>
			  			                @endforeach
			                    </div>
				            </tbody>
				        </table>
				      </div>
				      <!-- /.card-body -->
				    </div>
				    <!-- /.card -->
	            @endforeach
	        </div>
        @endif
      </div>
    </div>
  </section>
@endsection

@section('scripts')
  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('dist/js/demo.js') }}"></script>
  <!-- Page specific script -->
  <script type="text/javascript">
    $('.description').find('iframe').css({'width': '100%', 'height' : '400px'});

    function compute(){

      $('tbody.positions').each(function(){
          let element = $(this)
          fetch('{{ route('count_ballot', '') }}/' + element.data('id'), {
              method: 'post',
              headers: {
                'content-type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          }).then(function(res) {
              return res.json();
          }).then(function(results) {

            element.empty()
            $.each(results, function(i, v){
              element.append(
                `<tr>
                    <td style="width: 20%">
                        <img alt="Avatar" class="table-avatar" src="`+ v[2] +`">
                        <a>
                            &nbsp;&nbsp;`+ v[0] +`
                        </a>
                    </td>
                    <td class="project_progress" style="width: 80%">
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-green progress-bar-striped" role="progressbar" aria-valuenow="`+ v[1] +`" aria-valuemin="`+ v[1] +`" aria-valuemax="100" style="width: `+ v[1] +`%">
                            </div>
                        </div>
                        <small>
                            `+ v[1] +` Vote(s)
                        </small>
                    </td>
                </tr>`);
            });
            
            $('.overlay').remove()
            console.log("Done!")

          }).catch(function (error) {

          });
      })
    }
    compute()
    setInterval(compute, 10000)
  </script>
@endsection