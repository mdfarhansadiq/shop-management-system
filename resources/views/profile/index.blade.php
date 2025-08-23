
@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>My Profile</h2>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Profile Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                   id="city" name="city" value="{{ old('city', $user->city) }}" required>
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="store_name" class="form-label">Store Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('store_name') is-invalid @enderror" 
                               id="store_name" name="store_name" value="{{ old('store_name', $user->store_name) }}" required>
                        @error('store_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>
                    <h6>Change Password</h6>
                    <p class="text-muted">Leave blank if you don't want to change your password.</p>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Account Information</h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-6">Name:</dt>
                    <dd class="col-sm-6">{{ $user->name }}</dd>
                    
                    <dt class="col-sm-6">Email:</dt>
                    <dd class="col-sm-6">{{ $user->email }}</dd>
                    
                    <dt class="col-sm-6">Store:</dt>
                    <dd class="col-sm-6">{{ $user->store_name }}</dd>
                    
                    <dt class="col-sm-6">City:</dt>
                    <dd class="col-sm-6">{{ $user->city }}</dd>
                    
                    <dt class="col-sm-6">Joined:</dt>
                    <dd class="col-sm-6">{{ $user->created_at->format('M d, Y') }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
