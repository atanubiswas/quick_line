<ul class="nav nav-pills nav-sidebar flex-column nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Developer Billing -->
    <li class="nav-item">
        <a href="{{ route('admin.billing.developer_generate') }}" class="nav-link {{ Request::is('admin/billing/developer-generate-bill*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-invoice"></i>
            <p>Developer Billing</p>
        </a>
    </li>
    
    @foreach($menues as $menu)
    <li style="margin-bottom: 10px;" class="nav-item @foreach($menu->adminMenu->children as $child) @if(Request::is((string)$child->request)) menu-open @endif @endforeach">
        <a href="@if($menu->adminMenu->route!='#'){{Route((string)$menu->adminMenu->route)}}@else # @endif" class="nav-link @if(Request::is((string)$menu->adminMenu->request))  active @endif @foreach($menu->adminMenu->children as $child) @if(Request::is((string)$child->request)) active @endif @endforeach">
            <i class="nav-icon fas {{$menu->adminMenu->icon}}"></i>
            <p>
                {{$menu->adminMenu->menu_name}}
                @if(count($menu->adminMenu->children)>0)
                <i class="right fas fa-angle-left"></i>
                @endif
            </p>
        </a>
        @if(count($menu->adminMenu->children)>0)
        <ul class="nav nav-treeview">
            @foreach($menu->adminMenu->children as $child)
              <li class="nav-item">
                <a href="{{Route((string)$child->route)}}" class="nav-link @if(Request::is((string)$child->request))  active @endif">
                  <i class="fas {{$child->icon}} nav-icon"></i>
                  <p style="font-size: 14px;">{{$child->menu_name}}</p>
                </a>
              </li>
            @endforeach
        </ul>
        @endif
    </li>
    @endforeach
</ul>