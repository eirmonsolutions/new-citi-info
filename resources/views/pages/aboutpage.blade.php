@extends('layouts.app')

@section('title', 'About Page')

@section('content')


<section class="banner-area-other">
    <div class="container">
        <div class="banner-text">
            <h1>About Us</h1>
        </div>
    </div>
</section>

<section class="about-deatil-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="left-side-about">
                    <h4>About Us</h4>
                    <p>
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Saepe sequi nobis, voluptate aut tenetur similique! Beatae vel, asperiores a iste illum mollitia laborum animi possimus quibusdam aut accusantium enim totam harum. Aliquam quis, eveniet esse alias quas, modi sed, repellendus voluptatibus at dolores fugit. Soluta unde iure quibusdam delectus autem.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="right-side-about">
                    <img src="{{asset('assets/images/about-imgs/img-1.svg')}}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="about-deatil-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="right-side-about">
                    <img src="{{asset('assets/images/about-imgs/img-1.svg')}}" alt="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="left-side-about">
                    <h4>Why Choose Us</h4>
                    <p>
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Saepe sequi nobis, voluptate aut tenetur similique! Beatae vel, asperiores a iste illum mollitia laborum animi possimus quibusdam aut accusantium enim totam harum. Aliquam quis, eveniet esse alias quas, modi sed, repellendus voluptatibus at dolores fugit. Soluta unde iure quibusdam delectus autem.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="about-deatil-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="left-side-about">
                    <h4>Mission & Vision</h4>
                    <p>
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Saepe sequi nobis, voluptate aut tenetur similique! Beatae vel, asperiores a iste illum mollitia laborum animi possimus quibusdam aut accusantium enim totam harum. Aliquam quis, eveniet esse alias quas, modi sed, repellendus voluptatibus at dolores fugit. Soluta unde iure quibusdam delectus autem.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="right-side-about">
                    <img src="{{asset('assets/images/about-imgs/img-1.svg')}}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>



@endsection