<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- <link rel="icon" href="<%= BASE_URL %>favicon.ico"> -->

  <title>Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template</title>

  <!-- Splash Screen/Loader Styles -->
  <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/loader.css')) }}" />

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">

  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ asset('images/logo/favicon.png') }}">

  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap"
    rel="stylesheet">
</head>

<body>

<!-- New memo form -->
<h1>Create a new memo</h1>
<form action="/memos" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="title">Memo title:</label>
        <input type="text" name="title" id="title"><br>
    <label for="desc">Short description:</label>
        <input type="text" name="desc" id="desc"><br>
    <label for="effDate">Effectivity date:</label>
        <input type="date" name="effDate" id="effDate"><br>
    <label for="issDate">Issued date</label>
        <input type="date" name="issDate" id="issDate"><br>
    <label for="file">Upload memo: </label>
        <input type="file" name="file" id="file"><br>

    <input type="submit" name="submit" id="submit" value="Create">
</form>

</body>

</html>