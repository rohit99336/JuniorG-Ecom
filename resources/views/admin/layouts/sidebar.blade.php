<aside id="sidebar" class="sidebar"> <!-- Sidebar -->
    <ul class="sidebar-nav" id="sidebar-nav"> <!-- Sidebar Nav -->
        <li class="nav-item">
            <a class="nav-link" href="{{route('ecomadmin.dashboard')}}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#salons-nav" data-bs-toggle="collapse"
                href="{{ route('salons.index') }}">
                <i class="bi bi-suit-spade"></i><span>Salons</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="salons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('salons.index') }}">
                        <i class="bi bi-circle"></i><span>List</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('salons.create') }}">
                        <i class="bi bi-circle"></i><span>New Salon</span>
                    </a>
                </li>
            </ul>
        </li><!-- End salons Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#service-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-view-list"></i><span>Service</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="service-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('services.index') }}">
                        <i class="bi bi-circle"></i><span>Service List</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('services.create') }}">
                        <i class="bi bi-circle"></i><span>New Service</span>
                    </a>
                </li>
            </ul>
        </li><!-- End service Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#appointment-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-clipboard"></i>
                <span>Appointment</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="appointment-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('appointments.index') }}">
                        <i class="bi bi-circle"></i><span>Appointment List</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('appointments.create') }}">
                        <i class="bi bi-circle"></i><span>New appointment</span>
                    </a>
                </li> --}}
            </ul>
        </li><!-- End appointment Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#gallery-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-file-earmark-play"></i>
                <span>Media</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="gallery-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('gallery.index') }}"
                        class="{{ Route::currentRouteNamed('gallery.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Gallery Image</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('sliders.index') }}"
                        class="{{ Route::currentRouteNamed('sliders.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Slider Image</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('instagram-list') }}"
                        class="{{ Route::currentRouteNamed('instagram-list') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Instagram Links</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#contact-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-person-square"></i>
                <span>Enquiry</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="contact-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('contacts.index') }}"
                        class="{{ Route::currentRouteNamed('contacts.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Request/Query</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#Offer-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-patch-check"></i><span>Offer</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="Offer-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('offers.index') }}">
                        <i class="bi bi-circle"></i><span>Offer List</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('offers.create') }}">
                        <i class="bi bi-circle"></i><span>New Offer</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('applied-offers') }}">
                        <i class="bi bi-circle"></i><span>Applied Offers</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#academy-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-pentagon"></i>
                <span>Academy</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="academy-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('categories.index') }}">
                        <i class="bi bi-circle"></i><span>Course Category</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('courses.index') }}">
                        <i class="bi bi-circle"></i><span>Course List</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('courses.create') }}">
                        <i class="bi bi-circle"></i><span>New Course</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('course-enquiries.index') }}">
                        <i class="bi bi-circle"></i><span>Course Enquiries</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteNamed('templates.*') ? '' : 'collapsed' }}"
                data-bs-target="#Template-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-back"></i>
                <span>Template</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="Template-nav"
                class="nav-content collapse {{ Route::currentRouteNamed('templates.*') ? 'show' : '' }} "
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('templates.index') }}"
                        class="{{ Route::currentRouteNamed('templates.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Templates</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('templates.create') }}"
                        class="{{ Route::currentRouteNamed('templates.create') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>New</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteNamed('messages.*') ? '' : 'collapsed' }}"
                data-bs-target="#messages-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-envelope"></i>
                <span>Message</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="messages-nav"
                class="nav-content collapse {{ Route::currentRouteNamed('messages.*') ? 'show' : '' }} "
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('messages.index') }}"
                        class="{{ Route::currentRouteNamed('messages.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Messages</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('messages.create') }}"
                        class="{{ Route::currentRouteNamed('messages.create') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>New</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#web-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-globe"></i><span>Web Master</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="web-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('web-masters.index') }}">
                        <i class="bi bi-circle"></i><span>Setting</span>
                    </a>
                </li>
            </ul>
        </li>

    </ul><!-- End Sidebar Nav -->
</aside><!-- End Sidebar -->
