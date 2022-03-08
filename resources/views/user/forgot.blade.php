@extends('user.index')
@section('content')
<div class="lg:p-12 max-w-md max-w-xl lg:my-0 my-12 mx-auto p-6 space-y-">
    <h1 class="lg:text-3xl text-xl font-semibold  mb-6"> Forgot Password</h1>
    <p class="mb-2 text-black text-lg"> Email you need to find the password again</p>
    <form action="#" id="userForgot">
        @method('POST')
        @csrf
        <input type="text" name="email" id="email" placeholder="Enter your email"
            class="bg-gray-200 mb-2 shadow-none dark:bg-gray-800" style="border: 1px solid #d3d5d8 !important;">
        <button type="submit"
            class="bg-gradient-to-br from-pink-500 py-3 rounded-md text-white text-xl to-red-400 w-full">Forgor
            Password</button>
    </form>
</div>
@endsection
@section('script')
<script>
    var typingTimer;

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('submit', '#userForgot', function () {
            var e = this;
            $(this).find("[type='submit']").html("Forgot Password...");
            $.ajax({
                type: 'POST',
                url: '{{ route('user.forgot') }}',
                data: {
                    email: $('#email').val(),
                },
                dataType: "json",
                success: function (data) {
                    if($.isEmptyObject(data.error)){
                        swal("Check email", data.msg, "warning");
                    }else{
                        $(".alert").remove();
                        var erroJson = JSON.parse(data.responseText);
                        for (var err in erroJson) {
                            for (var errstr of erroJson[err])
                                $("[name='" + err + "']").after("<div class='alert alert-danger'>" + errstr + "</div>");
                        }
                    }
                }
            });
        });
    });
</script>
@endsection
