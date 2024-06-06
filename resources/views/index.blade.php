@extends('layouts.layout')

@section('content')
<!-- Begin page content -->
<main class="flex-shrink-0">
    <div class="container">
        <div class="py-5 text-center">
            <h2>Checkout form</h2>
            <p class="lead">Below You need to enter amount and product name with all required data, after that you may procide for paymnet. Amount should not be less then 5 or greater then 50.</p>
          </div>
          {!! Form::open(['id'=>'payment', 'route' => 'submitresponse', 'method' => 'POST']) !!}
         
          {{ csrf_field() }}
          @if ($errors->has('errorMessage'))
          <div class="alert alert-danger" role="alert">
            {{ $errors->first('errorMessage') }}
          </div>
          @endif
        <div class="row g-5">
            <div class="col-md-5 col-lg-4 order-md-last">
              <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-primary">Your cart</span>
                <span class="badge bg-primary rounded-pill">1</span>
              </h4>
              <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between lh-sm">
                  <div>
                    <h6 class="my-0">Payment Gateway Package</h6>
                    <small class="text-muted">Brief description</small>
                  </div>                  
                </li>
                
                <li class="list-group-item d-flex justify-content-between lh-sm">
                  <div>
                    <h6 class="my-0">Product Price</h6>
                    <div class="input-group has-validation">
                        <span class="input-group-text">&#8377;</span>
                        <input type="text" class="form-control" id="product_price" name="product_price" value="{{ old('product_price') }}" placeholder="5.0 " required>
                        <small class="text-muted">Price should not be less then 5.0 and greater then 50.0</small>
                        @if ($errors->has('product_price'))
                        <div class="invalid-form-error" style="display: block;">
                            {{ $errors->first('product_price') }}
                        </div>
                        @endif
                        
                      </div>
                  </div>
                  {{-- <span class="text-muted">$12</span> --}}
                </li>
                {{-- <li class="list-group-item d-flex justify-content-between bg-light">
                  <div class="text-success">
                    <h6 class="my-0">Promo code</h6>
                    <small>EXAMPLECODE</small>
                  </div>
                  <span class="text-success">−$5</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                  <span>Total (USD)</span>
                  <strong>$20</strong>
                </li> --}}
              </ul>
      
              {{-- <form class="card p-2">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Promo code" fdprocessedid="6zb978">
                  <button type="submit" class="btn btn-secondary" fdprocessedid="qvfrb8">Redeem</button>
                </div>
              </form> --}}
            </div>
            <div class="col-md-7 col-lg-8">
              <h4 class="mb-3">Billing address</h4>
              <form class="needs-validation" novalidate="">
                <div class="row g-3">
                  <div class="col-sm-6">
                    <label for="user_name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Full Name" value="{{ old('user_name') }}" required="required">
                    @if ($errors->has('user_name'))
                    <div class="invalid-form-error">
                        {{ $errors->first('user_name') }}
                    </div>
                    @endif
                  </div>
      
                  <div class="col-sm-6">
                    <label for="user_mobile" class="form-label">Mobile</label>
                    <input type="tel"  class="form-control" id="user_mobile" name="user_mobile" placeholder="XXXXXXXXXX" value="{{ old('user_mobile') }}" required>
                    @if ($errors->has('user_mobile'))
                    <div class="invalid-form-error">
                        {{ $errors->first('user_mobile') }}
                    </div>
                    @endif
                  </div>
                  {{-- pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" --}}
      
                  <div class="col-12">
                    <label for="user_email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="user_email" name="user_email" value="{{ old('user_email') }}" placeholder="you@example.com" required>
                    @if ($errors->has('user_email'))
                    <div class="invalid-form-error">
                        {{ $errors->first('user_email') }}
                    </div>
                    @endif
                  </div>
      
                  <div class="col-12">
                    <label for="user_address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="user_address" name="user_address" value="{{ old('user_address') }}" placeholder="1234 Main St" required="required">
                    @if ($errors->has('user_address'))
                    <div class="invalid-form-error">
                        {{ $errors->first('user_address') }}
                    </div>
                    @endif
                  </div>
      
                  <div class="col-12">
                    <label for="user_address2" class="form-label">Address 2 </label>
                    <input type="text" class="form-control" id="user_address2" name="user_address2" value="{{ old('user_address2') }}" placeholder="Apartment or suite" required>
                    @if ($errors->has('user_address2'))
                    <div class="invalid-form-error">
                        {{ $errors->first('user_address2') }}
                    </div>
                    @endif
                  </div>
      
                  <div class="col-md-3">
                    <label for="country" class="form-label">Country</label>
                    <select class="form-select" id="country" name="country">
                      <option value="">Choose...</option>
                      <option value="IND">India</option>
                    </select>
                    @if ($errors->has('country'))
                    <div class="invalid-form-error">
                        {{ $errors->first('country') }}
                    </div>
                    @endif
                  </div>
      
                  <div class="col-md-3">
                    <label for="state" class="form-label">State</label>
                    <select class="form-select" id="state" name="state" required="required">
                      <option value="">Choose...</option>
                      <option value="Bangalore">Bangalore</option>
                      <option value="Bihar">Bihar</option>
                      <option value="Delhi">Delhi</option>
                    </select>
                    @if ($errors->has('state'))
                    <div class="invalid-form-error">
                        {{ $errors->first('state') }}
                    </div>
                    @endif
                  </div>
                  <div class="col-md-3">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}"  placeholder="City Name" required>
                    @if ($errors->has('city'))
                    <div class="invalid-form-error">
                        {{ $errors->first('city') }}
                    </div>
                    @endif
                  </div>
      
                  <div class="col-md-3">
                    <label for="zip" class="form-label">Zip</label>
                    <input type="text" class="form-control" id="zip" name="zip" value="{{ old('zip') }}" placeholder="" required>
                    @if ($errors->has('zip'))
                    <div class="invalid-form-error">
                        {{ $errors->first('zip') }}
                    </div>
                    @endif
                  </div>
                </div>      
                <hr class="my-4">      
                <button class="w-100 btn btn-primary btn-lg" type="submit">Pay Now</button>
              </form>
            </div>
          </div>
          {!! Form::close() !!}
    </div>
  </main>
  
@endsection