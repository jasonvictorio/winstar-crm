@php
    $routes = [
      [ 'route' => 'company', 'name' => 'Company', 'icon' => 'building' ],
      [ 'route' => 'user', 'name' => 'User', 'icon' => 'user-tie' ],
      [ 'route' => 'status', 'name' => 'Status', 'icon' => 'check-square' ],
      [ 'route' => 'status-type', 'name' => 'Status Type', 'icon' => 'check-square' ],
      [ 'route' => 'nature-of-contact', 'name' => 'Nature of Contact', 'icon' => 'check-square' ],
    ]
@endphp


  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Sidebar -->
      <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            @foreach ($routes as $route)
              <li class="nav-item">
                <a href="/{{ $route['route'] }}" class="nav-link">
                  <i class="nav-icon fas fa-{{ $route['icon'] }}"></i>
                  <p>{{ $route['name'] }}</p>
                </a>
              </li>
            @endforeach
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
  <!-- Content Wrapper. Contains page content -->
