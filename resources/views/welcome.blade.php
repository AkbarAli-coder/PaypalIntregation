<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Test</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

  </head>
  <body>

    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="mt-5 mb-3">Laravel Form</h3>
                    <form  id="paymetSubmit">
                        @csrf
                        <div class="mb-3">
                            <label>Name</label>
                            <div><input type="text" name="name" id="name" class="form-control box-quantity">

                                <span class="text-danger" id="name-error"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <div><input type="text" name="email" id="email" class="form-control box-quantity">
                                <span class="text-danger" id="email-error"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Amount to pay (in USD)</label>
                            <div>
                                <select name="amount" class="form-control box-quantity" id="amount">
                                    <option value="5">$5</option>
                                    <option value="10">$10</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button  class="btn btn-primary btn-sm" id="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


      <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#paymetSubmit').on('submit', function(event){
            event.preventDefault();
            $('#name-error').text('');
            $('#email-error').text('');



            name = $('#name').val();
            email = $('#email').val();
            amount = $('#amount').val();


            $.ajax({
              url: "{{ route('ajax.payment') }}",
              type: "POST",
              data:{
                  name:name,
                  email:email,
                  amount:amount,


              },
              success:function(response){
                console.log(response);
                if (response) {
                  $('#success-message').text(response.success);

                }
              },
              error: function(response) {
                  $('#name-error').text(response.responseJSON.errors.name);
                  $('#email-error').text(response.responseJSON.errors.email);

              }
             });
            });
          </script>

  </body>
</html>
