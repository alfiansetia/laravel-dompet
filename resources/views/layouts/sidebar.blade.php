<div class="sidebar-wrapper sidebar-theme">
    <nav id="sidebar">
        <div class="shadow-bottom"></div>

        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu">
                <a href="{{ route('home') }}" data-active="{{ $title == 'Dashboard' ? 'true' : 'false' }}"
                aria-expanded="{{ $title == 'Dashboard' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="home"></i>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>
            <li class="menu">
                <a href="{{ route('user.index') }}" data-active="{{ $title == 'Data User' ? 'true' : 'false' }}"
                    aria-expanded="{{ $title == 'Data User' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="user"></i>
                        <span>User</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="{{ route('dompet.index') }}" data-active="{{ $title == 'Data Dompet' ? 'true' : 'false' }}"
                    aria-expanded="{{ $title == 'Data Dompet' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="briefcase"></i>
                        <span>Dompet</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="#datatables" data-toggle="collapse" data-active="false" aria-expanded="false"
                    class="dropdown-toggle">
                    <div class="">
                        <i data-feather="layers"></i>
                        <span>DataTables</span>
                    </div>
                    <div>
                        <i data-feather="chevron-right"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="datatables" data-parent="#accordionExample">
                    <li class="active">
                        <a href="table_dt_basic.html"> Basic </a>
                    </li>
                    <li>
                        <a href="table_dt_striped_table.html"> Striped Table </a>
                    </li>
                </ul>
            </li>
        </ul>

    </nav>

</div>
