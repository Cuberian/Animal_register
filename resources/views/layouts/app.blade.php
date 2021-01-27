<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
            <script src="https://use.fontawesome.com/b512b58eb1.js"></script>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.13.3/dist/sweetalert2.min.css">
        </head>
    <body>
        <div id="app">
            <v-app>
                <navbar></navbar>
                <v-sheet class="mt-16" height="80vh">
                    @yield('content-body')
                </v-sheet>
            </v-app>
        </div>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
