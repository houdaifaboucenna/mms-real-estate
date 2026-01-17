@extends('admin.layouts.app')

@section('pageTitle',__('admin.overview'))


@section('content')

  <div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">

      <h1 class="app-page-title">{{ __('admin.overview') }}</h1>

      {{-- Stats --}}
      <div class="row g-4 mb-4">
        <div class="col-6 col-lg-3">
          <div class="app-card app-card-stat shadow-sm h-100">
            <div class="app-card-body p-3 p-lg-4">
              <h4 class="stats-type mb-1">{{ __('home.articles') }}</h4>
              <div class="stats-figure">{{ $posts->count() }}</div>
              <div class="stats-meta">
                published
              </div>
            </div><!--//app-card-body-->
            <a class="app-card-link-mask" href="#"></a>
          </div><!--//app-card-->
        </div><!--//col-->

        <div class="col-6 col-lg-3">
          <div class="app-card app-card-stat shadow-sm h-100">
            <div class="app-card-body p-3 p-lg-4">
              <h4 class="stats-type mb-1">{{ __('home.comments') }}</h4>
              <div class="stats-figure">{{ $comments->count() }}</div>
              <div class="stats-meta">
                received
              </div>
            </div><!--//app-card-body-->
            <a class="app-card-link-mask" href="#"></a>
          </div><!--//app-card-->
        </div><!--//col-->

        <div class="col-6 col-lg-3">
          <div class="app-card app-card-stat shadow-sm h-100">
            <div class="app-card-body p-3 p-lg-4">
              <h4 class="stats-type mb-1">{{ __('home.estates') }}</h4>
              <div class="stats-figure">{{ $estates->count() }}</div>
              <div class="stats-meta">
                open</div>
            </div><!--//app-card-body-->
            <a class="app-card-link-mask" href="#"></a>
          </div><!--//app-card-->
        </div><!--//col-->

        <div class="col-6 col-lg-3">
          <div class="app-card app-card-stat shadow-sm h-100">
            <div class="app-card-body p-3 p-lg-4">
              <h4 class="stats-type mb-1">{{ __('home.messages') }}</h4>
              <div class="stats-figure">{{ $contacts->count() }}</div>
              <div class="stats-meta">received</div>
            </div><!--//app-card-body-->
            <a class="app-card-link-mask" href="#"></a>
          </div><!--//app-card-->
        </div><!--//col-->
      </div>

      {{-- Charts --}}
      <div class="row g-4 mb-4">

          <div class="col-12 col-lg-6">
            <div class="app-card app-card-chart h-100 shadow-sm">
              <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                  <div class="col-auto">
                        <h4 class="app-card-title">{{ __('admin.estatescities') }}</h4>
                  </div><!--//col-->
                </div><!--//row-->
              </div><!--//app-card-header-->
              <div class="app-card-body p-3 p-lg-4">
                <div class="chart-container">
                  <canvas id="chart-doughnut" ></canvas>
                </div>
              </div><!--//app-card-body-->
            </div><!--//app-card-->
          </div><!--//col-->

          <div class="col-12 col-lg-6">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3">
                  <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                          <h4 class="app-card-title">{{ __('admin.estatestypes') }}</h4>
                    </div><!--//col-->
                  </div><!--//row-->
                </div><!--//app-card-header-->
                <div class="app-card-body p-3 p-lg-4">
                  <div class="chart-container">
                    <canvas id="canvas-barchart" ></canvas>
                  </div>
                </div>
              </div><!--//app-card-body-->
            </div><!--//app-card-->
          </div><!--//col-->

      </div>

    </div><!--//container-fluid-->
  </div>


@endsection

@section('scripts')
    <script>
      'use strict';

      /* Chart.js docs: https://www.chartjs.org/ */
      window.chartColors = {
        green: '#75c181',
        blue: '#5b99ea',
        red: '#eb4d4b',
        midblue: '#7ed6df',
        jelly: '#f0932b',
        turbo: '#f9ca24',
        cove: '#130f40',
        pink: '#be2edd',
        bgreen: '#2bcbba',
        gray: '#a9b5c9',
        text: '#252930',
        border: '#e7e9ed'
      };

      /* Random number generator for demo purpose */
      var randomDataPoint = function(){ return Math.round(Math.random()*10000)};

      // Doughnut Chart Demo
      var doughnutChartConfig = {
        type: 'doughnut',
        data: {
          datasets: [{
            data: [
              {{ $estates->where("city",1)->count() }},
              {{ $estates->where("city",2)->count() }},
              {{ $estates->where("city",3)->count() }},
              {{ $estates->where("city",4)->count() }},
              {{ $estates->where("city",5)->count() }},
              {{ $estates->where("city",6)->count() }},
              {{ $estates->where("city",7)->count() }},
              {{ $estates->where("city",8)->count() }},
              {{ $estates->where("city",9)->count() }},
              {{ $estates->where("city",10)->count() }},
              {{ $estates->where("city",11)->count() }},
            ],
            backgroundColor: [
              window.chartColors.green,
              window.chartColors.blue,
              window.chartColors.red,
              window.chartColors.midblue,
              window.chartColors.jelly,
              window.chartColors.turbo,
              window.chartColors.cove,
              window.chartColors.pink,
              window.chartColors.bgreen,
              window.chartColors.gray,
            ],
            label: 'Dataset 1'
          }],
          labels: [
            @foreach (App\Models\Estate::cities() as $city)
              '{{ $city }}',
            @endforeach
          ]
        },
        options: {
          responsive: true,
          legend: {
            display: true,
            position: 'left',
          },

          tooltips: {
            titleMarginBottom: 10,
            bodySpacing: 10,
            xPadding: 16,
            yPadding: 16,
            borderColor: window.chartColors.border,
            borderWidth: 1,
            backgroundColor: '#fff',
            bodyFontColor: window.chartColors.text,
            titleFontColor: window.chartColors.text,

            animation: {
              animateScale: true,
              animateRotate: true
            },

            /* Display % in tooltip - https://stackoverflow.com/questions/37257034/chart-js-2-0-doughnut-tooltip-percentages */
            callbacks: {
                      label: function(tooltipItem, data) {
                //get the concerned dataset
                var dataset = data.datasets[tooltipItem.datasetIndex];
                //calculate the total of this data set
                var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                return previousValue + currentValue;
                });
                //get the current items value
                var currentValue = dataset.data[tooltipItem.index];
                //calculate the precentage based on the total and current item, also this does a rough rounding to give a whole number
                var percentage = Math.floor(((currentValue/total) * 100)+0.5);

                return percentage + "%";
                },
                  },


          },
        }
      };

      // Chart.js Bar Chart Example
      var barChartConfig = {
        type: 'bar',

        data: {
          labels: ['App', 'Res', 'Commerce', 'Villa', 'Office', 'Hotel'],
          datasets: [{
            label: 'Total',
            backgroundColor: window.chartColors.green,
            borderColor: window.chartColors.green,
            borderWidth: 1,
            maxBarThickness: 16,

            data: [
              {{ $estates->where("type",1)->count() }},
              {{ $estates->where("type",2)->count() }},
              {{ $estates->where("type",3)->count() }},
              {{ $estates->where("type",4)->count() }},
              {{ $estates->where("type",5)->count() }},
              {{ $estates->where("type",6)->count() }},
            ]
          }]
        },
        options: {
          responsive: true,
          aspectRatio: 1.5,
          legend: {
            position: 'bottom',
            align: 'end',
          },
          title: {
            display: false,
          },
          tooltips: {
            mode: 'index',
            intersect: false,
            titleMarginBottom: 10,
            bodySpacing: 10,
            xPadding: 16,
            yPadding: 16,
            borderColor: window.chartColors.border,
            borderWidth: 1,
            backgroundColor: '#fff',
            bodyFontColor: window.chartColors.text,
            titleFontColor: window.chartColors.text,

          },
          scales: {
            xAxes: [{
              display: true,
              gridLines: {
                drawBorder: false,
                color: window.chartColors.border,
              },

            }],
            yAxes: [{
              display: true,
              gridLines: {
                drawBorder: false,
                color: window.chartColors.borders,
              },


            }]
          }

        }
      }

      // Generate charts on load
      window.addEventListener('load', function(){

        var doughnutChart = document.getElementById('chart-doughnut').getContext('2d');
        window.myDoughnut = new Chart(doughnutChart, doughnutChartConfig);

        var barChart = document.getElementById('canvas-barchart').getContext('2d');
        window.myBar = new Chart(barChart, barChartConfig);


      });

    </script>
@endsection
