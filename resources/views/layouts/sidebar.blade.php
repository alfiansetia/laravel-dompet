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
                        <i data-feather="dollar-sign"></i>
                        <span>Dompet</span>
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
                        <span>Capital</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="{{ route('expenditure.index') }}"
                    data-active="{{ $title == 'Data Expenditure' ? 'true' : 'false' }}"
                    aria-expanded="{{ $title == 'Data Expenditure' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="upload"></i>
                        <span>Expenditure</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="#datatables" data-toggle="collapse" data-active="false" aria-expanded="false"
                    class="dropdown-toggle">
                    <div class="">
                        <i data-feather="layers"></i>
                        <span>Master Data</span>
                    </div>
                    <div>
                        <i data-feather="chevron-right"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="datatables" data-parent="#accordionExample">
                    <li class="active">
                        <a href="{{ route('dompet.index') }}">Dompet</a>
                    </li>
                    <li>
                        <a href="{{ route('user.index') }}">User</a>
                    </li>
                </ul>
            </li>

            <li class="menu">
                <a href="{{ route('comp.index') }}" data-active="{{ $title == 'Company Setting' ? 'true' : 'false' }}"
                    aria-expanded="{{ $title == 'Company Setting' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="upload"></i>
                        <span>Company Setting</span>
                    </div>
                </a>
            </li>
        </ul>

    </nav>

</div>
