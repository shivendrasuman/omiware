@extends('layouts.layout')

@section('content')
    <!-- Begin page content -->
    <main class="flex-shrink-0">
        <div class="container">           
            <div class="row g-5">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="col-md-8">
                        <div class="border border-3  {{(isset($DecreptedResponseData['response_code']) && $DecreptedResponseData['response_code'] == '0'? "border-success": "border-danger")}}"></div>
                        <div class="card  bg-white shadow p-5">
                            <div class="mb-4 text-center">
                                @if (isset($DecreptedResponseData['response_code']) && $DecreptedResponseData['response_code'] == '0')
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="75" height="75"
                                fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path
                                    d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                            </svg>
                                @else
                                <svg style="color: red" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 16 16" width="75" height="75" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" fill="red"> <path d="m10.25 5.75-4.5 4.5m0-4.5 4.5 4.5"/> <circle cx="8" cy="8" r="6.25"/> </svg>
                              
                                @endif
                                
                            </div>
                            <div class="text-center">
                                <h1>{{(isset($DecreptedResponseData['response_code']) && $DecreptedResponseData['response_code'] == '0'? "Thank You !": "Sorry")}}</h1>
                                <h5>{{ $DecreptedResponseData['name'] ?? '' }}</h5>
                                <p>{{ $DecreptedResponseData['response_message'] ?? '' }} </p>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                Order ID :
                                            </div>
                                            <div class="col">
                                                {{ $DecreptedResponseData['order_id'] ?? '' }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                Amount :
                                            </div>
                                            <div class="col">
                                               {{$DecreptedResponseData['currency'] ?? '' }} {{ $DecreptedResponseData['amount'] ?? '' }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                Transation ID :
                                            </div>
                                            <div class="col">
                                                {{ $DecreptedResponseData['transaction_id'] ?? '' }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                Payment Chanel :
                                            </div>
                                            <div class="col">
                                                {{ $DecreptedResponseData['payment_channel'] ?? '' }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                Payment Mode :
                                            </div>
                                            <div class="col">
                                                {{ $DecreptedResponseData['payment_mode'] ?? '' }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                Payment Date & Time :
                                            </div>
                                            <div class="col">
                                                {{ $DecreptedResponseData['payment_datetime'] ?? '' }}
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <hr>
                                {{-- <button class="btn btn-outline-success">Back Payment</button> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
