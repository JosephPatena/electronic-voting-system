@extends('layout.admin')

@section('stylesheets')
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
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="{{ asset('plugins/bs-stepper/css/bs-stepper.min.css') }}">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="{{ asset('plugins/dropzone/min/dropzone.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
@endsection

@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Create New Election</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active">Create New Election</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- SELECT2 EXAMPLE -->
      <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title">Create New Election Form</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <form action="{{ route('elections.store') }}" method="post">
        @csrf
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Election Name <span style="color: red">*</span></label>
                <input type="text" class="form-control" placeholder="Election Name" name="name" required="" value="{{ old('name') }}">
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>Details <span style="color: red">*</span></label>
                <textarea class="form-control elect-desc" name="description" required="" value="{{ old('description') }}">
                </textarea>
              </div>
              <!-- /.form-group -->
              <!-- Date and time range -->
              <div class="form-group">
                <label>Election Validity <span style="color: red">*</span></label>

                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                  </div>
                  <input type="text" class="form-control float-right" id="reservationtime" name="validity" required="" value="{{ old('validity') }}">
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
              <div class="form-group positions">
                <label style="width: 100%">
                  Position <span style="color: red">*</span>
                  <button class="btn btn-primary btn-xs float-right new-row"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;New Row</button>
                </label>
                <div class="input-group" style="margin-bottom: 10px" id="original">
                    <input type="text" class="form-control" placeholder="Position Name" name="position_name[]" required="">
                    <div class="input-group-append">
                        <input type="number" class="form-control" placeholder="Number Elected" name="number_elected[]" required="">
                    </div>
                    <i class="fa fa-times-circle remove-row" style="display: none; color: red; margin-top: 10px; margin-left: 10px; cursor: pointer;"></i>
                </div>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button class="btn btn-success btn-sm float-right" type="submit">Save and Continue Editing</button>
        </div>
        </form>
      </div>
      <!-- /.card -->
    </div>
  </section>
@endsection

@section('scripts')
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
  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Select2 -->
  <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
  <!-- Bootstrap4 Duallistbox -->
  <script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
  <!-- InputMask -->
  <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
  <!-- date-range-picker -->
  <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
  <!-- bootstrap color picker -->
  <script src="{{ asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
  <!-- Bootstrap Switch -->
  <script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
  <!-- BS-Stepper -->
  <script src="{{ asset('plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
  <!-- dropzonejs -->
  <script src="{{ asset('plugins/dropzone/min/dropzone.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('dist/js/demo.js') }}"></script>
  <!-- Page specific script -->
  <script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })

      //Datemask dd/mm/yyyy
      $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
      //Datemask2 mm/dd/yyyy
      $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
      //Money Euro
      $('[data-mask]').inputmask()

      //Date range picker
      $('#reservationdate').datetimepicker({
          format: 'L'
      });
      //Date range picker
      $('#reservation').daterangepicker()
      //Date range picker with time picker
      $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
          format: 'MM/DD/YYYY hh:mm A'
        }
      })
      //Date range as a button
      $('#daterange-btn').daterangepicker(
        {
          ranges   : {
            'Today'       : [moment(), moment()],
            'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month'  : [moment().startOf('month'), moment().endOf('month')],
            'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate  : moment()
        },
        function (start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        }
      )

      //Timepicker
      $('#timepicker').datetimepicker({
        format: 'LT'
      })

      //Bootstrap Duallistbox
      $('.duallistbox').bootstrapDualListbox()

      //Colorpicker
      $('.my-colorpicker1').colorpicker()
      //color picker with addon
      $('.my-colorpicker2').colorpicker()

      $('.my-colorpicker2').on('colorpickerChange', function(event) {
        $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
      });

      $("input[data-bootstrap-switch]").each(function(){
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
      });

    })

    new FroalaEditor(".elect-desc", {
      theme: 'dark',
      heightMin: 150,
      key: "1C%kZV[IX)_SL}UJHAEFZMUJOYGYQE[\\ZJ]RAe(+%$==",
      attribution: false // to hide "Powered by Froala"
    });

    $('button.new-row').on('click', function(evt){
      evt.preventDefault();

      $('#original').children().css('display', 'inline')
      var form_group = $('#original').clone()

      $('div.positions').append(form_group)
    })

    $(document).on('click', 'i.remove-row', function(evt){
      $(this).parent().remove()
    })
  </script>
@endsection