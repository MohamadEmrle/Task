<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->


    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">

            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item menu-open">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                        <p>
                            Dashboard
                        </p>
                    </a>

                </li>


                <li class="nav-item">

                    <a href="{{ route('admin.categories') }}" class="nav-link">

                        <p>
                            Categories
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.images') }}" class="nav-link">
                        <p>
                            Images
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.services') }}" class="nav-link">
                        <p>
                            Services
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.contents') }}" class="nav-link">
                        <p>
                            Contents
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.customers') }}" class="nav-link">
                        <p>
                            Customers
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.identities') }}" class="nav-link">
                        <p>
                            Identities
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
