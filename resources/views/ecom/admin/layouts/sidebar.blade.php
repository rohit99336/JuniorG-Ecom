<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteNamed('ecomadmin.dashboard') ? '' : 'collapsed' }}"
                href="{{ route('ecomadmin.dashboard') }}"
                class="{{ Route::currentRouteNamed('ecomadmin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteNamed('ecomadmin.prod.*') ? '' : 'collapsed' }}"
                data-bs-target="#products-nav" data-bs-toggle="collapse"
                href="#">
                <i class="bi bi-box"></i>
                <span>Products</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="products-nav"
                class="nav-content collapse {{ Route::currentRouteNamed('ecomadmin.prod.*') ? 'show' : '' }} "
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('ecomadmin.prod.products.index') }}"
                        class="{{ Route::currentRouteNamed('ecomadmin.prod.products.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Products</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('ecomadmin.prod.products.create') }}"
                        class="{{ Route::currentRouteNamed('ecomadmin.prod.products.create') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>New</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('ecomadmin.prod.categories.index') }}"
                        class="{{ Route::currentRouteNamed('ecomadmin.prod.categories.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Categories</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('ecomadmin.prod.units.index') }}"
                        class="{{ Route::currentRouteNamed('ecomadmin.prod.units.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Units</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('ecomadmin.prod.colors.index') }}"
                        class="{{ Route::currentRouteNamed('ecomadmin.prod.colors.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Colors</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('ecomadmin.prod.stocks') }}"
                        class="{{ Route::currentRouteNamed('ecomadmin.prod.stocks') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Stock Transactions</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteNamed('ecomadmin.offers*') ? '' : 'collapsed' }}"
                data-bs-target="#offer-nav" data-bs-toggle="collapse"
                href="#">
                <i class="bi bi-patch-exclamation"></i>
                <span>Offer</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="offer-nav"
                class="nav-content collapse {{ Route::currentRouteNamed('ecomadmin.offers*') ? 'show' : '' }} "
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('ecomadmin.offers.create') }}"
                        class="{{ Route::currentRouteNamed('ecomadmin.offers.create') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>New offer</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('ecomadmin.offers.index') }}"
                        class="{{ Route::currentRouteNamed('ecomadmin.offers.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Offers</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('ecomadmin.offers.index') }}"
                        class="{{ Route::currentRouteNamed('ecomadmin.offers.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Offers</span>
                    </a>
                </li>
            </ul>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteNamed('ecomadmin.prod.stocks') ? '' : 'collapsed' }}"
                href="{{ route('ecomadmin.prod.stocks') }}"
                class="{{ Route::currentRouteNamed('ecomadmin.prod.stocks') ? 'active' : '' }}">
                <i class='bx bx-transfer'></i>
                <span>Stock Transactions</span>
            </a>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteNamed('ecomadmin.orders.*') ? '' : 'collapsed' }}"
                href="{{ route('ecomadmin.orders.index') }}"
                class="{{ Route::currentRouteNamed('ecomadmin.orders.index') ? 'active' : '' }}">
                <i class='bx bxl-dropbox'></i>
                <span>Orders</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteNamed('ecomadmin.payments.*') ? '' : 'collapsed' }}"
                href="{{ route('ecomadmin.payments.index') }}"
                class="{{ Route::currentRouteNamed('ecomadmin.payments.index') ? 'active' : '' }}">
                <i class='bx bx-money'></i>
                <span>Payments</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteNamed('ecomadmin.customers.*') ? '' : 'collapsed' }}"
                href="{{ route('ecomadmin.customers.index') }}"
                class="{{ Route::currentRouteNamed('ecomadmin.customers.index') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                {{-- <i class='bx bx-user'></i> --}}
                <span>Customers</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteNamed('ecomadmin.employees.*') ? '' : 'collapsed' }}"
                href="{{ route('ecomadmin.employees.index') }}"
                class="{{ Route::currentRouteNamed('ecomadmin.employees.index') ? 'active' : '' }}">
                <i class="bi bi-person-check"></i>
                <span>Employees</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteNamed('ecomadmin.setting*') ? '' : 'collapsed' }}"
                data-bs-target="#setting-nav" data-bs-toggle="collapse"
                href="#">
                <i class="bi bi-gear"></i>
                <span>Setting</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="setting-nav"
                class="nav-content collapse {{ Route::currentRouteNamed('ecomadmin.setting*') ? 'show' : '' }} "
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('ecomadmin.setting.shipping-methods.index') }}"
                        class="{{ Route::currentRouteNamed('ecomadmin.setting.shipping-methods.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Shipping
                            Methods</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('ecomadmin.setting.payment-methods.index') }}"
                        class="{{ Route::currentRouteNamed('ecomadmin.setting.payment-methods.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Payment
                            Methods</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('ecomadmin.setting.web-master.index') }}"
                        class="{{ Route::currentRouteNamed('ecomadmin.web.setting-master.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Web Master</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteNamed('ecomadmin.advertisement.index') ? '' : 'collapsed' }}"
                href="{{ route('ecomadmin.advertisement.index') }}"
                class="{{ Route::currentRouteNamed('ecomadmin.advertisement.index') ? 'active' : '' }}">
                <i class="bi bi-badge-ad"></i>
                <span>Advertisement</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteNamed('ecomadmin.news-letters.*') ? '' : 'collapsed' }}"
                href="{{ route('ecomadmin.news-letters.index') }}"
                class="{{ Route::currentRouteNamed('ecomadmin.news-letters.index') ? 'active' : '' }}">
                <i class="bi bi-newspaper"></i>
                <span>News Letters</span>
            </a>
        </li>

        {{-- <li class="nav-heading">Other</li> --}}
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteNamed('ecomadmin.contact-request.*') ? '' : 'collapsed' }}"
                href="{{ route('ecomadmin.contact-request.index') }}"
                class="{{ Route::currentRouteNamed('ecomadmin.contact-request.index') ? 'active' : '' }}">
                <i class="bi bi-envelope"></i>
                <span>Contact Messages</span>
            </a>
        </li>

        <li class="nav-heading">Blogs</li>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteNamed('ecomadmin.blog*') ? '' : 'collapsed' }}"
                data-bs-target="#blogs-nav" data-bs-toggle="collapse"
                href="#">
                <i class="bi bi-journal-text"></i>
                <span>Blogs</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="blogs-nav"
                class="nav-content collapse {{ Route::currentRouteNamed('ecomadmin.blog*') ? 'show' : '' }} "
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('ecomadmin.blog.blogs.index') }}"
                        class="{{ Route::currentRouteNamed('ecomadmin.blog.blogs.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>All Blogs</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('ecomadmin.blog.blogs.create') }}"
                        class="{{ Route::currentRouteNamed('ecomadmin.blog.blogs.create') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>New Blog</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('ecomadmin.blog.blog-category.index') }}"
                        class="{{ Route::currentRouteNamed('ecomadmin.blog.blog-category.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Blog Categories</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteNamed('ecomadmin.posts.*') ? '' : 'collapsed' }}"
                href="{{ route('ecomadmin.posts.index') }}"
                class="{{ Route::currentRouteNamed('ecomadmin.posts.index') ? 'active' : '' }}">
                <i class='bx bx-book-content'></i>
                <span>Posts</span>
            </a>
        </li>

        <li class="nav-heading">Roles & Permissions</li>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteNamed('ecomadmin.authorization.permissions.*') ? '' : 'collapsed' }}"
                data-bs-target="#permission-nav" data-bs-toggle="collapse"
                href="#">
                <i class="bi bi-shield"></i>
                <span>Permission</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="permission-nav"
                class="nav-content collapse {{ Route::currentRouteNamed('ecomadmin.authorization.permissions.*') ? 'show' : '' }} "
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('ecomadmin.authorization.permissions.index') }}"
                        class="{{ Route::currentRouteNamed('ecomadmin.authorization.permissions.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Permissions</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('ecomadmin.authorization.permissions.create') }}"
                        class="{{ Route::currentRouteNamed('ecomadmin.authorization.permissions.create') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>New</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteNamed('ecomadmin.authorization.roles.*') ? '' : 'collapsed' }}"
                data-bs-target="#role-nav" data-bs-toggle="collapse"
                href="#">
                <i class="bi bi-award"></i>
                <span>Roles</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="role-nav"
                class="nav-content collapse {{ Route::currentRouteNamed('ecomadmin.authorization.roles.*') ? 'show' : '' }} "
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('ecomadmin.authorization.roles.index') }}"
                        class="{{ Route::currentRouteNamed('ecomadmin.authorization.roles.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Roles</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('ecomadmin.authorization.roles.create') }}"
                        class="{{ Route::currentRouteNamed('ecomadmin.authorization.roles.create') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>New</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>

</aside><!-- End Sidebar-->
