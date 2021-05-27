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
@endsection

@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Manage Candidate</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active">Manage Candidate</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="col-md-12">
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
          @foreach($candidates as $value)
            <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch animate__animated animate__pulse">
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
                    <a href="#" class="btn btn-sm bg-teal">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a href="{{ route('candidates.show', $value->id) }}" class="btn btn-sm btn-primary">
                      <i class="fas fa-user"></i>&nbsp;&nbsp;View Profile
                    </a>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
          <div class="col-md-12">
            <center>{{ $candidates->links() }}</center>
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
@endsection