<header>
    <div class="logo">
        <span>Đánh giá Giảng viên</span>
        <i class="fas fa-bars sidebar-toggle"></i>
    </div>
    <div class="navbar">
        <ul>
            <li class="menu-item">
                <a href="/">
                    <i class="fas fa-home"></i>
                    <span>Trang chủ</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('feedback.getFeedback') }}">
                    <i class="fas fa-scroll"></i>
                    <span>Khảo sát học tập</span>
                </a>
                
            </li>  
            <li class="menu-item">
                <a href="{{ route('feedback.getCheckIn') }}">
                    <i class="fas fa-scroll"></i>
                    <span>Điểm danh</span>
                </a>
            </li>   
        </ul>
        <div class="menu-account">
            <div class="account-toggle">
                <i class="fas fa-user"></i>
                <span>Xin chào, Huy</span>
                <i class="fas fa-sort-down"></i>
            </div>
            
            <ul class="drop-menu">
                <li class="menu-item">
                    <a href="{{ route('feedback.getProfile') }}">
                        <i class="fas fa-user-cog"></i>
                        <span>Quản lí Tài khoản</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('user.logout')}}">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Đăng xuất</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    
</header>