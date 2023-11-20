<div id="navmenu__left-section">
    <div class="sticky top-5 left-0">
        <div class="relative flex flex-col text-white p-3">
            <div class="inline-flex items-center mb-8">
                <div
                    class="bg-amber-300 text-2xl text-blue-900 px-2 py-1 rounded-full block float-left mr-2 duration-500">
                    <i class="bi bi-dribbble "></i>
                </div>
                <h1 class="duration-200 font-bold text-sm">Admin panel Dashboard</h1>
            </div>
            <ul id="navmenu__left-container">
                @foreach ($list_menu as $key => $menu)
                    @if (isset($menu['space_menu']) && $menu['space_menu'] === true)
                        <li class="my-1">
                            <span class="text-sm text-gray-400 font-bold">{{ $menu['title'] }}</span>
                        </li>
                    @else
                        <li class="navmenu__left-item {{ !isset($menu['sub_menu']) && $curret_route === $menu['route_name'] ? 'bg-[#1E283A] font-medium' : '' }}"
                            @if (!isset($menu['sub_menu'])) onclick="return window.location.href = '{{ $menu['action'] }}'" @else data-sub-key="{{ $key }}" @endif>
                            <div class="text-xl">
                                {!! $menu['icon'] !!}
                            </div>
                            <span class="inline-flex justify-between w-full">
                                {{ $menu['title'] }}
                                @if (isset($menu['sub_menu']))
                                    <i class="bi bi-chevron-down duration-200"></i>
                                @endif
                            </span>
                        </li>
                        @if (isset($menu['sub_menu']))
                            <ul class="navmenu__left-sub-item" data-key='{{ $key }}'>
                                @foreach ($menu['sub_menu'] as $sub_menu)
                                    <li class="relative border-s ms-6 p-2"
                                        @if ($curret_route === $sub_menu['route_name']) data-active="true" @endif>
                                        <a class="text-sm py-2 ps-2 rounded-md duration-150 hover:bg-[#1E283A] {{ $curret_route === $sub_menu['route_name'] ? 'bg-[#1E283A] font-medium' : '' }}"
                                            href="{{ $sub_menu['action'] }}">
                                            <span class="inline-flex justify-between w-full">
                                                {{ $sub_menu['title'] }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
