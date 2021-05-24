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
          <h1>Cast Ballot</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active">Cast Ballot</li>
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
          <form action="{{ route('ballot.store') }}" method="post" class="ballot">
            @csrf
          	@foreach($election->positions as $position)
              <div>
      	        <!-- Default box -->
      			    <div class="card">
      			      <div class="card-header">
      			        <h3 class="card-title position">{{ $position->name }}</h3>
                    <br>
                    <a class="btn btn-primary btn-sm float-right view-summary" data-toggle="modal" data-target="#choices-summary">View Summary</a>
                    Please select only <span class="badge bg-primary number-elected">{{ $position->number_elected }}</span> candidate(s).
      			      </div>
      			      <!-- /.card-body -->
      			    </div>
      			    <!-- /.card -->
                <div class="row">
                  @foreach($position->candidates as $candidate)
                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch animate__animated animate__pulse filter-{{ $candidate->position->id }}">
                      <div class="card bg-light">
                        <div class="card-header text-muted border-bottom-0">
                          {{ $candidate->position->name }}
                        </div>
                        <div class="card-body pt-0">
                          <div class="row">
                            <div class="col-7">
                              <h2 class="lead"><b>{{ $candidate->name }}</b></h2>
                              <p class="text-muted text-sm"><b>Course: </b> {{ $candidate->degree->name." ".$candidate->area_of_study }} </p>
                              <ul class="ml-4 mb-0 fa-ul text-muted">
                                <li class="small"><span class="fa-li"><i class="far fa-flag"></i></span> {{ $candidate->agenda }}</li>
                              </ul>
                            </div>
                            <div class="col-5 text-center">
                              <img src="{{ !empty($candidate->image->hash_name) ? url('storage/image/'. $candidate->image->hash_name) : asset('dist/img/default-candidate.png') }}" alt="user-avatar" class="img-circle img-fluid">
                            </div>
                          </div>
                        </div>
                        <div class="card-footer">
                            <div class="custom-control custom-switch">
                              <input style="cursor: pointer;" type="checkbox" class="custom-control-input select-candidate" id="switch-{{ $position->id }}-{{ $candidate->id }}" name="candidates[]" value="{{ encrypt($candidate->id) }}">
                              <label style="cursor: pointer;" class="custom-control-label" for="switch-{{ $position->id }}-{{ $candidate->id }}">Select / Deselect</label>
                            </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
              <br>
            @endforeach
            <div class="row" style="justify-content: center;">
              <div class="btn-group">
                <a class="btn btn-primary btn-sm" id="all-view-summary" data-toggle="modal" data-target="#choices-summary">View Summary</a>
                <button class="btn btn-success btn-sm">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cast Ballot&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <div class="modal fade" id="choices-summary">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title position"></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <ul class="products-list product-list-in-card pl-2 pr-2 choices-summary">
          </ul>
        </div>
        <div class="modal-footer justify-content-between">
          <button class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <div class="modal fade" id="authorize">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title">Confirmation</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('check_password') }}" method="post" class="check-password">
          @csrf
          <div class="modal-body">
            <div class="form-group row">
              <label for="inputPassword3" class="col-sm-3 col-form-label">Password <span style="color: red">*</span></label>
              <div class="col-sm-9">
                <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="password" required="">
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            <button class="btn btn-primary btn-sm">Proceed</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
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

    $('.select-candidate').on('click', function(){
      let element = $(this)

      element.toggleClass('selected')
      let parent = element.parent().parent().parent().parent().parent().siblings()
      let num_elec = parent.find('.number-elected').text()
      let selected = parent.siblings().find('.selected').length

      if (parseInt(selected) <= parseInt(num_elec)) {
        return true;
      }

      toastr.error("You can select only "+num_elec+" candidate(s). Please deselect before proceeding.")
      element.prop('checked', false)
      element.toggleClass('selected')  
    })

    $('.view-summary').on('click', function(){
      let element = $(this)
      let title = element.siblings('h3.position').text()
      $('#choices-summary').find('h6.position').text(title)
      $('.choices-summary').empty()

      if (!element.parent().parent().siblings().find('.selected').length) {
        $('.choices-summary').append(`<li class="item"><small>No selected candidate(s)</small></li>`)
        return true;
      }
      
      element.parent().parent().siblings().find('.selected').each(function(){
        let name = $(this).parent().parent().siblings().find('h2').text()
        let course = $(this).parent().parent().siblings().find('p').text()
        let img = $(this).parent().parent().siblings().find('img').attr('src')
        $('.choices-summary').append(`
          <li class="item">
            <div class="product-img">
              <img src="`+ img +`" alt="Candidate Image" class="img-size-50">
            </div>
            <div class="product-info">
              <a href="javascript:void(0)" class="product-title">`+ name +`</a>
              <span class="product-description">
                `+ course +`
              </span>
            </div>
          </li>`)
      })
    })

    $('#all-view-summary').on('click', function(){
      $('h6.position').text("Summary")
      $('.choices-summary').empty()
      $('h3.position').each(function(){
        let element = $(this)

        $('.choices-summary').append(`<br><span class="badge badge-primary">`+ element.text() +`</span><br>`)

        element.parent().parent().siblings().find('.selected').each(function(){
          let name = $(this).parent().parent().siblings().find('h2').text()
          let course = $(this).parent().parent().siblings().find('p').text()
          let img = $(this).parent().parent().siblings().find('img').attr('src')
          $('.choices-summary').append(`
            <li class="item">
              <div class="product-img">
                <img src="`+ img +`" alt="Candidate Image" class="img-size-50">
              </div>
              <div class="product-info">
                <a href="javascript:void(0)" class="product-title">`+ name +`</a>
                <span class="product-description">
                  `+ course +`
                </span>
              </div>
            </li>`)
        })

        if (!element.parent().parent().siblings().find('.selected').length) {
          $('.choices-summary').append(`<li><small>No selected candidate(s)</small></li>`)
        }
      })
    })

    $('form.ballot').on('submit', function(evt){
      evt.preventDefault();

      $('#authorize').modal('show')
    })

    $('form.check-password').on('submit', function(evt){
      evt.preventDefault();

      $.ajax({
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: 'json',
        type: 'post'
      })
      .done(function(res){
        if (res) {
          $('form.ballot').unbind('submit').submit()
          return true;
        }
        toastr.error("Password is incorrect")
      })
    })

  </script>
@endsection