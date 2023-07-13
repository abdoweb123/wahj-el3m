<div class="container-fluid">
    <div class="row">
        <!-- Left Sidebar start-->
        <div class="side-menu-fixed">
            <div class="scrollbar side-menu-bg">
                <ul class="nav navbar-nav side-menu" id="sidebarnav">
                    <!-- menu item Dashboard-->
                    <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">لوحة التحكم الرئيسية</li>


                    <li>
                        <a href="{{route('dashboard_teacher')}}" style="padding-bottom:30px;">
                            <div class="pull-left"><i class="ti-home"></i><span class="right-nav-text">لوحة التحكم</span>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('edit_teacher_profile')}}" style="padding-bottom:30px;">
                            <div class="pull-left"><i class="fas fa-cog"></i><span class="right-nav-text">إعدادات الملف الشخصي</span>
                            </div>
                        </a>
                    </li>


                    @if(auth('teacher')->user()->type == 1)
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#teachers">
                            <div class="pull-left"><i class="fas fa-users"></i><span class="right-nav-text">المدرسون</span>
                            </div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="teachers" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="{{route('get_all_teachers')}}"><i class='fas fa-user-plus'></i>عرض المدرسين</a></li>
                        </ul>
                    </li>
                    @endif

                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#courses">
                            <div class="pull-left"><i class="fas fa-video-camera"></i><span class="right-nav-text">الكورسات</span>
                            </div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="courses" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="{{route('courses.index')}}"><i class='fas fa-eye'></i>عرض الكورسات</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>

        <!-- Left Sidebar End-->

        <!--=================================
