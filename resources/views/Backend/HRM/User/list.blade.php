@extends('Layouts.layout_backend')
@section('title', $title)
@section('title-header', $titleHeader)


@section('main')

    <div class="inline-flex items-center justify-between w-full">
        <h1 class="my-2 font-medium text-lg">{{ $titleHeader }}</h1>
        <ul class="inline-flex items-center p-2 gap-2 text-sm rounded-lg bg-gray-300/50">
            <li
                class="bg-white/60 text-purple-800 px-2 py-1 rounded-lg font-medium drop-shadow-2xl border border-white cursor-pointer hover:text-purple-800">
                Danh sách
            </li>
            <li class="font-medium cursor-pointer px-2 py-1 hover:text-purple-800"
                onclick="window.location.href = '{{ route('users/add') }}'">
                Form
            </li>
        </ul>
    </div>

    <div class="relative overflow-x-auto shadow-xl my-4 rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                <tr>
                    <th scope="col" class="px-6 py-4 text-center">
                        Tên
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Vị trí
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Giới tính
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Được đăng nhập
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Thao tác
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="bg-white border-b hover:bg-gray-50 ">
                        <td class="px-6 py-4  text-center">
                            {{ $user->name }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $user->role->first()->title }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $user->gender == 1 ? 'Nam' : 'Nữ' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $user->access_login == \App\Helpers\UserConstant::ACCESS_LOGIN ? 'Có' : 'Không' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center items-center gap-2">
                                <button type="button"
                                        onclick="window.location.href = '{{ route('users/detail',$user->id) }}'"
                                        class="px-4 py-2 rounded-lg bg-[#0E162A] text-white text-sm font-medium duration-200 outline-none border-none hover:-translate-y-0.5 hover:shadow-lg ">
                                    <i class="bi bi-people"></i> Chi tiết
                                </button>
                                <button type="button"
                                        onclick="window.location.href = '{{ route('users/edit',$user->id) }}'"
                                        class="px-4 py-2 rounded-lg bg-gradient-to-br from-violet-900 to-pink-500 text-white text-sm font-medium duration-200 outline-none border-none hover:-translate-y-0.5 hover:shadow-lg ">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {!! $users->links() !!}
    </div>


@endsection
