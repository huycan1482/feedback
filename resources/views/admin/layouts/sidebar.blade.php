<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="./backend/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        {{-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i
                            class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form> --}}
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="">
                <a href="{{ route('admin.index') }}">
                  <i class="fa fa-chart-pie"></i>
                    <span> Thống kê</span>
                </a>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fas fa-graduation-cap"></i> <span> Đánh giá </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="">
                        <a href="{{ route('admin.getDashboard') }}">
                          <i class="fa fa-chart-pie"></i>
                            <span>Kết quả đánh giá </span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('admin.getFeedback') }}">
                          <i class="fa fa-chart-pie"></i>
                            <span>Kích hoạt đánh giá</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fas fa-scroll"></i> <span>Tạo bài Đánh giá</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.feedback.index') }}"><i class="fas fa-book"></i>Đánh giá</a></li>
                    <li><a href="{{ route('admin.question.index') }}"><i class="fas fa-question-circle"></i>Câu hỏi</a></li>
                    <li><a href="{{ route('admin.answer.index') }}"><i class="fas fa-stream"></i>Câu trả lời</a></li>
                    {{-- <li><a href=""><i class="fas fa-user-tie"></i> Quản lí giảng viên</a></li> --}}
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fas fa-graduation-cap"></i> <span>Quản lý Đào tạo</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.subject.index') }}"><i class="fas fa-book"></i>Môn học</a></li>
                    <li><a href="{{ route('admin.course.index') }}"><i class="fas fa-bookmark"></i>Khóa học</a></li>
                    <li><a href="{{ route('admin.class.index') }}"><i class="fas fa-book-open"></i>Lớp học</a></li>
                    <li><a href=""><i class="fas fa-concierge-bell"></i>Ca học</a></li>
                    <li><a href=""><i class="fas fa-user-check"></i></i>Điểm danh</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fas fa-users"></i> <span>Quản lý Người dùng</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                    @can('checkAdmin', App\User::class)
                    <li><a href="{{ route('admin.user.index') }}"><i class="fas fa-user"></i> Quản lí Nhân viên</a></li>
                    @endcan
                    
                    <li><a href="{{ route('admin.student.index') }}"><i class="fas fa-user-graduate"></i>Học viên</a></li>
                    <li><a href="{{ route('admin.teacher.index') }}"><i class="fas fa-user-tie"></i>Giảng viên</a></li>
                </ul>
            </li>
    
            
            <li class="">
                <a href="">
                    <i class="fa fa-cog"></i>
                    <span>Cấu hình Website</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
