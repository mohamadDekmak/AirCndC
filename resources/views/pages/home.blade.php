@extends('welcome')
@section('body')
    <section class="w-fit mx-auto">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if($isRtl)
            <style>
                body {
                    direction: rtl;
                }
            </style>
        @endif
        <input type="text" class=" w-full rounded p-2.5" placeholder="{{__('Search Shelter')}}"
               style="border: #bcc1ca solid 1px; outline: none">
        <div class="flex gap-4 justify-center my-2.5">
            <div class="px-2.5 py-1 w-full min-w-[150px] text-center rounded active cursor-pointer"
                 id="shelter_listing">{{__('Shelter Listings')}}</div>
            <div class="px-2.5 py-1 w-full min-w-[150px] text-center rounded not-active cursor-pointer"
                 id="insert_shelters">{{__('Insert Shelters')}}</div>
        </div>
        <div class="hidden" id="signup_or_login">
            <div class=" flex gap-4 justify-center" id="">
                <div class="px-2.5 py-1 w-full min-w-[150px] text-center rounded active cursor-pointer"
                     id="sign_up">{{__('Sign Up')}}</div>
                <div class="px-2.5 py-1 w-full min-w-[150px] text-center rounded not-active cursor-pointer"
                     id="Login">{{__('Login')}}</div>
            </div>
            <div class="my-2.5" id="signUpForm">
                <form action="{{ route('user.store' , ['locale' => $locale]) }}" class="flex flex-col gap-2"
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex-col flex">
                        <label for="name">{{__('Username:')}}</label>
                        <input class="rounded" style="border: #bcc1ca  solid 1px;" type="text" name="name" id="name">
                    </div>
                    <div class="flex-col flex ">
                        <label for="password">{{__('Password:')}}</label>
                        <input class="rounded" style="border: #bcc1ca  solid 1px;" type="password" id="password"
                               name="password">
                    </div>
                    <div class="flex-col flex">
                        <label for="phone">{{__('Phone Number:')}}</label>
                        <input class="rounded" style="border: #bcc1ca  solid 1px;" type="text" name="phone" id="phone">
                    </div>
                    <div class="flex-col flex ">
                        <label>{{__('Enter a profile picture:')}}</label>
                        <input class="rounded" style="border: #bcc1ca  solid 1px;" type="file" name="self_image">
                    </div>
                    <div class="flex-col flex ">
                        <label for="image">{{__('Photo Of Driving License:')}}</label>
                        <input class="rounded" style="border: #bcc1ca  solid 1px;" type="file" name="driving_license"
                               id="cameraInput" accept="image/, video/" capture>
                    </div>
                    <button class="w-fit block mx-auto px-2.5 py-1 bg-[#636ae8] text-white rounded"
                            type="submit">{{__('Submit')}}</button>
                </form>
            </div>
            <div class="hidden my-2.5" id="loginForm">
                <form action="{{ route('user.login', ['locale' => $locale])  }}" method="post"
                      class="flex flex-col gap-2">
                    @csrf
                    <div class="flex-col flex">
                        <label for="name">{{__('Username:')}}</label>
                        <input class="rounded" style="border: #bcc1ca  solid 1px;" type="text" name="name" id="name">
                    </div>
                    <div class="flex-col flex">
                        <label for="password">{{__('Password:')}}</label>
                        <input class="rounded" style="border: #bcc1ca  solid 1px;" type="password" id="password"
                               name="password">
                    </div>
                    <button class="w-fit block mx-auto px-2.5 py-1 bg-[#636ae8] text-white rounded"
                            type="submit">{{__('Submit')}}</button>
                </form>
            </div>
        </div>
        <div id="shelterListingResult">
            @foreach($shelters as $shelter)
                <div class="not-active p-2.5">
                    <p>{{$shelter->city}} , {{$shelter->area}}</p>
                    <p>{{__('Floor No.:')}} {{$shelter->floor_no}}</p>
                    <p>{{__('Number of rooms:')}} {{$shelter->floor_no}}</p>
                    <p>{{__('Capacity:')}} {{$shelter->nb_of_rooms}}</p>
                    @if($shelter->elevator || $shelter->furnished)
                        <div>
                            {{__('Features:')}}
                            <ul class="list-disc mx-[18px]">
                                @if($shelter->elevator)
                                    <li>{{__('elevator')}}</li>
                                @endif
                                @if($shelter->furnished)
                                    <li>{{__('furnished')}}</li>
                                @endif
                            </ul>
                        </div>
                    @endif
                    <p class="flex items-center gap-2">Contact:{{$shelter->}}
                        <a href=""><img src="/assets/whatsapp_icon.svg"></a>
                        <a href=""><img src="/assets/call_us_icon.svg"></a>
                    </p>
                </div>
            @endforeach
        </div>
    </section>
    <style>
        .active {
            background: #636ae8;
            color: white;
        }

        .not-active {
            color: #636ae8;
            border: #636ae8 solid 1px;
        }
    </style>
    <script>
        let shelter_listing = document.getElementById('shelter_listing');
        let insert_listing = document.getElementById('insert_shelters');
        let signUp = document.getElementById('sign_up');
        let login = document.getElementById('Login');

        function toggleListing(activeListing, inactiveListing, idToShow, idToHide) {
            activeListing.classList.toggle('active');
            activeListing.classList.toggle('not-active');
            inactiveListing.classList.toggle('active');
            inactiveListing.classList.toggle('not-active');
            document.getElementById(idToShow).style.display = 'block'
            document.getElementById(idToHide).style.display = 'none'
        }

        shelter_listing.addEventListener('click', function () {
            if (shelter_listing.classList.contains('not-active')) {
                toggleListing(shelter_listing, insert_listing, 'shelterListingResult', 'signup_or_login');
            }
        });

        insert_listing.addEventListener('click', function () {
            if (insert_listing.classList.contains('not-active')) {
                toggleListing(insert_listing, shelter_listing, 'signup_or_login', 'shelterListingResult');
            }
        });
        signUp.addEventListener('click', function () {
            if (signUp.classList.contains('not-active')) {
                toggleListing(signUp, login, 'signUpForm', 'loginForm');
            }
        });
        login.addEventListener('click', function () {
            if (login.classList.contains('not-active')) {
                toggleListing(login, signUp, 'loginForm', 'signUpForm');
            }
        });
    </script>
@endsection
