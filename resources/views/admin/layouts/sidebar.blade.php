<aside class="left-sidebar" data-sidebarbg="skin6">
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item {{ Request::is('admin/dashboard*') ? 'selected' : '' }}">
                    <a class="sidebar-link {{ Request::is('admin/dashboard*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('admin/user*') ? 'selected' : '' }}">
                    <a class="sidebar-link {{ Request::is('admin/user*') ? 'active' : '' }}" href="{{ route('admin.user') }}" aria-expanded="false">
                        <i class="fas fa-users"></i>
                        <span class="hide-menu">Users</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('admin/settings*') ? 'selected' : '' }}">
                    <a class="sidebar-link {{ Request::is('admin/settings*') ? 'active' : '' }}" href="{{ route('admin.settings') }}" aria-expanded="false">
                        <i class="fas fa-sun"></i>
                        <span class="hide-menu">Settings</span>
                    </a>
                </li>
                <li class="sidebar-item {{ (Request::is('admin/product-category*') || Request::is('admin/product*')) ? 'selected' : '' }}">
                    <a class="sidebar-link has-arrow {{ (Request::is('admin/product-category*') || Request::is('admin/product*')) ? 'active' : '' }}" href="javascript:void(0)" aria-expanded="false">
                    <i class="fa fa-list-ul"></i>
                        <span class="hide-menu">Product Master</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level base-level-line {{ (Request::is('admin/product-category*') || Request::is('admin/product*')) ? 'in' : '' }}">
                        <li class="sidebar-item {{ Request::is('admin/product-category*') ? 'active' : '' }}">
                            <a class="sidebar-link {{ Request::is('admin/product-category*') ? 'active' : '' }}" href="{{ route('admin.product_category.index') }}" aria-expanded="false">
                                <i class="fa fa-list"></i>
                                <span class="nav-label">Product Category</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ (Request::is('admin/product*') && !Request::is('admin/product-category*')) ? 'active' : '' }}">
                            <a class="sidebar-link {{ (Request::is('admin/product*') && !Request::is('admin/product-category*')) ? 'active' : '' }}" href="{{ route('admin.product.index') }}" aria-expanded="false">
                                <i class="fa fa-list-ul"></i>
                                <span class="nav-label">Product</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>