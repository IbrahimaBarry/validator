<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/app.css">

    </head>
    <body>
        
        <div id="app">

            @include('layouts.header')
            <section class="section">
                <div class="container">

                    <router-view></router-view>

                </div>
            </section>
            
            <Notification message="une notification"></Notification>

        </div>

        

        
        <script src="js/app.js"></script>

        <!-- <script>
            iziToast.info({
                title: 'Hello',
                message: 'Welcome!',
                position: 'topCenter'
            });
        </script> -->
    </body>
</html>
