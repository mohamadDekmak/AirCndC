@extends('welcome')
@section('body')
    <input type="text" class="rounded p-2.5" placeholder="{{__('Search Shelter')}}" style="border: #bcc1ca solid 1px; outline: none">
    <div class="flex gap-4">
        <div class="px-2.5 py-1 w-fit rounded active cursor-pointer" id="shelter_listing">{{__('Shelter Listings')}}</div>
        <div class="px-2.5 py-1 w-fit rounded not-active cursor-pointer" id="insert_shelters">{{__('Insert Shelters')}}</div>
    </div>
    <div>
        <div class="flex gap-4">
            <div class="px-2.5 py-1 w-fit rounded active cursor-pointer" id="sign_up">{{__('Sign Up')}}</div>
            <div class="px-2.5 py-1 w-fit rounded not-active cursor-pointer" id="Login">{{__('Login')}}</div>
        </div>
        <form action="">

        </form>
    </div>
<style>
    .active{
        background: #636ae8;
        color: white;
    }
    .not-active{
        color: #636ae8 ;
        border: #636ae8 solid 1px;
    }
</style>
<script>
    let shelter_listing = document.getElementById('shelter_listing');
    let insert_listing = document.getElementById('insert_shelters');
    let signUp = document.getElementById('sign_up');
    let login = document.getElementById('Login');

    // Function to toggle active classes
    function toggleListing(activeListing, inactiveListing) {
        activeListing.classList.toggle('active');
        activeListing.classList.toggle('not-active');
        inactiveListing.classList.toggle('active');
        inactiveListing.classList.toggle('not-active');
    }

    shelter_listing.addEventListener('click', function () {
        toggleListing(shelter_listing, insert_listing);
    });

    insert_listing.addEventListener('click', function () {
        toggleListing(insert_listing, shelter_listing);
    });
    signUp.addEventListener('click', function () {
        toggleListing(signUp, login);
    });
    login.addEventListener('click', function () {
        toggleListing(login, signUp);
    });
</script>
@endsection
