{{--Manage Settings--}}
<li class="nav-item">
    <a href="{{ route('settings') }}" class="nav-link nav-link1 {{ in_array(Route::currentRouteName(), ['settings',]) ? 'active' : '' }}"><i class="icon-gear"></i> <span>Settings</span></a>
</li>

{{--Pins--}}
<li style="width:202px;background-color:#263238;transform:translateY(-5px);" class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['pins.create', 'pins.index']) ? 'nav-item-expanded nav-item-open' : '' }} ">
    <a href="#" class="nav-link nav-link1" ><i class="icon-lock2"></i> <span> Pins</span></a>

    <ul class="nav nav-group-sub" data-submenu-title="Manage Pins">
        {{--Generate Pins--}}
            <li class="nav-item">
                <a href="{{ route('pins.create') }}"
                   class="nav-link nav-link1 {{ (Route::is('pins.create')) ? 'active' : '' }}">Generate Pins</a>
            </li>

        {{--    Valid/Invalid Pins  --}}
        <li class="nav-item">
            <a href="{{ route('pins.index') }}"
               class="nav-link nav-link1 {{ (Route::is('pins.index')) ? 'active' : '' }}">View Pins</a>
        </li>
    </ul>
</li>
