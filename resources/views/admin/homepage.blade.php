@extends('layout.admin')

@section('stylesheets')
	<!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
@endsection

@section('content')
	<!-- Content Header (Page header) -->
	<div class="content-header">
	  <div class="container-fluid">
	    <div class="row mb-2">
	      <div class="col-sm-6">
	        <h1 class="m-0">Overview</h1>
	      </div><!-- /.col -->
	      <div class="col-sm-6">
	        <ol class="breadcrumb float-sm-right">
	          <li class="breadcrumb-item"><a href="#">Home</a></li>
	          <li class="breadcrumb-item active">Overview</li>
	        </ol>
	      </div><!-- /.col -->
	    </div><!-- /.row -->
	  </div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
	  <div class="container-fluid">
	    <!-- Small boxes (Stat box) -->
	    <div class="row">
    	  @php
  		  	$election = Helper::get_active_election();
  		  	$overview = Helper::get_hours($election);
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
	      <div class="col-lg-9 col-12">

	      	<!-- solid sales graph -->
	        <div class="card bg-gradient-info">
	          <div class="card-header border-0">
	            <h3 class="card-title">
	              <i class="fas fa-poll-h"></i>
	              Votes Traffic
	            </h3>

	            <div class="card-tools">
	              <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
	                <i class="fas fa-minus"></i>
	              </button>
	              <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
	                <i class="fas fa-times"></i>
	              </button>
	            </div>
	          </div>
	          <div class="card-body">
	            <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
	          </div>
	          <!-- /.card-body -->
	          <div class="card-footer bg-transparent">
	            <div class="row">
	              <div class="col-4 text-center">
	                <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60"
	                       data-fgColor="#39CCCC">

	                <div class="text-white">Mail-Orders</div>
	              </div>
	              <!-- ./col -->
	              <div class="col-4 text-center">
	                <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60"
	                       data-fgColor="#39CCCC">

	                <div class="text-white">Online</div>
	              </div>
	              <!-- ./col -->
	              <div class="col-4 text-center">
	                <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60"
	                       data-fgColor="#39CCCC">

	                <div class="text-white">In-Store</div>
	              </div>
	              <!-- ./col -->
	            </div>
	            <!-- /.row -->
	          </div>
	          <!-- /.card-footer -->
	        </div>
	        <!-- /.card -->
	      </div>
	      <!-- ./col -->
	      <div class="col-lg-3 col-12">
	        <!-- small box -->
	        <div class="small-box bg-success">
	          <div class="inner">
	            <h3>53<sup style="font-size: 20px">%</sup></h3>

	            <p>Participation</p>
	          </div>
	          <div class="icon">
	            <i class="ion ion-stats-bars"></i>
	          </div>
	          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
	        </div>
	        <!-- small box -->
	        <div class="small-box bg-info">
	          <div class="inner">
	            <h3>150</h3>

	            <p>Voters</p>
	          </div>
	          <div class="icon">
	            <i class="ion ion-bag"></i>
	          </div>
	          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
	        </div>
	        <!-- small box -->
	        <div class="small-box bg-warning">
	          <div class="inner">
	            <h3>44</h3>

	            <p>Teachers</p>
	          </div>
	          <div class="icon">
	            <i class="ion ion-person-add"></i>
	          </div>
	          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
	        </div>
	        <!-- small box -->
	        <div class="small-box bg-danger">
	          <div class="inner">
	            <h3>65</h3>

	            <p>Course</p>
	          </div>
	          <div class="icon">
	            <i class="ion ion-pie-graph"></i>
	          </div>
	          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
	        </div>
	        <!-- small box -->
	        <div class="small-box bg-danger">
	          <div class="inner">
	            <h3>65</h3>

	            <p>Position</p>
	          </div>
	          <div class="icon">
	            <i class="ion ion-pie-graph"></i>
	          </div>
	          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
	        </div>
	        <!-- small box -->
	        <div class="small-box bg-danger">
	          <div class="inner">
	            <h3>65</h3>

	            <p>Candidates</p>
	          </div>
	          <div class="icon">
	            <i class="ion ion-pie-graph"></i>
	          </div>
	          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
	        </div>
	      </div>
	      <!-- ./col -->
	    </div>
	    <!-- /.row -->
	  </div><!-- /.container-fluid -->
	</section>
	<!-- /.content -->
@endsection

@section('scripts')
	<!-- jQuery -->
	<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
	  $.widget.bridge('uibutton', $.ui.button)
	</script>
	<!-- Bootstrap 4 -->
	<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<!-- ChartJS -->
	<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
	<!-- Sparkline -->
	<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
	<!-- JQVMap -->
	<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
	<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
	<!-- jQuery Knob Chart -->
	<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
	<!-- daterangepicker -->
	<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
	<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
	<!-- Summernote -->
	<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
	<!-- overlayScrollbars -->
	<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
	<!-- AdminLTE App -->
	<script src="{{ asset('dist/js/adminlte.js') }}"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="{{ asset('dist/js/demo.js') }}"></script>
	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<script type="text/javascript">
		/*
		 * Author: Abdullah A Almsaeed
		 * Date: 4 Jan 2014
		 * Description:
		 *      This is a demo file used only for the main dashboard (index.html)
		 **/

		/* global moment:false, Chart:false, Sparkline:false */

		$(function () {
		  'use strict'

		  /* jQueryKnob */
		  $('.knob').knob()

		  // Sales graph chart
		  var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d')
		  // $('#revenue-chart').get(0).getContext('2d');

		  var salesGraphChartData = {
		    labels: [
		    	@foreach($overview[0] as $value)
		    	"{{ $value }}",
		    	@endforeach
		    ],
		    datasets: [
		      {
		        label: 'Digital Goods',
		        fill: false,
		        borderWidth: 2,
		        lineTension: 0,
		        spanGaps: true,
		        borderColor: '#efefef',
		        pointRadius: 3,
		        pointHoverRadius: 7,
		        pointColor: '#efefef',
		        pointBackgroundColor: '#efefef',
		        data: [
		        	@foreach($overview[1] as $value)
		    	{{ $value }},
		    	@endforeach
		        ]
		      }
		    ]
		  }

		  var salesGraphChartOptions = {
		    maintainAspectRatio: false,
		    responsive: true,
		    legend: {
		      display: false
		    },
		    scales: {
		      xAxes: [{
		        ticks: {
		          fontColor: '#efefef'
		        },
		        gridLines: {
		          display: false,
		          color: '#efefef',
		          drawBorder: false
		        }
		      }],
		      yAxes: [{
		        ticks: {
		          stepSize: 5000,
		          fontColor: '#efefef'
		        },
		        gridLines: {
		          display: true,
		          color: '#efefef',
		          drawBorder: false
		        }
		      }]
		    }
		  }

		  // This will get the first returned node in the jQuery collection.
		  // eslint-disable-next-line no-unused-vars
		  var salesGraphChart = new Chart(salesGraphChartCanvas, {
		    type: 'line',
		    data: salesGraphChartData,
		    options: salesGraphChartOptions
		  })
		})
	</script>
@endsection