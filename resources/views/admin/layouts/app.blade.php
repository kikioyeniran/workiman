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
    <link rel="stylesheet" href="{{ asset('_home/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('_home/css/colors/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('_home/css/colors/wexir-gold.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('vendor/datatables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <style>
        .dataTables_filter {
            margin-bottom: 10px;
        }

        .dataTables_length label,
        .dataTables_filter label {
            display: flex;
            align-items: center;
        }

        .dataTables_length label select,
        .dataTables_filter input {
            margin: 0 10px 0 !important;
        }

        .contest-row-card {
            overflow: hidden;
        }

        .contest-row-card.top-rated {
            border: 2px solid var(--primary-color);
            /* border-right: 2px solid var(--primary-color); */
        }

        .contest-box-card .context-image-container {
            height: 200px;
            padding: 50px;
        }

        .contest-box-card .context-image-container img {
            /* height: 100%; */
            width: auto;
            margin-right: auto;
            margin-left: auto;
            object-fit: cover;
            max-height: inherit;
            object-position: center;
            padding: 20px;
        }

        textarea::placeholder,
        input::placeholder {
            color: #d0d0d0;
            font-weight: normal;
        }

        .status-strip {
            transform: rotate(90deg);
            /* position: absolute; */
            right: 0;
            top: 0;
            font-size: x-small;
            height: 23px;
            width: 160px;
            text-align: center;
            margin-right: -70px;
            margin-top: 70px;
            /* padding-left: 40px; */
            padding-top: 2px;
            text-transform: uppercase;
        }


    </style>

    @yield('page_styles')

</head>

<body class="gray">

    <!-- Wrapper -->
    <div id="wrapper">

        @include('admin.layouts.header')

        <!-- Dashboard Container -->
        <div class="dashboard-container">

            @include('admin.layouts.sidebar')


            <!-- Dashboard Content
 ================================================== -->
            <div class="dashboard-content-container" data-simplebar>
                <div class="dashboard-content-inner">

                    @yield('page_content')

                    @include('account.layouts.footer')

                </div>
            </div>
            <!-- Dashboard Content / End -->

        </div>
        <!-- Dashboard Container / End -->

    </div>
    <!-- Wrapper / End -->


    <!-- Apply for a job popup
================================================== -->
    <div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

        <!--Tabs -->
        <div class="sign-in-form">

            <ul class="popup-tabs-nav">
                <li><a href="#tab">Add Note</a></li>
            </ul>

            <div class="popup-tabs-container">

                <!-- Tab -->
                <div class="popup-tab-content" id="tab">

                    <!-- Welcome Text -->
                    <div class="welcome-text">
                        <h3>Do Not Forget 😎</h3>
                    </div>

                    <!-- Form -->
                    <form method="post" id="add-note">

                        <select class="selectpicker with-border default margin-bottom-20" data-size="7"
                            title="Priority">
                            <option>Low Priority</option>
                            <option>Medium Priority</option>
                            <option>High Priority</option>
                        </select>

                        <textarea name="textarea" cols="10" placeholder="Note" class="with-border"></textarea>

                    </form>

                    <!-- Button -->
                    <button class="button full-width button-sliding-icon ripple-effect" type="submit"
                        form="add-note">Add Note <i class="icon-material-outline-arrow-right-alt"></i></button>

                </div>

            </div>
        </div>
    </div>
    <!-- Apply for a job popup / End -->


    <!-- Scripts
================================================== -->
    <script src="{{ asset('_home/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('_home/js/jquery-migrate-3.0.0.min.js') }}"></script>
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

    <script src="{{ asset('vendor/datatables/datatables.min.js') }}"></script>

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
