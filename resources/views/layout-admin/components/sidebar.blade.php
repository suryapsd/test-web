<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="/" class="app-brand-link">
      Layanan
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
      <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboards -->
    <li class="menu-item {{ request()->is('/') ? 'active' : '' }}">
      <a href="/" class="menu-link">
        <i class="menu-icon tf-icons ti ti-smart-home"></i>
        <div data-i18n="Dashboard">Dashboard</div>
      </a>
    </li>
    <li class="menu-item {{ request()->is('profile*') ? 'active' : '' }}">
      <a href="/profile" class="menu-link">
        <i class="menu-icon tf-icons ti ti-user-circle"></i>
        <div data-i18n="Villas">Profile</div>
      </a>
    </li>

    <!-- User -->
    @can(['account-list', 'role-list', 'permission-list', 'subscription-list'])
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">User</span>
      </li>
      <li class="menu-item {{ request()->is('user-account*') || request()->is('roles*') || request()->is('permissions*') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons ti ti-user"></i>
          <div data-i18n="Amenity">User</div>
          <div class="badge bg-label-primary rounded-pill ms-auto">3</div>
        </a>
        <ul class="menu-sub">
          @can('account-list')
            <li class="menu-item {{ request()->is('user-account*') ? 'active' : '' }}">
              <a href="/user-account" class="menu-link">
                <div data-i18n="Amenity Type">Account</div>
              </a>
            </li>
          @endcan
          @can('role-list')
            <li class="menu-item {{ request()->is('roles*') ? 'active' : '' }}">
              <a href="/roles" class="menu-link">
                <div data-i18n="Amenity Type">Role</div>
              </a>
            </li>
          @endcan
          @can('permission-list')
            <li class="menu-item {{ request()->is('permissions*') ? 'active' : '' }}">
              <a href="/permissions" class="menu-link">
                <div data-i18n="Amenity Type">Permission</div>
              </a>
            </li>
          @endcan
        </ul>
      </li>
      @can('subscription-list')
        <li class="menu-item {{ request()->is('subscriptions*') ? 'active' : '' }}">
          <a href="/subscriptions" class="menu-link">
            <i class="menu-icon tf-icons ti ti-sunrise"></i>
            <div data-i18n="Villas">Subscription</div>
          </a>
        </li>
      @endcan
    @endcan

    <!-- Master Data -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Master Data</span>
    </li>

    <!-- User -->
    @if (Auth::user()->roles[0]->name === 'Super Admin')
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">User</span>
      </li>
      <li class="menu-item {{ request()->is('user-account*') || request()->is('roles*') || request()->is('permissions*') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons ti ti-user"></i>
          <div data-i18n="Amenity">User</div>
          <div class="badge bg-label-primary rounded-pill ms-auto">3</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ request()->is('user-account*') ? 'active' : '' }}">
            <a href="/user-account" class="menu-link">
              <div data-i18n="Amenity Type">Account</div>
            </a>
          </li>
          <li class="menu-item {{ request()->is('roles*') ? 'active' : '' }}">
            <a href="/roles" class="menu-link">
              <div data-i18n="Amenity Type">Role</div>
            </a>
          </li>
          <li class="menu-item {{ request()->is('permissions*') ? 'active' : '' }}">
            <a href="/permissions" class="menu-link">
              <div data-i18n="Amenity Type">Permission</div>
            </a>
          </li>
        </ul>
      </li>
    @endif
    <li class="menu-item {{ request()->is('jenis-layanan*') ? 'active' : '' }}">
      <a href="/jenis-layanan" class="menu-link">
        <i class="menu-icon tf-icons ti ti-clipboard"></i>
        <div data-i18n="Villas">Jenis Layanan</div>
      </a>
    </li>
    <li class="menu-item {{ request()->is('dokumen-wajib*') ? 'active' : '' }}">
      <a href="/dokumen-wajib" class="menu-link">
        <i class="menu-icon tf-icons ti ti-clipboard"></i>
        <div data-i18n="Villas">Dokumen Wajib</div>
      </a>
    </li>
    <li class="menu-item {{ request()->is('kategori-layanan*') ? 'active' : '' }}">
      <a href="/kategori-layanan" class="menu-link">
        <i class="menu-icon tf-icons ti ti-clipboard"></i>
        <div data-i18n="Villas">Kategori Layanan</div>
      </a>
    </li>

    <!-- Apps & Pages -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Layanan Publik</span>
    </li>
    <li class="menu-item {{ request()->is('layanan*') ? 'active' : '' }}">
      <a href="/layanan" class="menu-link">
        <i class="menu-icon tf-icons ti ti-clipboard"></i>
        <div data-i18n="Villas">Layanan</div>
      </a>
    </li>

    <div class="py-3"></div>
  </ul>
</aside>
