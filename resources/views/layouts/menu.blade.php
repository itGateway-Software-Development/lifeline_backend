<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <img style="width: 60px;" src="{{ asset('logo.png') }}" alt="">
            <span class="demo menu-text fw-bolder ms-2" style="font-size: 20px;">{{ __('messages.panel_name') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('admin') ? 'active' : '' }}">
            <a href="/" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-dashboard'></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Layouts -->
        @can('user_management_access')
            <li
                class="menu-item {{ request()->is('admin/users') || request()->is('admin/users/*') || request()->is('admin/roles') || request()->is('admin/roles/*') || request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bxs-user-circle'></i>
                    <div data-i18n="Layouts">User Management</div>
                </a>

                <ul class="menu-sub">
                    @can('permission_access')
                        <li
                            class="menu-item {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active open' : '' }}">
                            <a href="{{ route('admin.permissions.index') }}" class="menu-link">
                                <div data-i18n="Without menu">Permission</div>
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li
                            class="menu-item {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active open' : '' }}">
                            <a href="{{ route('admin.roles.index') }}" class="menu-link">
                                <div data-i18n="Without menu">Roles</div>
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li
                            class="menu-item {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active open' : '' }}">
                            <a href="{{ route('admin.users.index') }}" class="menu-link">
                                <div data-i18n="Without menu">Users</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Partners</span>
        </li>

        @can('principle_access')
            <li
                class="menu-item {{ request()->is('admin/principles') || request()->is('admin/principles/*') ? 'active' : '' }}">
                <a href="{{ route('admin.principles.index') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-user-check'></i>
                    <div data-i18n="Analytics">{{ __('messages.principle.title') }}</div>
                </a>
            </li>
        @endcan

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">PRODUCTS</span>
        </li>
        @can('product_management_access')
            <li
                class="menu-item {{ request()->is('admin/announcements') || request()->is('admin/announcements/*') || request()->is('admin/ingredients') || request()->is('admin/ingredients/*') || request()->is('admin/products') || request()->is('admin/products/*') || request()->is('admin/groups') || request()->is('admin/groups/*') || request()->is('admin/categories') || request()->is('admin/categories/*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bxs-capsule'></i>
                    <div data-i18n="Account Settings">Products Management</div>
                </a>
                <ul class="menu-sub">
                    <li
                        class="menu-item {{ request()->is('admin/announcements') || request()->is('admin/announcements/*') ? 'active open' : '' }}">
                        <a href="{{ route('admin.announcements.index') }}" class="menu-link">
                            <div data-i18n="Account">Announcement</div>
                        </a>
                    </li>
                    @can('group_access')
                        <li
                            class="menu-item {{ request()->is('admin/groups') || request()->is('admin/groups/*') ? 'active open' : '' }}">
                            <a href="{{ route('admin.groups.index') }}" class="menu-link">
                                <div data-i18n="Account">{{ __('messages.group.title') }}</div>
                            </a>
                        </li>
                    @endcan
                    @can('category_access')
                        <li
                            class="menu-item {{ request()->is('admin/categories') || request()->is('admin/categories/*') ? 'active open' : '' }}">
                            <a href="{{ route('admin.categories.index') }}" class="menu-link">
                                <div data-i18n="Account">{{ __('messages.category.title') }}</div>
                            </a>
                        </li>
                    @endcan
                    @can('ingredient_access')
                        <li
                            class="menu-item {{ request()->is('admin/ingredients') || request()->is('admin/ingredients/*') ? 'active open' : '' }}">
                            <a href="{{ route('admin.ingredients.index') }}" class="menu-link">
                                <div data-i18n="Account">{{ __('messages.ingredient.title') }}</div>
                            </a>
                        </li>
                    @endcan

                    @can('product_access')
                        <li
                            class="menu-item {{ request()->is('admin/products') || request()->is('admin/products/*') ? 'active open' : '' }}">
                            <a href="{{ route('admin.products.index') }}" class="menu-link">
                                <div data-i18n="Account">{{ __('messages.product.title') }}</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('activity_management_access')
            <li
                class="menu-item {{ request()->is('admin/activity') || request()->is('admin/activity/*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bxs-landscape' ></i>
                    <div data-i18n="Account Settings">Activity Management</div>
                </a>
                <ul class="menu-sub">
                    @can('photo_gallery_access')
                        <li
                            class="menu-item {{ request()->is('admin/activity/photo-gallery') || request()->is('admin/activity/photo-gallery/*') ? 'active open' : '' }}">
                            <a href="{{ route('admin.photo-gallery.index') }}" class="menu-link">
                                <div data-i18n="Account">{{ __('messages.photo_gallery.title') }}</div>
                            </a>
                        </li>
                    @endcan
                    <li
                        class="menu-item {{ request()->is('admin/activity/csr-activities') || request()->is('admin/activity/csr-activities/*') ? 'active open' : '' }}">
                        <a href="{{ route('admin.csr-activities.index') }}" class="menu-link">
                            <div data-i18n="Account">{{ __('messages.csr.title') }}</div>
                        </a>
                    </li>
                    <li
                        class="menu-item {{ request()->is('admin/activity/new-events') || request()->is('admin/activity/new-events/*') ? 'active open' : '' }}">
                        <a href="{{ route('admin.new-events.index') }}" class="menu-link">
                            <div data-i18n="Account">{{ __('messages.news.title') }}</div>
                        </a>
                    </li>
                    <li
                    class="menu-item {{ request()->is('admin/activity/academic-activities') || request()->is('admin/activity/academic-activities/*') ? 'active open' : '' }}">
                    <a href="{{ route('admin.academic-activities.index') }}" class="menu-link">
                        <div data-i18n="Account">{{ __('messages.academic.title') }}</div>
                    </a>
                </li>
                </ul>
            </li>
        @endcan
        <li
            class="menu-item {{ request()->is('admin/company-setting') || request()->is('admin/company-setting/*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-category-alt' ></i>
                <div data-i18n="Account Settings">Company Setting</div>
            </a>
            <ul class="menu-sub">
                <li
                    class="menu-item {{ request()->is('admin/company-setting/services') || request()->is('admin/company-setting/services/*') ? 'active open' : '' }}">
                    <a href="{{ route('admin.services.index') }}" class="menu-link">
                        <div data-i18n="Account">{{ __('messages.services.title') }}</div>
                    </a>
                </li>

                <li
                    class="menu-item {{ request()->is('admin/company-setting/promotions') || request()->is('admin/company-setting/promotions/*') ? 'active open' : '' }}">
                    <a href="{{ route('admin.promotions.index') }}" class="menu-link">
                        <div data-i18n="Account">{{ __('messages.promotions.title') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        <li
            class="menu-item {{ request()->is('admin/career-setting') || request()->is('admin/career-setting/*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-briefcase-alt-2'></i>
                <div data-i18n="Account Settings">Career Setting</div>
            </a>
            <ul class="menu-sub">
                <li
                    class="menu-item {{ request()->is('admin/career-setting/locations') || request()->is('admin/career-setting/locations/*') ? 'active open' : '' }}">
                    <a href="{{ route('admin.locations.index') }}" class="menu-link">
                        <div data-i18n="Account">{{ __('messages.locations.title') }}</div>
                    </a>
                </li>

                <li
                    class="menu-item {{ request()->is('admin/career-setting/positions') || request()->is('admin/career-setting/positions/*') ? 'active open' : '' }}">
                    <a href="{{ route('admin.positions.index') }}" class="menu-link">
                        <div data-i18n="Account">{{ __('messages.positions.title') }}</div>
                    </a>
                </li>

                <li
                    class="menu-item {{ request()->is('admin/career-setting/departments') || request()->is('admin/career-setting/departments/*') ? 'active open' : '' }}">
                    <a href="{{ route('admin.departments.index') }}" class="menu-link">
                        <div data-i18n="Account">{{ __('messages.departments.title') }}</div>
                    </a>
                </li>

                <li
                    class="menu-item {{ request()->is('admin/career-setting/careers') || request()->is('admin/career-setting/careers/*') ? 'active open' : '' }}">
                    <a href="{{ route('admin.careers.index') }}" class="menu-link">
                        <div data-i18n="Account">{{ __('messages.careers.title') }}</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
