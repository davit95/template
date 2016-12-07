<!DOCTYPE html>
<html>

<head>
    <title>Lock Screen | Josh Admin Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{ csrf_token() }}">
    <!-- global level css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <!-- end of global level css -->
    <!-- page level css -->
        <link href="{{ asset('assets/css/pages/lockscreen.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/fort.js/css/fort.css') }}" />
    <!-- end of page level css -->
</head>

<body>
    <div class="top">
        <div class="colors"></div>
    </div>
    <div class="container">
        <div class="login-container">
            <div id="output"></div>
            <div>
                @if(Sentinel::getUser()->pic)
                    <img class="img-responsive img-circle" src="{!! url('/').'/uploads/users/'.Sentinel::getUser()->pic !!}" alt="profile pic">
                @else
                    <img src="http://api.adorable.io/avatars/54/{!! Sentinel::getUser()->email !!}"
                         alt="img" class="img-circle img-bor"/>
                @endif
            </div>
            <div class="form-box">
                <form method="POST" name="screen">
                    <div class="form">
                        <p class="form-control-static user_name_max">{{Sentinel::getUser()->first_name}}</p>
                        <input type="password" name="user"  id="password" class="form-control" placeholder="Password">
                        <button class="btn btn-info btn-block login" id="index" type="submit">GO</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal fade" id="passwordErrorModal" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Password Error</h4>
                    </div>
                    <div class="modal-body">
                        <p>You entered a wrong password</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </div>
    <!-- global js -->
    <script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/holder.js') }}"></script>
    <!-- end of global js -->
    <!-- beginning of page level js-->
    <script src="{{ asset('assets/vendors/fort.js/js/fort.js') }}"></script>
    {{--<script src="{{ asset('assets/js/pages/lockscreen.js') }}"></script>--}}
    <script>Fort.gradient();</script>
    <script>
        $(document).ready(function(){
//            var password = $("#password").val();
            /* var password = $("#pwd").val();
             alert(password);*/
            $('button[type="submit"]').click(function(e) {
                e.preventDefault();
                if ( $("#password").val() == "") {
                    //$("body").scrollTo("#output");
                    $("#output").addClass("alert alert-danger").text('Please enter password');

                }
                else {
                    //$("body").scrollTo("#output");
                    $("#output").addClass("alert alert-success animated fadeInUp user_name_max2").text('Welcome ' + '{!! Sentinel::getUser()->first_name !!}');
                    $.ajax({
                        type: "POST",
                        url: "{{route('lockscreen')}}",
                        data: {password: $("#password").val(), _token: $('meta[name="_token"]').attr('content')},
                        success: function (result) {
                            if (result == 'error') {
                                $('#passwordErrorModal').modal();
                            }
                            else {
                                window.location.href = '../../admin';
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.responseText);
                        }
                    });
                }
                //show avatar
                $(".avatar").css({
                    "background-image":  "url('../../assets/img/authors/avatar3.jpg')"
                });
            });
        });
    </script>
    <!-- end of page level js-->
</body>
</html>
