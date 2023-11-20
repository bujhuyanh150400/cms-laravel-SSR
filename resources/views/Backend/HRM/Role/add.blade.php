@extends('Layouts.layout_backend')

@section('title',$title)
@section('title-header',$titleHeader)

@section('main')
    <div class="bg-white p-4 rounded-xl shadow-2xl">
        <p class="global-admin-title">{{$titleHeader}}</p>
        <form action="{{route('users/register-role')}}" method="POST">
            @csrf
            @method('POST')
            <div class="py-8 grid grid-cols-2 gap-6">
                <x-input.form-group type="text" id="title" name="title" label="Tên role" placeholder="Nhập tiêu đề"
                                    icon=''/>
                <x-input.form-group type="text" id="description" name="description" label="Ghi chú"
                                    placeholder="Nhập ghi chú" icon=''/>
            </div>
            <div class="flex items-center justify-end gap-2 col-span-full">
                <button type="button" class="btn-non-color"
                        onclick="window.location.href = '{{route('users/list-role')}}'">
                    Huỷ
                </button>
                <button type="submit" class="btn-color">
                    Lưu vai trò
                </button>
            </div>
        </form>
    </div>
@endsection
