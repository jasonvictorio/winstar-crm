@php
    $routes = [
      [ 'route' => 'home2', 'name' => 'Home', 'icon' => 'home' ],
      [ 'route' => 'companies', 'name' => 'Companies', 'icon' => 'building' ],
      [ 'route' => 'users', 'name' => 'Users', 'icon' => 'user-tie' ],
      [ 'route' => 'status', 'name' => 'Status', 'icon' => 'check-square' ],
      [ 'route' => 'customers', 'name' => 'Customers', 'icon' => 'user-friends' ],
      [ 'route' => 'projects', 'name' => 'Projects', 'icon' => 'folder' ],
      [ 'route' => 'contacts', 'name' => 'Contacts', 'icon' => 'address-book' ],
      [ 'route' => 'tasks', 'name' => 'Tasks', 'icon' => 'tasks' ],
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
