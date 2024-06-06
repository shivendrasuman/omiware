@extends('layouts.layout')

@section('content')
    <!-- Begin page content -->
    <main class="flex-shrink-0">
        <div class="container">
            <div class="py-5 text-center">
                <h2>Payment History</h2>
            </div>
            <div class="row py-2">
               <form method="POST" action="{{ route('paymenthistorySearch') }}" name="paymnethistorySearch"
                    id="paymnethistorySearch" class="">
                    {{ csrf_field() }}
                    <div class="input-group mb-3">
                        <span class="input-group-text">#</span>
                        <input type="text" class="form-control" placeholder="Transication ID" name="s"
                            aria-label="Transication ID" aria-describedby="basic-addon1" size="20" value="{{old('s')}}" />
                        <button type="submit" class="btn btn-primary btn-md">Search</button>
                    </div>
                </form>

            </div>
            <div class="row g-5">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Order ID</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Tran. ID</th>
                            <th scope="col">Mode</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date & Time</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i = 1)
                        @foreach ($PaymnetData as $key => $value)
                            <tr>
                                <th scope="row">{{ $currentPage > 0 ? ($currentPage - 1) * $perPage + $loop->iteration : $loop->iteration }}</th>
                                <td>{{ $value['order_id'] }}</td>
                                <td>&#8377; {{ $value['amount'] }}</td>
                                <td>{{ $value['transaction_id'] ?? 'Not Completed' }}</td>
                                <td>{{ $value['mode'] }}</td>
                                <td>{{ $value['payment_status'] }}</td>
                                <td>{{ $value['creation_datetime'] }}</td>
                                <td>
                                    @if ($value['payment_status'] == 'SUCCESS')
                                    <a href="{{ route('refund', Crypt::encrypt($value['order_id'])) }}" class="btn btn-info">Refund</a>
                                      
                                    @endif
                                </td>
                            </tr>
                            @php($i++)
                        @endforeach

                    </tbody>
                </table>
             
            </div>
            <div class="row">
            {{ $PaymnetData->links() }}
            </div>
        </div>
    </main>
@endsection
