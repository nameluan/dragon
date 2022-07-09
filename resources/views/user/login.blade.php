@extends('user.index')
@section('title')
Login
@endsection
@section('content')
<div class="lg:p-12 max-w-md max-w-xl lg:my-0 my-12 mx-auto p-6 space-y-">
    <h1 class="lg:text-3xl text-xl font-semibold  mb-6"> Log in</h1>
    <p class="mb-2 text-black text-lg"> Email or Phone Number</p>
    <form action="#" id="userLogin">
        @method('POST')
        @csrf
        <input type="text" name="username" placeholder="Enter your email or phone number"
            class="bg-gray-200 mb-2 shadow-none dark:bg-gray-800" style="border: 1px solid #d3d5d8 !important;">
        <input type="password" name="password" placeholder="***********"
            class="bg-gray-200 mb-2 shadow-none dark:bg-gray-800" style="border: 1px solid #d3d5d8 !important;">
        <div class="flex justify-between my-4">
            <div class="checkbox">
                <input type="checkbox" id="checkBoxRegister">
                <label for="chekcbox1"><span class="checkbox-icon"></span>Remember Me</label>
            </div>
            <a href="{{ route('user.forgot') }}"> Forgot Your Password? </a>
        </div>
        <button type="submit"
            class="bg-gradient-to-br from-blue-500 py-3 rounded-md text-white text-xl to-blue-600 w-full">Login</button>
        <div class="text-center mt-5 space-x-2">
            <p class="text-base"> Not registered? <a href="{{ route('user.register') }}" class=""> Create a account </a>
            </p>
        </div>
    </form>
</div>
@endsection
@section('script')
<script>
    $(function () {
        $(document).on("submit", "#userLogin", function () {
            var e = this;
            $(this).find("[type='submit']").html("LOGIN...");
            $.post($(this).attr('action'), $(this).serialize(), function (data) {

                $(e).find("[type='submit']").html("LOGIN");
                if (data.status) {
                    window.location = data.redirect_location;
                }
                if (data.msgErr) {
                    swal("Login failed!", data.msgErr , "error");
                }
                if (data.msgErrBlock) {
                    swal("Login failed!", data.msgErrBlock , "error");
                }
                if (data.msgErrOff) {
                    swal("Login failed!", data.msgErrOff , "error");
                }
            }).fail(function (response) {
                $(".alert").remove();
                var erroJson = JSON.parse(response.responseText);
                for (var err in erroJson) {
                    for (var errstr of erroJson[err])
                        $("[name='" + err + "']").after("<div class='alert alert-danger'>" + errstr + "</div>");
                }

            });
            return false;
        });
    });
</script>
@endsection
