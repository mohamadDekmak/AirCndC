@extends('welcome')
@section('body')
    @php
        $i = 1;
    @endphp
    <section class="mx-auto w-fit">
        @if($isRtl)
            <style>
                body {
                    direction: rtl;
                }
            </style>
        @endif
        <a class="flex justify-center" href="{{route('home' , ['locale' => $locale])}}"><img class="w-[20px]"
                                                                                             src="/assets/arrow_left.svg"
                                                                                             alt=""> {{__('Back To Home')}}
        </a>
        <div class="flex gap-4 justify-center my-2.5">
            <div class="px-2.5 py-1 w-full min-w-[150px] text-center rounded active cursor-pointer"
                 id="shelter_listing">{{__('Shelter Listings')}}</div>
            <div class="px-2.5 py-1 w-full min-w-[150px] text-center rounded not-active cursor-pointer"
                 id="insert_shelters">{{__('Insert Shelters')}}</div>
        </div>
        @if ($errors->any())
            <div id="error-alert" class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

            <script>
                setTimeout(function () {
                    var errorAlert = document.getElementById('error-alert');
                    if (errorAlert) {
                        errorAlert.style.display = 'none';
                    }
                }, 5000);
            </script>
        @endif
        {{--        @if(session('success'))--}}
        {{--            <p class="text-green-600">{{ session('success') }}</p>--}}
        {{--        @endif--}}
        <div id="listing">
            @foreach($shelters as $shelter)
                <div class="not-active p-2.5 relative mb-2.5">
                    <p>{{$shelter->city}} , {{$shelter->area}}</p>
                    <p>{{__('Floor No.:')}} {{$shelter->floor_no}}</p>
                    <p>{{__('Number of rooms:')}} {{$shelter->nb_of_rooms}}</p>
                    <p>{{__('Capacity:')}} {{$shelter->capacity}}</p>
                    @if($shelter->elevator || $shelter->furnished || $shelter->accessibility)
                        <div>
                            {{__('Features:')}}
                            <ul class="list-disc mx-[18px] max-w-[230px]">
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
                    @if($shelter->price)
                        <p>{{__('Rent:')}} {{$shelter->price}}</p>
                    @endif
                    <p class="flex items-center gap-2 ">{{__('Contact:')}} {{$shelter->phone_number}}
                        <a href="https://wa.me/{{$shelter->phone_number}}" target="_blank"><img
                                src="/assets/whatsapp_icon.svg"></a>
                        <a href="tel:{{$shelter->phone_number}}"><img src="/assets/call_us_icon.svg"></a>
                    </p>
                    @if($locale == 'en')
                        <div class="editAndDelete absolute right-[15px] bottom-[35px]">
                            @else
                                <div class="editAndDelete absolute left-[15px] bottom-[35px]">
                                    @endif
                                    <p onclick="openDeletePopup('Edit-'+{{$shelter->id}})"
                                       class="cursor-pointer flex justify-between items-center text-center w-[85px] mb-1 not-active py-[3px] px-[10px] rounded-[5px]">
                                        Edit<img class="w-[20px]" src="/assets/update.svg" alt="">
                                    </p>
                                    <p onclick="openDeletePopup('Delete-'+{{$shelter->id}})"
                                       class="cursor-pointer flex justify-between items-center text-center w-[85px] mb-1 not-active py-[3px] px-[10px] rounded-[5px]">
                                        Delete <img class="w-[20px]" src="/assets/delete.svg" alt="">
                                    </p>
                                    <div id="Edit-{{$shelter->id}}" class="modal">
                                        <div class="modal-content">
                                            <span class="close" onclick="closeDeletePopup('Edit-'+{{$shelter->id}})">&times;</span>
                                            <form
                                                action="{{ route('updateData' , ['locale' => $locale , 'id' => $shelter->id]) }}"
                                                class="flex flex-col gap-4 Forms"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="flex-col flex">
                                                    <label for="city">{{ __('City:') }}</label>
                                                    <input class="rounded border-gray-400 border solid" type="text"
                                                           name="city"
                                                           id="city" required value="{{$shelter->city}}">
                                                </div>

                                                <div class="flex-col flex">
                                                    <label for="area">{{ __('Area:') }}</label>
                                                    <input type="text" class="rounded border-gray-400 border solid"
                                                           name="area"
                                                           id="area" required value="{{$shelter->area}}">
                                                </div>

                                                <div class="flex-col flex">
                                                    <label for="floor_no">{{ __('Floor No.:') }}</label>
                                                    <input class="rounded border-gray-400 border solid" type="number"
                                                           step="any"
                                                           name="floor_no"
                                                           id="floor_no" required value="{{$shelter->floor_no}}">
                                                </div>

                                                <div class="flex-col flex">
                                                    <label for="nb_of_rooms">{{ __('Number of rooms:') }}</label>
                                                    <input class="rounded border-gray-400 border solid" type="number"
                                                           step="any"
                                                           name="nb_of_rooms"
                                                           id="nb_of_rooms" required value="{{$shelter->nb_of_rooms}}">
                                                </div>

                                                <div class="flex-col flex">
                                                    <label for="capacity">{{ __('Capacity:') }}</label>
                                                    <input class="rounded border-gray-400 border solid" type="text"
                                                           name="capacity"
                                                           id="capacity"
                                                           required value="{{$shelter->capacity}}">
                                                </div>
                                                <div class="flex-col flex">
                                                    <label for="phone_number">{{ __('Phone Number:') }}</label>
                                                    <input class="rounded border-gray-400 border solid" type="text"
                                                           name="phone_number"
                                                           id="phone_number" required
                                                           value="{{$shelter->phone_number}}">
                                                </div>
                                                <div class="">
                                                    <label for="furnished">{{ __('furnished') }}</label>
                                                    <input type="checkbox" name="furnished" id="furnished"
                                                           value="1" {{($shelter->furnished != null ) ?'checked':''}}>
                                                </div>
                                                <div class="">
                                                    <label
                                                        for="accessibility">{{ __('accessibility for people with special needs') }}</label>
                                                    <input type="checkbox" name="accessibility" id="accessibility"
                                                           value="1" {{($shelter->accessibility != null ) ?'checked':''}}>
                                                </div>

                                                <div class="">
                                                    <label for="elevator">{{ __('elevator') }}</label>
                                                    <input type="checkbox" name="elevator" id="elevator"
                                                           value="1" {{($shelter->elevator != null ) ?'checked':''}}>
                                                </div>
                                                <div class="">
                                                    <label for="rent_or_no">{{ __('For Rent ?') }}</label>
                                                    <input type="hidden" name="rent_or_no" id="hidden-rent-{{$i}}">
                                                    <input class="checkForRent" type="checkbox"
                                                           id="rent-{{$i}}" {{($shelter->rent_or_no != 0) ?'checked':''}}>
                                                </div>
                                                    <?php
                                                    $i++;
                                                    ?>
                                                @if($shelter->price != null)
                                                    <div class="flex-col Prices" id="price-{{$shelter->id}}">
                                                        @else
                                                            <div class="flex-col hidden Prices">
                                                                @endif
                                                                <label>{{ __('Price:') }}</label>
                                                                <div class="flex">
                                                                    <input
                                                                        class="rounded border-gray-400 border solid rentPrice"
                                                                        name="price" id="price-input-{{$shelter->id}}"
                                                                        type="number"
                                                                        step="any"
                                                                        value="{{($shelter->price != null)?$shelter->price:''}}">
                                                                    <select class="outline-none"
                                                                            id="currency-select-{{$shelter->id}}"
                                                                            name="currency">
                                                                        <option
                                                                            value="$" {{($shelter->currency == '$')?'selected':''}}>
                                                                            USD
                                                                        </option>
                                                                        <option
                                                                            value="LB" {{($shelter->currency == 'LB')?'selected':''}}>
                                                                            LB
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <button type="submit"
                                                                    class="mt-4 bg-blue-500 text-white rounded py-2">
                                                                Submit
                                                            </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div id="Delete-{{$shelter->id}}" class="modal">
                                        <div class="modal-content">
                                <span class="close"
                                      onclick="closeDeletePopup('Delete-'+{{$shelter->id}})">&times;</span>
                                            <form
                                                action="{{ route('function.destroy' , [ 'id' => $shelter->id , 'locale' => $locale] ) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <h1 class="text-center">{{__('Are you sure?')}}</h1>
                                                <button
                                                    class=" mx-auto flex items-center justify-center w-[85px] not-active py-[3px] px-[10px] rounded-[5px]">
                                                    {{__('Submit')}}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        @endforeach
                </div>
                <div class=" hidden bg-white p-6 rounded shadow-md w-full max-w-md mx-auto" id="add_shelter">
                    <h1 class="text-xl font-semibold mb-4">{{ __('Add Shelter') }}</h1>
                    <form action="{{ route('shelters.store' , ['locale' => $locale]) }}" class="flex flex-col gap-4"
                          method="POST" enctype="multipart/form-data" id="form-0">
                        @csrf
                        <div class="flex-col flex">
                            <label for="city">{{ __('City:') }}</label>
                            <input class="rounded border-gray-400 border solid" type="text" name="city" id="city"
                                   required>
                        </div>

                        <div class="flex-col flex">
                            <label for="area">{{ __('Area:') }}</label>
                            <input type="text" class="rounded border-gray-400 border solid" name="area" id="area"
                                   required>
                        </div>

                        <div class="flex-col flex">
                            <label for="floor_no">{{ __('Floor No.:') }}</label>
                            <input class="rounded border-gray-400 border solid" type="number" step="any" name="floor_no"
                                   id="floor_no" required>
                        </div>

                        <div class="flex-col flex">
                            <label for="nb_of_rooms">{{ __('Number of rooms:') }}</label>
                            <input class="rounded border-gray-400 border solid" type="number" step="any"
                                   name="nb_of_rooms"
                                   id="nb_of_rooms" required>
                        </div>

                        <div class="flex-col flex">
                            <label for="capacity">{{ __('Capacity:') }}</label>
                            <input class="rounded border-gray-400 border solid" type="text" name="capacity"
                                   id="capacity"
                                   required>
                        </div>
                        <div class="flex-col flex">
                            <label for="phone_number">{{ __('Phone Number:') }}</label>
                            <input class="rounded border-gray-400 border solid" type="text" name="phone_number"
                                   id="phone_number" required>
                        </div>
                        <div class="">
                            <label for="furnished">{{ __('furnished') }}</label>
                            <input type="checkbox" name="furnished" id="furnished" value="1">
                        </div>
                        <div class="">
                            <label for="accessibility">{{ __('accessibility for people with special needs') }}</label>
                            <input type="checkbox" name="accessibility" id="accessibility" value="1">
                        </div>

                        <div class="">
                            <label for="elevator">{{ __('elevator') }}</label>
                            <input type="checkbox" name="elevator" id="elevator" value="1">
                        </div>
                        <div class="">
                            <label for="rent_or_no">{{ __('For Rent ?') }}</label>
                            <input type="hidden" name="rent_or_no" id="rent-0">
                            <input type="checkbox" id="rent">
                        </div>
                        <div class="flex-col hidden" id="price">
                            <label>{{ __('Price:') }}</label>
                            <div class="flex">
                                <input class="rounded border-gray-400 border solid" id="price-input-0" name="price"
                                       type="number" step="any">
                                <select class="outline-none" id="currency-select-0" name="currency">
                                    <option value="$">USD</option>
                                    <option value="LB">LB</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="mt-4 bg-blue-500 text-white rounded py-2">Submit</button>
                    </form>
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

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 310px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

    </style>
    <script>
        let rentOPtion = document.getElementById('rent')
        let price = document.getElementById('price')
        let forms = document.querySelectorAll('.Forms')
        let prices = document.querySelectorAll('.Prices');
        let checkRents = document.querySelectorAll('.checkForRent');
        let rents = document.querySelectorAll('.rentPrice');

        rentOPtion.addEventListener('change', function () {
            if (rentOPtion.checked) {
                price.style.display = 'flex';
            } else {
                price.style.display = 'none';
            }
        })
        document.getElementById('form-0').addEventListener('submit', function (event) {
            event.preventDefault();
            if (rentOPtion.checked) {
                document.getElementById('rent-0').value = 1;
            } else {
                document.getElementById('rent-0').value = 0;
            }
            document.getElementById('form-0').submit();
        })
        for (let i = 0; i < forms.length; i++) {
            forms[i].addEventListener('submit', function (event) {
                event.preventDefault();
                if (checkRents[i].checked) {
                    document.getElementById('hidden-rent-' + (i + 1)).value = 1;
                } else {
                    document.getElementById('hidden-rent-' + (i + 1)).value = 0;
                }
                forms[i].submit();
            })
        }
        for (let i = 0; i < checkRents.length; i++) {
            checkRents[i].addEventListener('change', function () {
                if (checkRents[i].checked) {
                    prices[i].style.display = 'flex';
                } else {
                    prices[i].style.display = 'none';
                    rents[i].value = "";
                }
            });
        }

        let shelter_listing = document.getElementById('shelter_listing');
        let insert_listing = document.getElementById('insert_shelters');

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
                toggleListing(shelter_listing, insert_listing, 'listing', 'add_shelter');
            }
        });

        insert_listing.addEventListener('click', function () {
            if (insert_listing.classList.contains('not-active')) {
                toggleListing(insert_listing, shelter_listing, 'add_shelter', 'listing');
            }
        });

        function openDeletePopup(id) {
            document.getElementById(id).style.display = 'block'
        }

        function closeDeletePopup(id) {
            document.getElementById(id).style.display = 'none'
        }
    </script>

@endsection
