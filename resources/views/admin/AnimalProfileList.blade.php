<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Panel - Animal Profiles</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="/admin/assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="/admin/assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="/admin/assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

     <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
     <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Admin Panel</a> 
            </div>
            <div style="color: white; padding: 15px 50px 5px 50px; float: right; font-size: 16px;"> 
                @if(Route::has('login'))
                    @auth
                        <x-app-layout></x-app-layout>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-success btn-sm">Register</a>
                    @endauth
                @endif
            </div>
        </nav>   
        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li class="text-center">
                        <img src="/admin/assets/img/find_user.png" class="user-image img-responsive"/>
                    </li>
                    <li>
                        <a href="{{url('home')}}"> Dashboard</a>
                    </li>
                    <li>
                        <a class="active-menu" href="{{ url('animal-profiles') }}"> Animal List</a>
                    </li>
                    <li>
                        <a href="{{ url('adoption-requests') }}"> Adoption Request</a>
                    </li>
                    <li>
                        <a href="{{ url('animal-abuse-reports') }}"> Animal Report</a>
                    </li>
                    <li>
                        <a href="{{ url('approved-requests') }}"> Set Meeting</a>
                    </li>
                    <li>
                        <a href="{{ url('admin-messenger') }}">Messages</a>
                    </li>
                    <li>
                        <a href="{{ url('appointments') }}"> Meeting Scheduled</a>
                    </li>
                    <li>
                        <a href="{{ url('rejected-Form') }}">Rejected Form</a>
                    </li>
                </ul>
            </div>
        </nav>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Animal Profiles</div>
                            <div class="panel-heading">
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#uploadModal">Add Animal</button>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Age</th>
                                                <th>Medical History</th>
                                                <th>Profile Picture</th>
                                                <th>Update</th>
                                                <th>Delete</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($animalProfiles as $animal)
                                                <tr class="odd gradeX">
                                                    <td>{{ $animal->name }}</td>
                                                    <td>{{ $animal->description }}</td>
                                                    <td>{{ $animal->age }}</td>
                                                    <td>{{ $animal->medical_records }}</td>
                                                    <td>
                                                        <img height="80px" width="100px" src="{{ Storage::url($animal->profile_picture) }}" class="card-img-top" alt="{{ $animal->name }}">
                                                    </td>
                                                    <td>
                                                        <!-- Update Button -->
                                                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#updateModal{{ $animal->id }}">Update</button>
                                                    </td>
                                                    <td>
                                                        <!-- Delete Button -->
                                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $animal->id }}">Delete</button>
                                                    </td>
                                                    
                                                </tr>

                                                <!-- Update Modal -->
                                                <div class="modal fade" id="updateModal{{ $animal->id }}" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel{{ $animal->id }}">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title" id="updateModalLabel{{ $animal->id }}">Update Animal Profile</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ url('update-animal', $animal->id) }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <label for="name">Name</label>
                                                                        <input type="text" class="form-control" name="name" value="{{ $animal->name }}" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="description">Description</label>
                                                                        <textarea class="form-control" name="description" required>{{ $animal->description }}</textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="age">Age</label>
                                                                        <input type="number" class="form-control" name="age" value="{{ $animal->age }}" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="medical_records">Medical History</label>
                                                                        <textarea class="form-control" name="medical_records" required>{{ $animal->medical_records }}</textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="profile_picture">Profile Picture</label>
                                                                        <input type="file" class="form-control" name="profile_picture">
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="deleteModal{{ $animal->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $animal->id }}">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title" id="deleteModalLabel{{ $animal->id }}">Delete Confirmation</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete this profile?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form action="{{ url('delete-animal', $animal->id) }}" method="POST">
                                                                    @csrf
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                            <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                                <h4 class="modal-title" id="uploadModalLabel">Upload New Animal Profile</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('animal-profiles.store') }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <label for="name">Name</label>
                                                                        <input type="text" class="form-control" name="name" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="description">Description</label>
                                                                        <textarea class="form-control" name="description" required></textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="age">Age</label>
                                                                        <input type="number" class="form-control" name="age" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="medical_records">Medical History</label>
                                                                        <textarea class="form-control" name="medical_records" required></textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="profile_picture">Profile Picture</label>
                                                                        <input type="file" class="form-control" name="profile_picture" required>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary">Upload</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>












                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- SCRIPTS - AT THE BOTTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="/admin/assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="/admin/assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="/admin/assets/js/jquery.metisMenu.js"></script>
    <!-- DATA TABLE SCRIPTS -->
    <script src="/admin/assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="/admin/assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTables-example').dataTable();
        });
    </script>
    <!-- CUSTOM SCRIPTS -->
    <script src="/admin/assets/js/custom.js"></script>
    

</body>
</html>
