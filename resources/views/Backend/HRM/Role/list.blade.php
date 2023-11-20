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
                onclick="window.location.href = '{{ route('role/register') }}'">
                Form
            </li>
        </ul>
    </div>
@endsection
