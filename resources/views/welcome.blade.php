<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name')}}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <frame-options policy="SAMEORIGIN"/>
</head>
<body>
    <div id="app">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <chart-component title="Currencies" url="{{route('currencies.get')}}"></chart-component>
                </div>
                <div class="col-md-6">
                    <chart-component title="Crypto" url="{{route('crypto.get')}}"></chart-component>

                </div>
            </div>

            <div class="row">

            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
</body>
</html>
