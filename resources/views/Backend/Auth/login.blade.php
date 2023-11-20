<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$title ?? 'LARAVEL'}}</title>
    @vite(['resources/css/app.css', 'resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
<main class="w-screen h-screen grid grid-cols-2">
    <div class="h-auto flex flex-col justify-center gap-5 p-5 bg-white z-10 w-full">
        <h1 class="text-5xl font-bold mb-2 text-purple-700">Welcome back</h1>
        <h2 class="text-md font-normal mb-5 text-gray-500">Hãy điền email và password để đăng nhập</h2>
        @error('login')
        <div class="p-4 my-2 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
            <span class="font-medium">{{ $message }}</span>
        </div>
        @enderror
        <form method="POST" action="{{route('login-admin')}}">
            @csrf
            @method('POST')
            <div class="flex flex-col gap-5 justify-items-start items-start">
                <div class="flex flex-col gap-2 w-full">
                    <label class="text-sm font-medium  @error('email') text-red-500 @enderror" for="email">
                        <i class="bi bi-envelope me-1"></i>
                        Email
                    </label>
                    <input value="{{ old('email') }}"
                           class="rounded-lg p-2 outline-purple-300 text-sm border duration-200 focus:shadow-md @error('email') border-red-300 outline-red-300 @enderror"
                           type="email" id="email" name="email" placeholder="Example@example.com" />
                    @error('email')
                    <span class="text-red-500 text-xs font-medium">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <label class="text-sm font-medium  @error('password') text-red-500 @enderror" for="password">
                        <i class="bi bi-lock me-1"></i>
                        Mật khẩu
                    </label>
                    <input value="{{ old('password') }}"
                           class="rounded-lg p-2 outline-purple-300 text-sm border duration-200 focus:shadow-md @error('password') border-red-300 outline-red-300 @enderror"
                           type="password" id="password" name="password" placeholder="Nhập mật khẩu" />
                    @error('password')
                    <span class="text-red-500 text-xs font-medium">{{ $message }}</span>
                    @enderror
                </div>
                <label class="relative inline-flex items-center my-4 cursor-pointer">
                    <input type="checkbox" name="remember_me" value="1"
                           class="sr-only peer" {{ old('remember_me') ? 'checked' : '' }}>
                    <div
                        class="w-9 h-5 bg-gray-100 rounded-full peer peer-focus:ring-3 peer-focus:ring-purple-300 dark:peer-focus:ring-purple-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute ease-in-out duration-300 after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-purple-400">
                    </div>
                    <span class="ml-3 text-sm font-medium text-gray-900">Remember login</span>
                </label>
                <button type="submit"
                        class="w-full px-4 py-2 rounded-lg bg-gradient-to-br from-violet-900 to-pink-500 text-white text-sm font-medium duration-200 outline-none border-none hover:-translate-y-0.5 hover:shadow-lg ">
                    Đăng nhập
                </button>
            </div>

        </form>
    </div>
    <div class="w-full h-full p-10 ">
        <div class="bg-gradient-to-br from-violet-900 to-pink-500 w-full h-full rounded-2xl shadow-2xl">
        </div>
    </div>
</main>
</body>
</html>
