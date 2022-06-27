@extends('layouts.frontend.app')

@section('title', 'Login')

@push('css')

@endpush



@section('content')
<div class="wrapper">

      <div class="row  ">
          <div class="col-md-12  ">
              <div class="card">


                  <div class="card-body ">
                    <form class="modal-content animate"  method="POST" action="{{ route('login') }}">
              				  @csrf
              			    <div class="imgcontainer">
              			      <!-- <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span> -->
              			      <img src="{{ asset('assets/frontend/img/img_avatar2.png') }}" alt="Avatar" class="avatar">
              			    </div>

              			    <div class="container">

              						<div class="form-group row">
              								<label for="email" class="col-md-2 col-form-label text-md-right">{{ __('User Email') }}</label>

              								<div class="col-md-4">
              										<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

              										@if ($errors->has('email'))
              												<span class="invalid-feedback" role="alert">
              														<strong>{{ $errors->first('email') }}</strong>
              												</span>
              										@endif
              								</div>
              						</div>

              						<div class="form-group row">
              								<label for="password" class="col-md-2 col-form-label text-md-right">{{ __('Password') }}</label>

              								<div class="col-md-4">
              										<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete="current-password">

              										@if ($errors->has('password'))
              												<span class="invalid-feedback" role="alert">
              														<strong>{{ $errors->first('password') }}</strong>
              												</span>
              										@endif
              								</div>
              						</div>

              						<div class="form-group row">
              								<div class="col-md-6 offset-md-4">
              										<div class="form-check">
              												<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

              												<label class="form-check-label" for="remember">
              														{{ __('Remember Me') }}
              												</label>
              										</div>
              								</div>
              						</div>

                          <div class="form-group row mb-0 float-right" >
                              <div class="col-md-6 offset-md-4">
                                  <button type="submit" class="btn btn-primary">
                                      {{ __('Login') }}
                                  </button>

                                  @if (Route::has('password.request'))
                                      <a class="btn btn-link" href="{{ route('password.request') }}">
                                          {{ __('Forgot Your Password?') }}
                                      </a>
                                  @endif
                              </div>

                          </div>




              			    </div>

              		  </form>

                  </div>
              </div>
          </div>
      </div>

</div>
@endsection



@push('js')



@endpush
