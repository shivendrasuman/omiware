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
            <form action="{{$api_url}}" method="post"  id="paymentSubmit" >
             
              <input type="text" value="{{$api_key}}" name="api_key"/>
              <input type="text" value="{{$encrypted_data}}" name="encrypted_data"/>
              <input type="text" value="{{$iv}}" name="iv"/>
              <!-- Generally instead of showing the submit button do an auto submit using
              javascript onload="document.forms[0].submit()" -->
              <input type="submit" value="Submit" >
          </form>
          </div>
        </div>
    </main>  
    <script>
      //window.onload = (event) => {document.getElementById("paymentSubmit").submit();}
      </script>
  @endsection       