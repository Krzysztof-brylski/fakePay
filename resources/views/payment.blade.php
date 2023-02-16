@extends('app')
@section('content')
@if(session('error'))
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {{session('error')}}
            </div>
        </div>
    </div>
@endif
<div class="d-flex h-100 flex-column justify-content-center align-items-center">
    <h1 >Totally not fake payments, trust me i'll be engineer...</h1>
    <h4 >Payment for: {{$Payments->originUrl}}</h4>
    <div class="d-flex justify-content-center align-items-center">
        <form action="{{route("finalize.payment")}}"  method="post" class="my-3">
            @csrf
            <input hidden name="token" type="text" value="{{$Payments->token}}">
            <button class="btn btn-success mx-2">Pay: {{$Payments->toPay}} PLN</button>
        </form>
        <form action="{{route("cancel.payment")}}"  method="post" class="my-3">
            @csrf
            <input hidden name="token" type="text" value="{{$Payments->token}}">
            <button class="btn btn-danger mx-2">Anuluj płatność</button>
        </form>
    </div>
</div>
@endsection
