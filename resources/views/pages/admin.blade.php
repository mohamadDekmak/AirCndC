@extends('welcome')
@section('body')
    @if($isRtl)
        <style>
            body{
                direction: rtl;
            }
        </style>
    @endif
    @php
//    dd(auth()->id())
    @endphp
    <div class="bg-white p-6 rounded shadow-md w-full max-w-md mx-auto">
        <h1 class="text-xl font-semibold mb-4">{{ __('Add Shelter') }}</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session('success'))
            <p class="text-green-600">{{ session('success') }}</p>
        @endif

        <form action="{{ route('shelters.store' , ['locale' => $locale]) }}" class="flex flex-col gap-4" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex-col flex">
                <label for="city">{{ __('City:') }}</label>
                <input class="rounded border-gray-400 border solid" type="text" name="city" id="city" required>
            </div>

            <div class="flex-col flex">
                <label for="area">{{ __('Area:') }}</label>
                <input type="text" class="rounded border-gray-400 border solid" name="area" id="area" required>
            </div>

            <div class="flex-col flex">
                <label for="floor_no">{{ __('Floor No.:') }}</label>
                <input class="rounded border-gray-400 border solid" type="number" step="any" name="floor_no" id="floor_no" required>
            </div>

            <div class="flex-col flex">
                <label for="nb_of_rooms">{{ __('Number of rooms:') }}</label>
                <input class="rounded border-gray-400 border solid" type="number" step="any" name="nb_of_rooms" id="nb_of_rooms" required>
            </div>

            <div class="flex-col flex">
                <label for="capacity">{{ __('Capacity:') }}</label>
                <input class="rounded border-gray-400 border solid" type="text" name="capacity" id="capacity" required>
            </div>
            <div class="">
                <label for="furnished">{{ __('furnished') }}</label>
                <input type="checkbox" name="furnished" id="furnished" value="1">
            </div>

            <div class="">
                <label for="elevator">{{ __('elevator') }}</label>
                <input type="checkbox" name="elevator" id="elevator" value="1">
            </div>
            <div class="">
                <label for="rent">{{ __('For Rent ?') }}</label>
                <input type="checkbox" name="rent" id="rent" value="1">
            </div>
            <div class="flex-col hidden" id="price">
                <label for="price">{{ __('Price:') }}</label>
                <input class="rounded border-gray-400 border solid" type="number" step="any" name="price" id="price">
            </div>

            <button type="submit" class="mt-4 bg-blue-500 text-white rounded py-2">Submit</button>
        </form>
    </div>
    <script>
        let rentOPtion = document.getElementById('rent')
        let price = document.getElementById('price')
        rentOPtion.addEventListener('change' , function (){
            if(rentOPtion.checked){
                price.style.display = 'flex';
            }
            else{
                price.style.display = 'none';
            }
        })
    </script>
@endsection
