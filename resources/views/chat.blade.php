@extends('layouts.app')

@section('content')
<div class="flex h-screen antialiased text-gray-800">
    <div class="flex flex-row h-full w-full overflow-x-hidden">
        <div class="flex flex-col flex-auto h-full px-6 pb-7 pt-3">
            <div class="flex flex-col flex-auto flex-shrink-0 rounded-2xl bg-blue-50 h-full p-4 shadow-xl">
            <div class="flex flex-row items-center h-16 rounded-xl bg-blue-100 w-full px-4 shadow mb-2">
                <div class="relative">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full flex-shrink-0 shadow-md bg-green-400 border-2 border-green-800">
                        <img src="{{ asset('assets/img/yoda.png') }}" class="h-full w-full" alt="">
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-xl font-semibold text-gray-700">
                        Yoda
                    </p>
                    <p class="text-md font-normal text-gray-800 d-none">
                        typing...
                    </p>
                </div>
                <hr>
            </div>
                <div class="flex flex-col h-full overflow-x-auto mb-4">
                    <div class="flex flex-col h-full">
                        <div class="grid grid-cols-12 gap-y-2">
                            <div class="col-start-1 col-end-8 p-3 rounded-lg">
                                <div class="flex flex-row items-center">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                                        A
                                    </div>
                                    <div class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">
                                        <div>Hey How are you today?</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-start-1 col-end-8 p-3 rounded-lg">
                                <div class="flex flex-row items-center">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                                        A
                                    </div>
                                    <div class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">
                                        <div>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit. Vel ipsa commodi illum saepe numquam maxime
                                            asperiores voluptate sit, minima perspiciatis.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-start-6 col-end-13 p-3 rounded-lg">
                                <div class="flex items-center justify-start flex-row-reverse">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full  bg-green-400 border-2 border-green-800 flex-shrink-0">
                                        <img src="{{ asset('assets/img/yoda.png') }}" class="h-full w-full" alt="">
                                    </div>
                                    <div class="relative mr-3 text-sm bg-green-100 py-2 px-4 shadow rounded-xl">
                                        <div>
                                            Lorem ipsum dolor sit, amet consectetur adipisicing. ?
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-start-1 col-end-8 p-3 rounded-lg">
                                <div class="flex flex-row items-center">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                                        A
                                    </div>
                                    <div class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">
                                        <div>Lorem ipsum dolor sit amet !</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-start-6 col-end-13 p-3 rounded-lg">
                                <div class="flex items-center justify-start flex-row-reverse">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full  bg-green-400 border-2 border-green-800 flex-shrink-0">
                                        <img src="{{ asset('assets/img/yoda.png') }}" class="h-full w-full" alt="">
                                    </div>
                                    <div class="relative mr-3 text-sm bg-green-100 py-2 px-4 shadow rounded-xl">
                                        <div>
                                            Lorem ipsum dolor sit, amet consectetur adipisicing. ?
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="flex flex-row items-center h-16 rounded-xl bg-white w-full px-4 shadow">
                    <div class="flex-grow">
                        <div class="relative w-full">
                            <input type="text" class="flex w-full border rounded-xl focus:outline-none focus:border-indigo-300 pl-4 h-10" />
                        </div>
                    </div>
                    <div class="ml-4">
                        <button class="flex items-center justify-center bg-indigo-500 hover:bg-indigo-600 rounded-xl text-white px-4 py-1 flex-shrink-0">
                            <span>Send</span>
                            <span class="ml-2">
                                <svg class="w-4 h-4 transform rotate-45 -mt-px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
