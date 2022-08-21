@extends('user.user_master')

@section('user')
<div class="middle_content_wrapper">
    <!-- counter_area -->
    <section class="counter_area">
        <div class="row">
            <div class="col-lg-4 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Change Password</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">Current Password</label>
                                <input id="current_password" type="password" name="current_password" class="form-control">
                                @error('current_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">New Password</label>
                                <input id="password" type="password" name="password" class="form-control">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Confirm Password</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control">
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Saved">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection
