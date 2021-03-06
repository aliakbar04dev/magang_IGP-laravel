<!DOCTYPE html>
<html>
    <head>
        <title>{{ config('app.env', 'local') === 'production' ? config('app.name', 'Laravel') : config('app.name', 'Laravel').' TRIAL' }}</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato', sans-serif;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            {{-- <div>
                <center>
                    <h1><strong>SILAHKAN AKSES PORTAL MELALUI</strong> <a href="https://vendor.igp-astra.co.id">https://vendor.igp-astra.co.id</a></h1>
                </center>
            </div> --}}
            <div class="content">
                <img src="{{ asset('images/maintenance.png') }}" alt="Maintenance">
            </div>
        </div>
    </body>
</html>