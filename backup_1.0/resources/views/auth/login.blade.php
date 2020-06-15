@extends('layouts.app')

@section('login')
<div class="container">
    <div class="row justify-content-center form-inline">
        <div class="row-md-6">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group row">
                    <div class="form-group">
                        <div class="row-md-6">
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" maxlength="13" pattern="[0-9]{13}" placeholder="เลขบัตรประชาชน">
                            @error('username')
                            <div class="alert alert-primary" role="alert">
                                <strong>บัตรประชาชนหรือรหัสผ่านไม่ถูกต้อง</strong>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="รหัสผ่าน">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>บัตรประชาชนหรือรหัสผ่านไม่ถูกต้อง</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        {{ __('เข้าสู่ระบบ') }}
                    </button>
                </div>
                <div class="form-group row mb-0 ">
                    <div class="row-md-4 ml-auto form-inline">
                        @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('ลืมรหัสผ่าน') }}
                        </a>
                        @endif
                        <a class="nav-link" href="{{ route('register') }}">{{ __('ลงทะเบียน') }}</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection