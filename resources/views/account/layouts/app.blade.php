<!doctype html>
<html lang="en">

<head>

    <!-- Basic Page Needs
================================================== -->
    <title>{{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="{{ asset('logo/logo-icon.png') }}" type="image/jpeg">

    <!-- CSS
================================================== -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('_home/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('_home/css/colors/wexir-gold.css') }}">

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}?{{ time() }}">

    <link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet" />

    <style>
        @media(max-width: 1500px) {
            .context-image-container img {
                max-width: 100px;
                /* max-height: 100px; */
            }

            .contest-row-card-right {
                max-width: 150px;
                padding: 20px 5px;
            }

            .contest-row-card-description {
                margin-bottom: 0;
            }

            .contest-row-card-right-each {
                margin-bottom: 0;
            }

            .contest-row-card-right-each i {
                margin-right: 5px;
            }

            .contest-row-card-title {
                font-size: 17px;
                margin-bottom: 0;
            }

            .context-row-card-tag-each {
                padding: 0 5px;
            }
        }

    </style>

    @yield('page_styles')
</head>

<body class="gray">

    <!-- Wrapper -->
    <div id="wrapper">

        @include('account.layouts.header')

        <div class="dashboard-container">

            @include('account.layouts.sidebar')

            <div class="dashboard-content-container" data-simplebar>
                <div class="dashboard-content-inner">

                    {{-- @include('account.layouts.alerts') --}}

                    <div class=" min-vh-100">
                        @yield('page_content')
                    </div>

                    @include('account.layouts.footer')

                </div>
            </div>

        </div>

    </div>

    @include('layouts.account_login_popup')

    @yield('page_popups')

    <!-- Scripts
================================================== -->
    <script src="{{ asset('_home/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('_home/js/jquery-migrate-3.0.0.min.js') }}"></script>
    <script src="{{ asset('vendor/popper/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('_home/js/mmenu.min.html') }}"></script>
    <script src="{{ asset('_home/js/tippy.all.min.js') }}"></script>
    <script src="{{ asset('_home/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('_home/js/bootstrap-slider.min.js') }}"></script>
    <script src="{{ asset('_home/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('_home/js/snackbar.js') }}"></script>
    <script src="{{ asset('_home/js/clipboard.min.js') }}"></script>
    <script src="{{ asset('_home/js/counterup.min.js') }}"></script>
    <script src="{{ asset('_home/js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset('_home/js/slick.min.js') }}"></script>
    <script src="{{ asset('_home/js/custom.js') }}"></script>

    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>

    @yield('page_scripts')

    <!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->
    <script>
        // Snackbar for user status switcher
        $('#snackbar-user-status label').click(function() {
            Snackbar.show({
                text: 'Your status has been changed!',
                pos: 'bottom-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 3000,
                textColor: '#fff',
                backgroundColor: '#383838'
            });
        });

    </script>

    @include('layouts.snackbar_alerts')

    <!-- Chart.js // documentation: http://www.chartjs.org/docs/latest/ -->
    <script src="js/chart.min.js"></script>
    <script>
        Chart.defaults.global.defaultFontFamily = "Nunito";
        Chart.defaults.global.defaultFontColor = '#888';
        Chart.defaults.global.defaultFontSize = '14';

        var ctx = document.getElementById('chart').getContext('2d');

        var chart = new Chart(ctx, {
            type: 'line',

            // The data for our dataset
            data: {
                labels: ["January", "February", "March", "April", "May", "June"],
                // Information about the dataset
                datasets: [{
                    label: "Views",
                    backgroundColor: 'rgba(42,65,232,0.08)',
                    borderColor: '#2a41e8',
                    borderWidth: "3",
                    data: [196, 132, 215, 362, 210, 252],
                    pointRadius: 5,
                    pointHoverRadius: 5,
                    pointHitRadius: 10,
                    pointBackgroundColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointBorderWidth: "2",
                }]
            },

            // Configuration options
            options: {

                layout: {
                    padding: 10,
                },

                legend: {
                    display: false
                },
                title: {
                    display: false
                },

                scales: {
                    yAxes: [{
                        scaleLabel: {
                            display: false
                        },
                        gridLines: {
                            borderDash: [6, 10],
                            color: "#d8d8d8",
                            lineWidth: 1,
                        },
                    }],
                    xAxes: [{
                        scaleLabel: {
                            display: false
                        },
                        gridLines: {
                            display: false
                        },
                    }],
                },

                tooltips: {
                    backgroundColor: '#333',
                    titleFontSize: 13,
                    titleFontColor: '#fff',
                    bodyFontColor: '#fff',
                    bodyFontSize: 13,
                    displayColors: false,
                    xPadding: 10,
                    yPadding: 10,
                    intersect: false
                }
            },


        });

    </script>

</body>

</html>
