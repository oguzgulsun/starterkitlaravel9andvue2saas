<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Burofi">
     <link rel="icon" type="image/png" href="/img/favicon.png">

    <title>{{env('APP_NAME')}} - Dashboard </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.9.55/css/materialdesignicons.min.css" integrity="sha512-vIgFb4o1CL8iMGoIF7cYiEVFrel13k/BkTGvs0hGfVnlbV6XjAA0M0oEHdWqGdAVRTDID3vIZPOHmKdrMAUChA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap">
    <style>
      *{
        font-family: "Dosis", sans-serif;
      }
      .card__title{
        text-transform: capitalize!important;
      }
       .logfotodiv .logfotozaman{
        background-color: black;
        padding: 2px;
      }
  
    </style>
    <meta name="theme-color" content="#7952b3">
  </head>
  <body>
   
        <div id="app">
            <app></app>
        </div>
    <script  src="{{ mix('js/app.js') }}" defer></script>
    <script> window.user = {!! json_encode($user) !!} ; </script>
</body>
</html>
