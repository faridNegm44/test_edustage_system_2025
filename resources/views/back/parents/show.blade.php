@extends('back.layouts.app')

@section('title')
    {{ $pageNameAr }} {{ $find->TheName0 }}
@endsection

@section('header')
    
@endsection

@section('footer')  
    <script>
        $("body").addClass('sidenav-toggled');
    </script>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">{{ $pageNameAr }} {{ $find->TheName0 }}</h4>
                </div>
            </div>
            
        </div>
        <!-- breadcrumb -->

        <!-- row -->
        <div class="row row-sm">
            <div class="col-lg-4">
                <div class="card mg-b-20">
                    <div class="card-body">
                        <div class="pl-0">
                            <div class="main-profile-overview">
                                <div class="main-img-user profile-user">
                                    <img alt="" src="{{ asset('back') }}/assets/img/faces/6.jpg">
                                </div>
                                <div class="d-flex justify-content-between mg-b-20">
                                    <div>
                                        <h5 class="">{{ $find->TheName0 }}</h5>
                                        <p class="main-profile-name-text" style="font-size: 11px !important;">{{ $find->TheEmail }}</p>
                                    </div>
                                </div>
                                <h6>ملاحظات</h6>
                                <div class="main-profile-bio">
                                    {{ $find->TheNotes ? $find->TheNotes :  'لاتوجد ملاحظات'}}
                                </div><!-- main-profile-bio -->
                                
                                
                                <hr class="mg-y-30">
                                <label class="main-content-label tx-13 mg-b-20">التواصل الإجتماعي</label>
                                <div class="main-profile-social-list">
                                    <div class="media">
                                        <div class="media-icon bg-primary-transparent text-primary">
                                            <i class="icon ion-logo-facebook"></i>
                                        </div>
                                        <div class="media-body">
                                            <span>facebook</span> <a href="">facebook.com</a>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div><!-- main-profile-overview -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row row-sm">
                    <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                        <div class="card ">
                            <div class="card-body">
                                <div class="counter-status d-flex md-mb-0">
                                    <div class="counter-icon bg-primary-transparent">
                                        <i class="fa fa-users text-primary"></i>
                                    </div>
                                    <div class="ml-auto text-center">
                                        <h5 class="tx-13">عدد الطلاب</h5>
                                        <h2 class="mb-0 tx-22 mb-1 mt-1">3</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                        <div class="card ">
                            <div class="card-body">
                                <div class="counter-status d-flex md-mb-0">
                                    <div class="counter-icon bg-danger-transparent">
                                        <i class="fa fa-layer-group text-danger"></i>
                                    </div>
                                    <div class="ml-auto text-center">
                                        <h5 class="tx-13">عدد الجروبات</h5>
                                        <h2 class="mb-0 tx-22 mb-1 mt-1">10</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                        <div class="card ">
                            <div class="card-body">
                                <div class="counter-status d-flex md-mb-0">
                                    <div class="counter-icon bg-success-transparent">
                                        <i class="icon-rocket text-success"></i>
                                    </div>
                                    <div class="ml-auto text-center">
                                        <h5 class="tx-13">اخري</h5>
                                        <h2 class="mb-0 tx-22 mb-1 mt-1">5</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="tabs-menu ">
                            <!-- Tabs -->
                            <ul class="nav nav-tabs profile navtab-custom panel-tabs">
                                <li class="active">
                                    <a href="#home" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i class="las la-user-circle tx-16 mr-1"></i></span> <span class="hidden-xs">ABOUT ME</span> </a>
                                </li>
                                <li class="">
                                    <a href="#profile" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="las la-images tx-15 mr-1"></i></span> <span class="hidden-xs">GALLERY</span> </a>
                                </li>
                                <li class="">
                                    <a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="las la-cog tx-16 mr-1"></i></span> <span class="hidden-xs">SETTINGS</span> </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content border-left border-bottom border-right border-top-0 p-4">
                            <div class="tab-pane active" id="home">
                                <h4 class="tx-15 text-uppercase mb-3">BIOdata</h4>
                                <p class="m-b-5">Hi I'm Petey Cruiser,has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt.Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim.</p>
                                <div class="m-t-30">
                                    <h4 class="tx-15 text-uppercase mt-3">Experience</h4>
                                    <div class=" p-t-10">
                                        <h5 class="text-primary m-b-5 tx-14">Lead designer / Developer</h5>
                                        <p class="">websitename.com</p>
                                        <p><b>2010-2015</b></p>
                                        <p class="text-muted tx-13 m-b-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                    </div>
                                    <hr>
                                    <div class="">
                                        <h5 class="text-primary m-b-5 tx-14">Senior Graphic Designer</h5>
                                        <p class="">coderthemes.com</p>
                                        <p><b>2007-2009</b></p>
                                        <p class="text-muted tx-13 mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="profile">
                                <div class="row">
                                  two tab
                                </div>
                            </div>
                            <div class="tab-pane" id="settings">
                                <form role="form">
                                    <div class="form-group">
                                        <label for="FullName">Full Name</label>
                                        <input type="text" value="John Doe" id="FullName" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="Email">Email</label>
                                        <input type="email" value="first.last@example.com" id="Email" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="Username">Username</label>
                                        <input type="text" value="john" id="Username" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="Password">Password</label>
                                        <input type="password" placeholder="6 - 15 Characters" id="Password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="RePassword">Re-Password</label>
                                        <input type="password" placeholder="6 - 15 Characters" id="RePassword" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="AboutMe">About Me</label>
                                        <textarea id="AboutMe" class="form-control">Loren gypsum dolor sit mate, consecrate disciplining lit, tied diam nonunion nib modernism tincidunt it Loretta dolor manga Amalia erst volute. Ur wise denim ad minim venial, quid nostrum exercise ration perambulator suspicious cortisol nil it applique ex ea commodore consequent.</textarea>
                                    </div>
                                    <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row closed -->


    </div>    
@endsection

