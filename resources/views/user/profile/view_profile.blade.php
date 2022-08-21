@extends('user.user_master')

@section('user')
<div class="middle_content_wrapper">
    <!-- counter_area -->
    <section class="counter_area">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <img src="{{ (!empty($user->profile_photo_path))? URL::to('upload/user_images/'.$user->profile_photo_path) : URL::to('upload/no_image.jpg') }}" alt="" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Name: {{ $user->name }}</h5>
                        <p class="card-text">Email: {{ $user->email }}</p>
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection
