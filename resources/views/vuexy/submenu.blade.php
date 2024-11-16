<ul class="menu-content">
    @if(isset($menu))
    @foreach($menu as $submenu)
    <li class="{{ (request()->route()->getName() == $submenu['url']) ? 'active' : '' }}">
        <a href="{{ $submenu['url'] }}">
            <i class="{{ isset($submenu['icon']) ? $submenu['icon'] : "" }}"></i>
            <span class="menu-title">{{ $submenu['name'] }}</span>
        </a>
        @if (isset($submenu['submenu']))
            @include('vuexy.submenu', ['menu' => $submenu['submenu']])
        @endif
    </li>
    @endforeach
    @endif
</ul>