@extends('welcome')
@section('body')
    <section class="w-fit mx-auto">
        @if ($errors->any())
            <div id="error-alert" class="bg-red-600 text-white p-4 rounded-lg shadow-md">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

            <script>
                // Set a timeout to hide the error alert after 5 seconds (5000 milliseconds)
                setTimeout(function () {
                    var errorAlert = document.getElementById('error-alert');
                    if (errorAlert) {
                        errorAlert.style.display = 'none'; // Hide the alert
                    }
                }, 5000); // You can adjust the time as needed
            </script>
        @endif
        @if($isRtl)
            <style>
                body {
                    direction: rtl;
                }
            </style>
        @endif
        <div>
            <input type="text" class=" w-full rounded p-2.5" placeholder="{{__('Search Shelter')}}"
                   style="border: #bcc1ca solid 1px; outline: none" id="search-input" name="location">
            <input type="number" class="hidden" name="location_id" id="location-id-input">
        </div>
        <div class="relative w-full max-h-4" id="autocomplete-section">
            <ul id="autocomplete-list"
                class="absolute max-h-[300px] overflow-y-scroll z-10 w-full bg-white border border-gray-300 rounded-lg hidden">
            </ul>
        </div>
        <select id="dropDown" class="not-active my-2.5 w-full outline-none">
            <option value="listing">{{__('Shelter Listings')}}</option>
            <option value="insert">{{__('Insert Shelters')}}</option>
            <option value="rent">{{__('For Rent')}}</option>
        </select>
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
                        <input class="rounded" style="border: #bcc1ca  solid 1px;" type="text" name="name" id="name"
                               required>
                    </div>
                    <div class="flex-col flex ">
                        <label for="password">{{__('Password:')}}</label>
                        <input class="rounded" style="border: #bcc1ca  solid 1px;" type="password" id="password"
                               name="password" required>
                    </div>
                    <div class="flex-col flex">
                        <label for="phone">{{__('Phone Number:')}}</label>
                        <input class="rounded" style="border: #bcc1ca  solid 1px;" type="text" name="phone" id="phone"
                               required>
                    </div>
                    <div class="flex-col flex ">
                        <label>{{__('Enter a profile picture:')}}</label>
                        <input class="rounded" style="border: #bcc1ca  solid 1px;" type="file" name="self_image"
                               accept="image/, video/" capture required>
                    </div>
                    <div class="flex-col flex ">
                        <label for="image">{{__('Photo Of Driving License:')}}</label>
                        <input class="rounded" style="border: #bcc1ca  solid 1px;" type="file" name="driving_license"
                               id="cameraInput" required>
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
                        <input class="rounded" style="border: #bcc1ca  solid 1px;" type="text" name="name" id="name"
                               required>
                    </div>
                    <div class="flex-col flex">
                        <label for="password">{{__('Password:')}}</label>
                        <input class="rounded" style="border: #bcc1ca  solid 1px;" type="password" id="password"
                               name="password" required>
                    </div>
                    <button class="w-fit block mx-auto px-2.5 py-1 bg-[#636ae8] text-white rounded"
                            type="submit">{{__('Submit')}}</button>
                </form>
            </div>
        </div>
        <div id="ListingResult">
            @foreach($shelters as $shelter)
                <div class="not-active p-2.5 mb-2.5">
                    <p>{{$shelter->city}} , {{$shelter->area}}</p>
                    <p>{{__('Floor No.:')}} {{$shelter->floor_no}}</p>
                    <p>{{__('Number of rooms:')}} {{$shelter->floor_no}}</p>
                    <p>{{__('Capacity:')}} {{$shelter->nb_of_rooms}}</p>
                    @if($shelter->elevator || $shelter->furnished || $shelter->accessibility)
                        <div>
                            {{__('Features:')}}
                            <ul class="list-disc mx-[18px]">
                                @if($shelter->elevator)
                                    <li>{{__('elevator')}}</li>
                                @endif
                                @if($shelter->furnished)
                                    <li>{{__('furnished')}}</li>
                                @endif
                                @if($shelter->accessibility)
                                    <li>{{__('Accessible for people with special needs')}}</li>
                                @endif
                            </ul>
                        </div>
                    @endif
                    <p class="flex items-center gap-2">{{__('Contact:')}} {{$shelter->phone_number}}
                        <a href=""><img src="/assets/whatsapp_icon.svg"></a>
                        <a href=""><img src="/assets/call_us_icon.svg"></a>
                    </p>
                </div>
            @endforeach
        </div>
        <div class="hidden" id="RentalListingResult">
            @foreach($rental_data as $rent)
                <div class="not-active p-2.5 mb-2.5">
                    <p>{{$rent->city}} , {{$rent->area}}</p>
                    <p>{{__('Floor No.:')}} {{$rent->floor_no}}</p>
                    <p>{{__('Number of rooms:')}} {{$rent->floor_no}}</p>
                    <p>{{__('Capacity:')}} {{$rent->nb_of_rooms}}</p>
                    @if($rent->elevator || $rent->furnished || $rent->accessibility)
                        <div>
                            {{__('Features:')}}
                            <ul class="list-disc mx-[18px]">
                                @if($rent->elevator)
                                    <li>{{__('elevator')}}</li>
                                @endif
                                @if($rent->furnished)
                                    <li>{{__('furnished')}}</li>
                                @endif
                                @if($rent->accessibility)
                                    <li>{{__('Accessible for people with special needs')}}</li>
                                @endif
                            </ul>
                        </div>
                    @endif
                    <p>{{__('Rent:')}} {{$rent->price}} {{$rent->currency}}</p>
                    <p class="flex items-center gap-2">{{__('Contact:')}} {{$rent->phone_number}}
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
        let shelter_listing = document.getElementById('ListingResult');
        let insert_listing = document.getElementById('signup_or_login');
        let rentals = document.getElementById('RentalListingResult');
        let signUp = document.getElementById('sign_up');
        let login = document.getElementById('Login');

        function dropDpown() {
            const value = document.getElementById('dropDown').value;
            const signupOrLogin = document.getElementById('signup_or_login');
            const rentalListingResult = document.getElementById('RentalListingResult');
            const ListingResult = document.getElementById('ListingResult');
            // Hide all sections by default
            signupOrLogin.style.display = 'none';
            rentalListingResult.style.display = 'none';
            ListingResult.style.display = 'none';

            // Show the appropriate section based on the selected value
            if (value === 'listing') {
                ListingResult.style.display = 'block';
            } else if (value === 'insert') {
                signupOrLogin.style.display = 'block';
            } else {
                rentalListingResult.style.display = 'block';
            }
        }

        document.getElementById('dropDown').addEventListener('change', dropDpown);

        function toggleListing(activeListing, inactiveListing, idToShow, idToHide) {
            activeListing.classList.toggle('active');
            activeListing.classList.toggle('not-active');
            inactiveListing.classList.toggle('active');
            inactiveListing.classList.toggle('not-active');
            document.getElementById(idToShow).style.display = 'block'
            document.getElementById(idToHide).style.display = 'none'
        }

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
        let loginExists = @json(isset($_GET['login']));
        if (loginExists) {
            document.getElementById('dropDown').value = 'insert'
            dropDpown();
            login.click();
        }
    </script>
    <script>
        const searchInput = document.getElementById('search-input');
        const locationIdInput = document.getElementById('location-id-input');
        const autocompleteList = document.getElementById('autocomplete-list');
        let allLocations = {!! \App\Models\Location::query()->select(['id', 'city'])->get() !!};
        let locations = [];

        // Function to handle locations autocomplete
        function getLocationsAutoComplete(value) {
            locationIdInput.value = '';
            if (value.length < 2) return;

            // Filter the locations
            locations = allLocations.filter(location => {
                return typeof location.city === 'string' &&
                    location.city.toLowerCase().includes(value.toLowerCase());
            });

            autocompleteList.innerHTML = ''; // Clear the list
            if (locations.length > 0) {
                const matches = locations;
                autocompleteList.classList.remove('hidden');

                matches.forEach(match => {
                    const listItem = document.createElement('li');
                    // Highlight the matching text
                    const regex = new RegExp(`(${value})`, 'gi');
                    listItem.innerHTML = match.city.replace(regex, '<strong>$1</strong>'); // Use city instead of name

                    listItem.classList.add('px-3', 'py-2', 'hover:bg-gray-200', 'cursor-pointer');
                    listItem.addEventListener('click', function () {
                        searchInput.value = match.city; // Use city instead of name
                        locationIdInput.value = match.id;
                        autocompleteList.classList.add('hidden');
                        autocompleteList.innerHTML = '';
                    });

                    autocompleteList.appendChild(listItem);
                });
            } else {
                autocompleteList.classList.add('hidden');
            }
        }

        // Input event listener
        searchInput.addEventListener('input', () => {
            if (searchInput.value.length === 0) {
                autocompleteList.classList.add('hidden');
                autocompleteList.innerHTML = '';
                return;
            }
            if (searchInput.value.length < 2) return; // Require at least 2 characters

            getLocationsAutoComplete(searchInput.value);
        });

        // Hide autocomplete when clicking outside
        addEventListener("load", (event) => {
            const autocompleteSection = document.getElementById('autocomplete-section');
            document.addEventListener('click', function (event) {
                if (!autocompleteSection.contains(event.target)) {
                    autocompleteList.classList.add('hidden');
                    autocompleteList.innerHTML = '';
                }
            });
        });

        // Function to handle form submission
        function searchSubmit(event) {
            try {
                event.preventDefault(); // Prevent default form submission
            } catch (e) {
                console.log(e);
            }

            const searchParams = new URLSearchParams();
            const location = searchInput.value;
            const locationId = locationIdInput.value;

            if (location != null && location !== '') searchParams.append('location', location);
            if (locationId != null && locationId !== '') searchParams.append('location_id', locationId);

            // Navigate to the properties page with search parameters
            window.location.href = `/search?${searchParams}`;
        }
    </script>@endsection
