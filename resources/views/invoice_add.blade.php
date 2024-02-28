<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Facturio - nowa faktura</title>
        <link rel="stylesheet" href="{{ asset('invoice_app/css/style.css') }}">
        <script src="{{ asset('invoice_app/js/script.js') }}"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>
    <body onload="/* addProduct(1) */">
    @include('navbar');
        <livewire:invoice-add />
    </body>
</html>
