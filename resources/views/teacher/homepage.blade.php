@extends('layout.teacher')

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
      @php
        $election = Helper::get_active_election();
      @endphp
      <div class="row">
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
                    Participation <span class="float-right badge bg-primary">{{ $election->votes->groupBy('user_id')->count() }}%</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    Students <span class="float-right badge bg-info">{{ $election->users->where('role_id', 3)->count() }}</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    Teachers <span class="float-right badge bg-success">{{ $election->users->where('role_id', 2)->count() }}</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    Position <span class="float-right badge bg-danger">{{ $election->positions->count() }}</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    Candidates <span class="float-right badge bg-warning">{{ $election->candidates->count() }}</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('election_result') }}" class="nav-link text-center">
                    <small>Results</small>
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
          <!-- Radio Buttons -->
          <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn bg-olive active all">
              <input type="radio" autocomplete="off" checked> All
            </label>
            @foreach($election->positions as $value)
              <label class="btn bg-olive position-selector" data-filter="{{ "filter-".$value->id }}">
                <input type="radio" autocomplete="off"> {{ $value->name }}
              </label>
            @endforeach
          </div>
          <div class="row" style="margin-top: 10px;">
            @foreach($election->candidates as $value)
              <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch animate__animated animate__pulse filter-{{ $value->position->id }}">
                <div class="card bg-light">
                  <div class="card-header text-muted border-bottom-0">
                    {{ $value->position->name }}
                  </div>
                  <div class="card-body pt-0">
                    <div class="row">
                      <div class="col-7">
                        <h2 class="lead"><b>{{ $value->name }}</b></h2>
                        <p class="text-muted text-sm"><b>Course: </b> {{ $value->degree->name." ".$value->area_of_study }} </p>
                        <ul class="ml-4 mb-0 fa-ul text-muted">
                          <li class="small"><span class="fa-li"><i class="far fa-flag"></i></span> {{ $value->agenda }}</li>
                        </ul>
                      </div>
                      <div class="col-5 text-center">
                        <img src="{{ !empty($value->image->hash_name) ? url('storage/image/'. $value->image->hash_name) : asset('dist/img/default-candidate.png') }}" alt="user-avatar" class="img-circle img-fluid">
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="text-right">
                      <a href="{{ route('candidates.show', $value->id) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-user"></i>&nbsp;&nbsp;View Profile
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
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
  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('dist/js/demo.js') }}"></script>
  <!-- Page specific script -->
  <script type="text/javascript">
    $('.all').on('click', function(){
      $('.table-responsive').hide()

      $('.animate__animated').each(function(){
          $(this).removeClass('animate__fadeOut')
          $(this).addClass('animate__pulse')
          $(this).show()
      })
    })

    $('.position-selector').off().on('click', function(){
      let filter = $(this).data('filter')

      $('.animate__animated').each(function(){
          if ($(this).hasClass(filter)){
            $(this).removeClass('animate__fadeOut')
            $(this).addClass('animate__pulse')
            $(this).show()
            return;
          }
          $(this).addClass('animate__fadeOut')
          $(this).removeClass('animate__pulse')
          $(this).hide()

      })
    })

    $('.description').find('iframe').css({'width': '100%', 'height' : '400px'});
  </script>
@endsection