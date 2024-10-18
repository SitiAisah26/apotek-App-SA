@extends('layout.layout')

@section('content')
        <form action="{{ route('login.auth') }}" class="card p-5" method="POST" autocomplete="off">
            @csrf
            @if (Session::get('failed'))
                <div class="alert alert-danger">{{ Session::get('failed') }}</div>
            @endif
            @if (Session::get('logout'))
                <div class="alert alert-danger">{{ Session::get('logout') }}</div>
            @endif
            @if (Session::get('canAccess'))
                <div class="alert alert-danger">{{ Session::get('canAccess') }}</div>
            @endif
            <div class="mb-3">
                <label for="email" class="from-label">Email</label>
                <input type="email" name="email" id="email" class="form-control">
                @error('email')
                    <small class="text-danger">{{ massage }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control">
                @error('password')
                    <small class="text-danger">{{ massage }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
@endsection
