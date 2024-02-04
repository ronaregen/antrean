@extends('layout.main')

@section('content')
    <div class="flex w-full h-screen items-center justify-center ">
        <div class="bg-white p-8 rounded shadow-md w-96">
            <img src="{{ asset('image/logo.png') }}" class="mx-auto h-8" alt="">
            <h1 class="text-2xl font-bold mb-4">Login</h1>

            <form action="{{ route('login') }}" method="post">
                @csrf

                <div class="mb-4">
                    <label for="username" class="block text-gray-600 text-sm font-semibold mb-2">Username</label>
                    <input type="text" id="username" name="username"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                        required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-600 text-sm font-semibold mb-2">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                        required>
                </div>

                <button type="submit"
                    class="bg-white border border-fuchsia-500 text-fuchsia-500 px-4 py-2 rounded-full font-semibold hover:bg-fuchsia-600 hover:text-white">Login</button>
            </form>
        </div>
    </div>
@endsection
