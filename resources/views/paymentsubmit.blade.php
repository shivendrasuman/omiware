@extends('layouts.layout')

@section('content')
<!-- Begin page content -->
<main class="flex-shrink-0">
    <div class="container">
        <div class="py-5 text-center">
            <h2>Please do not click on back button we are processing your request </h2>
            {{-- <p class="lead">Below You need to enter amount and product name with all required data, after that you may procide for paymnet. Amount should not be less then 5 or greater then 50.</p> --}}
          </div>
          <div class="row g-5">
            <div class="col-md-12 col-lg-12">
            <form action="{{$api_url}}" method="post"  id="paymentSubmit" >
              <div class="col-sm-12">
                <label for="api_key" class="form-label">API Key (api_key)</label>
                <input type="text"  class="form-control" id="api_key" name="api_key" placeholder="" value="{{$api_key}}" required>
                @if ($errors->has('api_key'))
                <div class="invalid-form-error">
                    {{ $errors->first('api_key') }}
                </div>
                @endif
              </div>
              <div class="col-sm-12">
                <label for="encrypted_data" class="form-label">Encrypted Data (encrypted_data)</label>
                <input type="text"  class="form-control" id="encrypted_data" name="encrypted_data" placeholder="" value="{{$encrypted_data}}" required>
                @if ($errors->has('encrypted_data'))
                <div class="invalid-form-error">
                    {{ $errors->first('encrypted_data') }}
                </div>
                @endif
              </div>
              <div class="col-sm-12">
                <label for="iv" class="form-label">IV(iv)</label>
                <input type="text"  class="form-control" id="iv" name="iv" placeholder="" value="{{$iv}}" required>
                @if ($errors->has('iv'))
                <div class="invalid-form-error">
                    {{ $errors->first('iv') }}
                </div>
                @endif
              </div>
              <button class="w-100 btn btn-primary btn-lg" type="submit">Submit</button>
             
              {{--  <input type="text" value="{{$api_key}}" name="api_key"/>
              <input type="text" value="{{$encrypted_data}}" name="encrypted_data"/>
              <input type="text" value="{{$iv}}" name="iv"/>
              <input type="submit" value="Submit" >  --}}
          </form>
            </div>
          </div>
        </div>
    </main>  
    <script>
      //window.onload = (event) => {document.getElementById("paymentSubmit").submit();}
      </script>
  @endsection       