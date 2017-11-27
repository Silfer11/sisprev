<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta id="token" name="token" value="{{csrf_token()}}">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    <link href="https://unpkg.com/vuetify/dist/vuetify.min.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <title>SisPrev</title>
  </head>
  <body>
      <div id='app'>
        <receitas></receitas>
      </div>
  </body>
</html>

<script src="/js/app.js"></script>
<script src="https://unpkg.com/vuetify/dist/vuetify.js"></script>
