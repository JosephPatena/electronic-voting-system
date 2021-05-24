@extends('layout.student')

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
          <h1>Results</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active">Results</li>
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
      		$election = Helper::find_election();
      	@endphp
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