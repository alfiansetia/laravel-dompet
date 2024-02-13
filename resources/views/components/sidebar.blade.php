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
                <a href="{{ route('transaksi.index') }}"
                    data-active="{{ $title == 'Data Transaksi' ? 'true' : 'false' }}"
                    aria-expanded="{{ $title == 'Data Transaksi' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="repeat"></i>
                        <span>Transaksi</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="{{ route('capital.index') }}" data-active="{{ $title == 'Data Capital' ? 'true' : 'false' }}"
                    aria-expanded="{{ $title == 'Data Capital' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="download"></i>
                        <span>Pemasukan</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="{{ route('expenditure.index') }}"
                    data-active="{{ $title == 'Data Expenditure' ? 'true' : 'false' }}"
                    aria-expanded="{{ $title == 'Data Expenditure' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="upload"></i>
                        <span>Pengeluaran</span>
                    </div>
                </a>
            </li>
            <li class="menu">
                <a href="#master_menu" data-toggle="collapse"
                    data-active="{{ $title == 'Data User' || $title == 'Data Dompet' ? 'true' : 'false' }}"
                    aria-expanded="{{ $title == 'Data User' || $title == 'Data Dompet' ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <i data-feather="hard-drive"></i>
                        <span>Master Data</span>
                    </div>
                    <div>
                        <i data-feather="chevron-right"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ $title == 'Data User' || $title == 'Data Dompet' ? 'show' : '' }}"
                    id="master_menu" data-parent="#accordionExample">
                    <li class="{{ $title == 'Data Dompet' ? 'active' : '' }}">
                        <a href="{{ route('dompet.index') }}">Dompet</a>
                    </li>
                    <li class="{{ $title == 'Data User' ? 'active' : '' }}">
                        <a href="{{ route('user.index') }}">User</a>
                    </li>
                </ul>
            </li>

            <li class="menu">
                <a href="{{ route('report.index') }}" data-active="{{ $title == 'Report' ? 'true' : 'false' }}"
                    aria-expanded="{{ $title == 'Report' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="book"></i>
                        <span>Report</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="#settings_menu" data-toggle="collapse"
                    data-active="{{ $title == 'User Profile' || $title == 'Company Setting' || $title == 'Database Backup' ? 'true' : 'false' }}"
                    aria-expanded="{{ $title == 'User Profile' || $title == 'Company Setting' || $title == 'Database Backup' ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <i data-feather="sliders"></i>
                        <span>Settings</span>
                    </div>
                    <div>
                        <i data-feather="chevron-right"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ $title == 'User Profile' || $title == 'Company Setting' || $title == 'Database Backup' ? 'show' : '' }}"
                    id="settings_menu" data-parent="#accordionExample">
                    <li class="{{ $title == 'User Profile' ? 'active' : '' }}">
                        <a href="{{ route('user.profile') }}">Profile</a>
                    </li>
                    <li class="{{ $title == 'Company Setting' ? 'active' : '' }}">
                        <a href="{{ route('comp.index') }}">Company</a>
                    </li>
                    <li class="{{ $title == 'Database Backup' ? 'active' : '' }}">
                        <a href="{{ route('database.index') }}">Database Backup</a>
                    </li>
                </ul>
            </li>
        </ul>

    </nav>

</div>
