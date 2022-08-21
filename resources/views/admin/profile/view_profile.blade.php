@extends('admin.admin_master')

@section('admin')
<div class="sl-pagebody">

    <div class="row row-sm">
      <div class="col-sm-6 col-xl-3">
        <div class="card">
            <img src="{{ (!empty($admin->profile_photo_path))? URL::to('upload/admin_images/'.$admin->profile_photo_path) : URL::to('upload/no_image.jpg') }}" alt="" class="card-img-top">
            <div class="card-body">
                <h5 class="card-title">Name: {{ $admin->name }}</h5>
                <p class="card-text">Email: {{ $admin->email }}</p>
                <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary">Edit Profile</a>
            </div>
        </div>
    </div><!-- row -->
</div><!-- sl-pagebody -->
@endsection
