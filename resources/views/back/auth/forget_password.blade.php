<!doctype html>
<html lang="en">


<!-- Mirrored from skote-v-light.codeigniter.themesbrand.com/auth-login-2 by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 11 Sep 2021 12:23:42 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<!-- /Added by HTTrack -->

<head>

    <meta charset="utf-8" />
    <title>
        @lang('app.Reset Password')
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('front') }}/assets/images/favicon.ico">

    <!-- owl.carousel css -->
    <link rel="stylesheet" href="{{ url('back') }}/assets/libs/owl.carousel/assets/owl.carousel.min.css">

    <link rel="stylesheet" href="{{ url('back') }}/assets/libs/owl.carousel/assets/owl.theme.default.min.css">

    <!-- Bootstrap Css -->
    <link href="{{ url('back') }}/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ url('back') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ url('back') }}/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />


    <style>
        .auth-full-bg .bg-overlay{
            background-image: url("{{ url('back/images/settings/reset4.jpg') }}");
            /* background-image: none; */
            /* background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center; */
        }
    </style>

</head>

<body class="auth-body-bg">

    <div>
        <div class="container-fluid p-0">
            <div class="row g-0">

                <div class="col-xl-8">
                    <div class="auth-full-bg pt-lg-5 p-4">
                        <div class="w-100">
                            <div class="bg-overlay"></div>
                            <div class="d-flex h-50 flex-column">

                                <div class="p-4 mt-auto">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-7">
                                            <div class="text-center" style="margin-top: 140px;">
                                                <h4 class="mb-3" style="color: #FFF;">
                                                    <span style="padding: 3px 0px 3px 3px;margin: 0px 5px;"> R-Plus </span> For Software
                                                </h4>
                                                <div dir="ltr">
                                                    <div>
                                                        <div class="item">
                                                            <div class="py-3">
                                                                <p class="font-size-16 mb-4" style="color:#FFF;background: #2c2c2c;padding: 10px;opacity: .5;width: 350px;margin: 0px auto">
                                                                    @lang('app.Enter your Email and <br> instructions will be sent to you')
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->

                <div class="col-xl-4">
                    <div class="auth-full-page-content p-md-5 p-4">
                        <div class="w-100">

                            <div class="d-flex flex-column h-100">
                                <div class="mb-4 mb-md-5">
                                    <a href="index.html" class="d-block auth-logo">
                                        <img src="{{ url('back') }}/assets/images/logo-dark.png" alt="" height="18" class="auth-logo-dark">
                                        <img src="{{ url('back') }}/assets/images/logo-light.png" alt="" height="18" class="auth-logo-light">
                                    </a>
                                </div>
                                <div class="my-auto">

                                    <div>
                                        <h5 class="text-danger">@lang('app.Reset Password') !</h5>
                                        <p class="text-muted">@lang('app.Reset Password with R-Plus Work Style').</p>
                                    </div>

                                    <br>

                                    <div class="mt-4">
                                        <form action="http://skote-v-light.codeigniter.themesbrand.com/">

                                            <div class="mb-3">
                                                <label for="email" class="form-label">@lang('app.email')</label>
                                                <input type="email" class="form-control" id="email" placeholder="@lang('app.email')">
                                            </div>

                                            <div class="mt-3 d-grid">
                                                <button class="btn btn-primary waves-effect waves-light" type="submit">@lang('app.Reset')</button>
                                            </div>
                                        </form>
                                        <div class="mt-5 text-center">
                                            <p>@lang('app.Remember It') ? <a href="{{ url('admin/login') }}" class="fw-medium text-primary"> @lang('app.Sign In here')</a> </p>
                                        </div>

                                    </div>
                                </div>

                                <div class="mt-4 mt-md-5 text-center">
                                    <p class="mb-0">©
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script>  R-Plus For Software <i class="mdi mdi-heart text-danger"></i></p>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container-fluid -->
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ url('back') }}/assets/libs/jquery/jquery.min.js"></script>
    <script src="{{ url('back') }}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ url('back') }}/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="{{ url('back') }}/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ url('back') }}/assets/libs/node-waves/waves.min.js"></script>
    <!-- owl.carousel js -->
    <script src="{{ url('back') }}/assets/libs/owl.carousel/owl.carousel.min.js"></script>

    <!-- auth-2-carousel init -->
    <script src="{{ url('back') }}/assets/js/pages/auth-2-carousel.init.js"></script>

    <!-- App js -->
    <script src="{{ url('back') }}/assets/js/app.js"></script>

</body>


<!-- Mirrored from skote-v-light.codeigniter.themesbrand.com/auth-login-2 by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 11 Sep 2021 12:23:43 GMT -->

</html>
