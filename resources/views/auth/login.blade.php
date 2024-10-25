@extends("layouts.default")
@section('content')
<div class="container mt-4 mb-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h4 class="card-header">Login</h4>
               <x-error />

                <div class="card-body">
                    <form action="{{ route('login') }}"  method="POST" class="rd-form">
                        @csrf
                        <div class="row row-20 gutters-20">
                            <div class="col-md-6">
                                <div class="form-wrap">
                                    <input type="email" name="email" value="{{ old('email') }}" 
                                    id="email" autocomplete="email"  
                                    class="form-input" autofocus>
                                    <label for="email" class="form-label">Your E-mail</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-wrap">
                                    <input type="password" name="password" value="" 
                                    id="password" class="form-input">
                                    <label for="email" class="form-label">Your password</label>
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-wrap">
                                    <div class="form-check-input">
                                        <input type="checkbox" name="remember" 
                                        id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
                                        <label for="remember" class="form-check-label">Remember me</label>
                                    </div>
                                </div>
                                
                            </div>

                        </div>
                        <button class="button button-secondary button-winona" 
                        type="submit">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
