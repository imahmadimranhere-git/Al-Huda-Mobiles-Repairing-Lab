@extends('layouts.app')

@section('title', 'Approve Repair')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <h2 class="font-display mb-2 text-center">Confirm Your Repair</h2>
                    <p class="text-secondary text-center mb-4">
                        Enter the 6-digit code we emailed to <strong>{{ $repair->approval_email }}</strong>.
                    </p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <div class="service-card">
                        <form method="POST" action="{{ route('repairs.approve.verify', $repair->tracking_id) }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Approval Code</label>
                                <input type="text" name="otp_code" class="form-control text-center fs-4" maxlength="6"
                                       placeholder="000000" required autofocus>
                            </div>
                            <button type="submit" class="btn btn-accent w-100">Confirm Repair</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection