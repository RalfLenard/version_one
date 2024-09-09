<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>Sixteen Clothing HTML Template</title>

    <!-- Bootstrap core CSS -->
    <link href="/user/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="/user/assets/css/fontawesome.css">
    <link rel="stylesheet" href="/user/assets/css/templatemo-sixteen.css">
    <link rel="stylesheet" href="/user/assets/css/owl.css">

    @include('user.ScriptAnimalAbuseReport')
    @include('user.ScriptHome')

   

</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <header class="" style="position: relative; top: 0;">
      <header class="" style="position: relative; top: 0;">
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <a class="navbar-brand" href="{{url('home')}}">
          <h2>Sixteen <em>Clothing</em></h2>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="{{url('home')}}">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="{{url('report/abuse')}}">Report Animal Abuse</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('user-messenger') }}">Message</a>
            </li>
            <ul class="navbar-nav ml-auto">
                            @include('user.Notification')
                        </ul>

            @if(Route::has('login'))
            @auth
            <!-- Display user profile and logout links -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name }}
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a>
                <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
              </div>
            </li>
            @else
            <li class="nav-item">
              <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('register') }}" class="btn btn-success btn-sm">Register</a>
            </li>
            @endauth
            @endif
          </ul>
        </div>
      </div>
    </nav>
    </header>

    <!-- Page Content -->
    <div class="full-height">
    <div class="form-container">
        <h2>Report Animal Abuse</h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('report.abuse.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
            </div>

            <h5 class="mt-4 mb-3">Upload Photos</h5>

            <div id="photoInputs">
                <div class="form-group">
                    <label for="photo1">Upload Photo 1</label>
                    <input type="file" class="form-control" id="photo1" name="photos[]" accept="image/*">
                </div>
            </div>

            <h5 class="mt-4 mb-3">Upload Videos</h5>

            <div id="videoInputs">
                <div class="form-group">
                    <label for="video1">Upload Video 1</label>
                    <input type="file" class="form-control" id="video1" name="videos[]" accept="video/*">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit Report</button>
        </form>
    </div>
</div>


    <!-- Bootstrap core JavaScript -->
    <script src="/user/vendor/jquery/jquery.min.js"></script>
    <script src="/user/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Additional Scripts -->
    <script src="/user/assets/js/custom.js"></script>
    <script src="/user/assets/js/owl.js"></script>
    <script src="/user/assets/js/slick.js"></script>
    <script src="/user/assets/js/isotope.js"></script>
    <script src="/user/assets/js/accordions.js"></script>

    <script language="text/Javascript"> 
        cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
        function clearField(t){                   //declaring the array outside of the
            if(!cleared[t.id]){                    //function to keep flag throughout 
                cleared[t.id] = 1;                //entire page and to use it throughout
                t.value=''; 
                t.style.color='#000';
            } 
        } 
    </script>

</body>

</html>
