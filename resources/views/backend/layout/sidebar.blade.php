<div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- User Profile-->
                <li class="sidebar-item pt-2">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('dashboard') }}"
                        aria-expanded="false">
                        <i class="fas fa-tachometer-alt" aria-hidden="true"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('user.index') }}"
                        aria-expanded="false">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span class="hide-menu">User</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('courrier.index') }}"
                        aria-expanded="false">
                        <i class="fa fa-truck" aria-hidden="true"></i>
                        <span class="hide-menu">Kurir</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('supplier.index') }}"
                        aria-expanded="false">
                        <i class="fa fa-people-carry" aria-hidden="true"></i>
                        <span class="hide-menu">Suplier</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('product.index') }}"
                        aria-expanded="false">
                        <i class="fa fa-box-open" aria-hidden="true"></i>
                        <span class="hide-menu">Produk</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="blank.html"
                        aria-expanded="false">
                        <i class="fa fa-book" aria-hidden="true"></i>
                        <span class="hide-menu">Resep</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="404.html"
                        aria-expanded="false">
                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                        <span class="hide-menu">Bahan-bahan</span>
                    </a>
                </li>
                <li class="text-center p-20 upgrade-btn">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn d-grid btn-danger text-white w-100">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>

        </nav>
        <!-- End Sidebar navigation -->
    </div>