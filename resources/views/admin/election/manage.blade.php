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
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <!-- Animate style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <!-- Froala -->
  <link rel="stylesheet" href="{{ asset('plugins/froala/css/froala_editor.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/froala/css/froala_style.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/froala/css/plugins/code_view.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/froala/css/plugins/draggable.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/froala/css/plugins/colors.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/froala/css/plugins/emoticons.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/froala/css/plugins/image_manager.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/froala/css/plugins/image.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/froala/css/plugins/line_breaker.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/froala/css/plugins/table.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/froala/css/plugins/char_counter.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/froala/css/plugins/video.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/froala/css/plugins/fullscreen.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/froala/css/plugins/file.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/froala/css/plugins/quick_insert.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/froala/css/plugins/help.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/froala/css/third_party/spell_checker.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/froala/css/plugins/special_characters.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">
@endsection

@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Manage Election</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active">Manage Election</li>
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
          <!-- Widget: user widget style 2 -->
          <div class="card card-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-warning">
              <!-- /.widget-user-image -->
              <h3>
                <form action="{{ route('elections.update', $election->id) }}" method="post">
                  @csrf
                  @method('PUT')
                  <span>
                    {{ $election->name }}
                  </span>
                  <input type="text" name="name" value="{{ $election->name }}" required="" style="display: none;">
                  &nbsp;&nbsp;
                  <i class="fa fa-edit edit-info" style="cursor: pointer; color: #0000EE; font-size: 10pt"></i>
                  <button style="display: none;" class="btn btn-success btn-sm" type="submit"><i class="fa fa-save"></i></button>
                </form>
              </h3>
              <small>
                <form action="{{ route('elections.update', $election->id) }}" method="post">
                  @csrf
                  @method('PUT')
                  <span>
                    {{ \Carbon\Carbon::parse($election->date_start)->format('F d, Y h:i A') }} - {{ \Carbon\Carbon::parse($election->date_end)->format('F d, Y h:i A') }}
                  </span>
                  <input id="reservationtime" type="text" name="validity" value="{{ \Carbon\Carbon::parse($election->date_start)->format('m/d/Y h:i A') }} - {{ \Carbon\Carbon::parse($election->date_end)->format('m/d/Y h:i A') }}" required="" style="display: none;">
                  &nbsp;&nbsp;&nbsp;
                  <i class="fa fa-edit edit-info" style="cursor: pointer; color: #0000EE"></i>
                  <button style="display: none;" class="btn btn-success btn-sm" type="submit"><i class="fa fa-save"></i></button>
                </form>
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
            <form action="{{ route('elections.update', $election->id) }}" method="post">
              @csrf
              <div class="card-body">
                  @method('PUT')
                  <textarea class="form-control elect-desc" name="description" required="">
                    {{ $election->description }}
                  </textarea>
                  <br>
              </div>
              <div class="card-footer">
                <button class="btn btn-primary btn-sm float-right" type="submit"><i class="fa fa-save"></i>&nbsp;&nbsp;Save and Close</button>
              </div>
            </form>
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
              <label class="btn bg-olive position-selector" data-id="{{ $value->id }}" data-name="{{ $value->name }}" data-number_elected="{{ $value->number_elected }}" data-filter="{{ "filter-".$value->id }}">
                <input type="radio" autocomplete="off"> {{ $value->name }} &nbsp; <span class="badge bg-success">{{ $value->number_elected }}</span>
              </label>
            @endforeach
          </div>
          <button class="btn btn-primary btn-sm float-right col-lg-2 col-md-2 col-sm-12 col-xs-12" data-toggle="modal" data-target="#new-position"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Add New Position</button>
          <!-- /.card -->
          <div class="table-responsive" style="margin-top: 10px; display: none;">
            <form action="" method="post">
              @csrf
              @method('PUT')

              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Position Name</th>
                    <th>Number Elected</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="position_name">
                      <span></span>
                      <input type="text" name="name" required="" placeholder="Position Name" class="form-control" style="display: none;">
                    </td>
                    <td class="number_elected">
                      <span></span>
                      <input type="number" name="number_elected" required="" placeholder="Number Elected" class="form-control" style="display: none;">
                    </td>
                    <td class="text-center">
                      <div class="btn-group">
                        <button class="btn btn-primary btn-sm edit"><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</button>
                        <button class="btn btn-success btn-sm save" type="submit" style="display: none;"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                        <button class="btn btn-warning btn-sm new-candidate" data-id="" style="color: #ffff" data-toggle="modal" data-target="#new-candidate"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Add Candidate</button>
                        <button class="btn btn-danger btn-sm"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Remove</button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </form>
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
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="modal fade" id="new-position">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add New Position</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('positions.store') }}" method="post">
          @csrf

          <input type="hidden" name="election_id" value="{{ encrypt($election->id) }}">
          <div class="modal-body">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Position Name <span style="color: red">*</span></label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="name" placeholder="Postion Name" value="{{ old('name') }}">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Number Elected <span style="color: red">*</span></label>
              <div class="col-sm-8">
                <input type="number" class="form-control" name="number_elected" placeholder="Number Elected" value="{{ old('number_elected') }}">
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-sm">Save and Close</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  <div class="modal fade" id="new-candidate">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title">Add New Candidate</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('candidates.store') }}" method="post" enctype="multipart/form-data">
          @csrf

          <input type="hidden" name="election_id" value="{{ encrypt($election->id) }}">
          <input type="hidden" name="position_id">
          <div class="modal-body">
            <div class="col-12 col-sm-12 col-md-12 d-flex align-items-stretch">
              <div class="card bg-light">
                  <div class="card-header text-muted border-bottom-0 nc-position">
                    
                  </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-3 col-form-label text-sm">Name</label>
                        <div class="col-sm-9">
                          <input class="form-control form-control-sm" type="text" placeholder="Candidate Name" name="name" required="">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-3 col-form-label text-sm">Degree</label>
                        <div class="col-sm-9">
                          <select class="form-control form-control-sm" name="degree_id" required="">
                            <option value="">Ex: Bachelor's</option>
                            @foreach($degree as $value)
                              <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-3 col-form-label text-sm">Area of Study</label>
                        <div class="col-sm-9">
                          <input class="form-control form-control-sm" type="text" placeholder="Ex: Computer Science" name="area_of_study" required="">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-3 col-form-label text-sm">Agenda</label>
                        <div class="col-sm-9">
                          <textarea class="form-control form-control-sm" name="agenda" required=""></textarea>
                        </div>
                      </div>

                    </div>
                    <div class="col-5 text-center">
                      <img src="{{ asset('dist/img/default-candidate.png') }}" alt="user-avatar" class="img-circle img-fluid change" style="cursor: pointer;" title="Click to change image">
                      <input type="file" name="image" hidden="" id="nc-img">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-sm">Save and Close</button>
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
  <!-- Froala -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/froala_editor.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/align.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/char_counter.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/code_beautifier.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/code_view.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/colors.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/draggable.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/emoticons.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/entities.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/file.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/font_size.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/font_family.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/fullscreen.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/image.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/image_manager.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/line_breaker.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/inline_style.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/link.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/lists.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/paragraph_format.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/paragraph_style.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/quick_insert.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/quote.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/table.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/save.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/url.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/video.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/help.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/print.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/third_party/spell_checker.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/special_characters.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/froala/js/plugins/word_paste.min.js') }}"></script>
  <!-- moment -->
  <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
  <!-- date-range-picker -->
  <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
  <!-- Page specific script -->
  <script type="text/javascript">
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })

    new FroalaEditor(".elect-desc", {
      theme: 'dark',
      heightMin: 150,
      key: "1C%kZV[IX)_SL}UJHAEFZMUJOYGYQE[\\ZJ]RAe(+%$==",
      attribution: false // to hide "Powered by Froala"
    });

    $('.all').on('click', function(){
      $('.table-responsive').hide()

      $('.animate__animated').each(function(){
          $(this).removeClass('animate__fadeOut')
          $(this).addClass('animate__pulse')
          $(this).show()
      })
    })

    $('.position-selector').off().on('click', function(){
      let id = $(this).data('id')
      let name = $(this).data('name')
      let number_elected = $(this).data('number_elected')
      let filter = $(this).data('filter')

      $('.position_name').children('span').text(name)
      $('.position_name').children('input').val(name)
      $('.number_elected').children('span').text(number_elected)
      $('.number_elected').children('input').val(number_elected)
      $('.table-responsive').show()
      $('.table-responsive').children().attr('action', '{{ route('positions.update', '') }}/'+id)
      $('#new-candidate').find('form').children('input[name="position_id"]').val(id)
      $('#new-candidate').find('form').find('.nc-position').text(name)

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

    $('button.edit').on('click', function(evt){
      evt.preventDefault();

      $(this).parent().parent().siblings('td').children('span').hide()
      $(this).parent().parent().siblings('td').children('input').show()
      $(this).siblings('button.save').show();
      $(this).hide();
    })

    $(document).on('click', '.new-candidate', function(evt){
      evt.preventDefault();
    })

    $('img.change').on('click', function(){
      $(this).siblings('input').click()
    })

    $('#nc-img').on('change', function(){
      if (event.target.files[0]) {
        $('img.change').attr("src", URL.createObjectURL(event.target.files[0]));
        return true;
      }
      $('img.change').attr("src", "{{ asset('dist/img/default-candidate.png') }}");
    })

    $('.edit-info').on('click', function(){
      $(this).hide()
      $(this).siblings('span').hide()
      $(this).siblings('input').show()
      $(this).siblings('button').show()
    })
    
  </script>
@endsection