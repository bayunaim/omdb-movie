@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('messages.Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('messages.A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('messages.Before proceeding, please check your email for a verification link.') }}
                    {{ __('messages.If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('messagesclick here to request another') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
