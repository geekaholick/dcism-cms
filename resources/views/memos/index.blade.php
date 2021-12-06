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

<div class="container">
  <!-- Link for creating a new memo -->
  <a href="/memos/create">
    <button>New memo</button>
  </a>
  <!-- Message of successful STORED or DELETED record -->
  <p class="">{{session('mssg')}}</p>

  <!-- Retrieving all data from the database -->
  <h1>Memo List</h1>
  @if(count($memos) < 1)
    <h3>No memos found</h3>
  @else
    @foreach($memos as $memo)
      <div class="card border-primary h-100">
        <div class="card-body d-flex flex-column align-items-start">
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

          <a href="{{'/memos/show/' . $memo->memo_id }}" class="button">
            <button>View</button>
          </a>
        </div>
      </div>
    @endforeach
  @endif
</div>

</body>

</html>