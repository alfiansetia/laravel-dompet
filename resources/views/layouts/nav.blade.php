<div class="header-container fixed-top">
    <header class="header navbar navbar-expand-sm">

        <ul class="navbar-item theme-brand flex-row  text-center">
            <li class="nav-item theme-logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('assets/img/logo.svg') }}" class="navbar-logo" alt="logo">
                </a>
            </li>
            <li class="nav-item theme-text">
                <a href="{{ route('home') }}" class="nav-link"> {{ $comp->name }} </a>
            </li>
        </ul>

        <ul class="navbar-item flex-row ml-md-0 ml-auto">
            <li class="nav-item align-self-center search-animated">
                <i data-feather="search" class="toggle-search"></i>
                <form class="form-inline search-full form-inline search" role="search">
                    <div class="search-bar">
                        <input type="text" class="form-control search-form-control  ml-lg-auto"
                            placeholder="Search...">
                    </div>
                </form>
            </li>
        </ul>

        <ul class="navbar-item flex-row ml-md-auto">

            <li class="nav-item dropdown message-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="messageDropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="mail"></i>
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="messageDropdown">
                    <div class="">
                        <a class="dropdown-item">
                            <div class="">

                                <div class="media">
                                    <div class="user-img">
                                        <div class="avatar avatar-xl">
                                            <span class="avatar-title rounded-circle">KY</span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div class="">
                                            <h5 class="usr-name">Kara Young</h5>
                                            <p class="msg-title">ACCOUNT UPDATE</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </a>
                        <a class="dropdown-item">
                            <div class="">
                                <div class="media">
                                    <div class="user-img">
                                        <img src="{{ asset('assets/img/profile-15.jpg') }}" class="img-fluid mr-2"
                                            alt="avatar">
                                    </div>
                                    <div class="media-body">
                                        <div class="">
                                            <h5 class="usr-name">Daisy Anderson</h5>
                                            <p class="msg-title">ACCOUNT UPDATE</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a class="dropdown-item">
                            <div class="">

                                <div class="media">
                                    <div class="user-img">
                                        <div class="avatar avatar-xl">
                                            <span class="avatar-title rounded-circle">OG</span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div class="">
                                            <h5 class="usr-name">Oscar Garner</h5>
                                            <p class="msg-title">ACCOUNT UPDATE</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </div>
                </div>
            </li>

            <li class="nav-item dropdown notification-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="bell"></i>
                    <span class="badge badge-success"></span>
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
                    <div class="notification-scroll">

                        <div class="dropdown-item">
                            <div class="media server-log">
                                <i data-feather="server"></i>
                                <div class="media-body">
                                    <div class="data-info">
                                        <h6 class="">Server Rebooted</h6>
                                        <p class="">45 min ago</p>
                                    </div>

                                    <div class="icon-status">
                                        <i data-feather="x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown-item">
                            <div class="media ">
                                <i data-feather="heart"></i>
                                <div class="media-body">
                                    <div class="data-info">
                                        <h6 class="">Licence Expiring Soon</h6>
                                        <p class="">8 hrs ago</p>
                                    </div>

                                    <div class="icon-status">
                                        <i data-feather="x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown-item">
                            <div class="media file-upload">
                                <i data-feather="file-text"></i>
                                <div class="media-body">
                                    <div class="data-info">
                                        <h6 class="">Kelly Portfolio.pdf</h6>
                                        <p class="">670 kb</p>
                                    </div>
                                    <div class="icon-status">
                                        <i data-feather="check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>

            <li class="nav-item dropdown user-profile-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <img src="{{ auth()->user()->avatar }}" alt="avatar">
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                    <div class="">
                        <div class="dropdown-item">
                            <a class="" href="{{ route('user.profile') }}"><i
                                    data-feather="user"></i>Profile</a>
                        </div>
                        <div class="dropdown-item">
                            <a class="" href="javascript:void(0);"><i data-feather="inbox"></i>Inbox</a>
                        </div>
                        <div class="dropdown-item">
                            <a class="" href="javascript:void(0);"><i data-feather="lock"></i>Lock Screen</a>
                        </div>
                        <div class="dropdown-item">
                            <a class="" href="javascript:void(0);" onclick="logout_()">
                                <i data-feather="log-out"></i>Sign Out
                            </a>
                        </div>
                    </div>
                </div>
            </li>
            </li>

        </ul>
    </header>
</div>

<div class="sub-header-container">
    <header class="header navbar navbar-expand-sm">
        <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
            <i data-feather="menu"></i>
        </a>

        <ul class="navbar-nav flex-row">
            <li>
                <div class="page-header">

                    <nav class="breadcrumb-one" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">DataTables</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><span>Basic</span></li>
                        </ol>
                    </nav>

                </div>
            </li>
        </ul>
    </header>
</div>
