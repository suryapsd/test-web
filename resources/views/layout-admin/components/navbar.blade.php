<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="ti ti-menu-2 ti-sm"></i>
    </a>
  </div>

  <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <ul class="navbar-nav flex-row align-items-center ms-auto">
      <!-- Notification -->
      @php
        $notifications = auth()->user()->unreadNotifications;
      @endphp
      <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
          <i class="ti ti-bell ti-md"></i>
          @if (count($notifications) >= 1)
            <span class="badge bg-danger rounded-pill badge-notifications">{{ count($notifications) }}</span>
          @endif
        </a>
        <ul class="dropdown-menu dropdown-menu-end py-0">
          <li class="dropdown-menu-header border-bottom">
            <div class="dropdown-header d-flex align-items-center py-3">
              <h5 class="text-body mb-0 me-auto">Notification</h5>
              @if (count($notifications) >= 1)
                <a href="{{ route('notification.read-all') }}" class="dropdown-notifications-all text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark all as read"><i class="ti ti-mail-opened fs-4"></i></a>
              @endif
            </div>
          </li>
          <li class="dropdown-notifications-list scrollable-container">
            <ul class="list-group list-group-flush">
              @forelse ($notifications as $notification)
                <li class="list-group-item list-group-item-action dropdown-notifications-item">
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-2">
                      {{-- <div class="avatar">
                        <img src="../../assets/img/avatars/1.png" alt class="h-auto rounded-circle" />
                      </div> --}}
                      <span class="badge badge-center bg-label-warning"><i class="ti ti-loader"></i></span>
                    </div>
                    <div class="flex-grow-1">
                      <a href="{{ route('notification.read', ['id' => $notification->id]) }}" class="text-decoration-none text-body">
                        <h6 class="mb-1">{{ $notification->data['title'] }}</h6>
                        <p class="mb-0">{{ $notification->data['content'] }}</p>
                        <small class="text-muted"> {{ \Carbon\Carbon::parse($notification->data['date'])->format('d M Y') }}</small>
                      </a>
                    </div>
                    <div class="flex-shrink-0 dropdown-notifications-actions">
                      <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                    </div>
                  </div>
                </li>
              @empty
                <li class="text-center p-2">
                  no notification yet
                </li>
              @endforelse
            </ul>
          </li>
          @if (count($notifications) >= 1)
            <li class="dropdown-menu-footer border-top">
              <a href="{{ route('notification.read-all') }}" class="dropdown-item d-flex justify-content-center text-primary p-2 h-px-40 mb-1 align-items-center">
                View all notifications
              </a>
            </li>
          @endif
        </ul>
      </li>
      <!--/ Notification -->

      <!-- User -->
      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
          <div class="avatar avatar-online">
            <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="img-fluid rounded-circle" style="object-fit: cover; object-position: top;" />
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" href="pages-account-settings-account.html">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                  <div class="avatar avatar-online">
                    <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="img-fluid rounded-circle" style="object-fit: cover; object-position: top;" />
                  </div>
                </div>
                {{-- <div class="flex-grow-1">
                  <span class="fw-semibold d-block">{{ Auth::user()->name ?? '' }}</span>
                  @foreach (Auth::user()->roles as $item)
                    <small class="text-muted">{{ $item->name . (!$loop->last ? ', ' : '') }}</small>
                  @endforeach
                </div> --}}
              </div>
            </a>
          </li>
          <li>
            <div class="dropdown-divider"></div>
          </li>
          <li>
            <a class="dropdown-item" href="/profile">
              <i class="ti ti-user-check me-2 ti-sm"></i>
              <span class="align-middle">My Profile</span>
            </a>
          </li>
          <li>
            <div class="dropdown-divider"></div>
          </li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="dropdown-item">
                <i class="ti ti-logout me-2 ti-sm"></i>
                <span class="align-middle">Log Out</span>
              </button>
            </form>
          </li>
        </ul>
      </li>
      <!--/ User -->
    </ul>
  </div>
</nav>
