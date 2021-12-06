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

<!-- Message of successful UPDATED record -->
<p class="">{{session('mssg')}}</p>

<!-- Displaying details -->
<label for="title" class="card-title text-primary">Memo title: </label>
    <p class="card-text">{{ $memo->title }}</p>
<label for="desc">Description: </label>
    <p>{{ $memo->short_desc }}</p>
<label for="postDate">Posted on: </label>
    <p>{{ $memo->updated_at }}</p>
<label for="effDate">Effectivity Date: </label>
    <p>{{ $memo->effectivity_date }}</p>
<label for="issDate">Issued Date: </label>
    <p>{{ $memo->issued_date }}</p>
<img src="{{ asset('storage/memoFiles/'. $memo->file_path )}}" height="500px;" width="500px;" alt="">

<!-- Delete memo link -->
<form action="/memos/show/{{ $memo->memo_id }}" method="POST">
    @csrf
    @method('DELETE')
    <button>Delete</button>
</form>

<!-- Update memo link -->
<a href="/memos/edit/{{ $memo->memo_id }}">
    <button>Edit</button>
</a>
</body>

</html>