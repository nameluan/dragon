@extends('user.index')
@section('title')
Register
@endsection
@section('content')
<div class="lg:p-12 max-w-md max-w-xl lg:my-0 my-12 mx-auto p-6 space-y-">
    <h1 class="lg:text-3xl text-xl font-semibold mb-6"> Sign in</h1>
    <p class="mb-2 text-black text-lg"> Register to manage your account </p>
    <form action="#" id="userRegister">
        @method('POST')
        @csrf
        <div class="flex lg:flex-row flex-col lg:space-x-2">
            <input type="text" placeholder="First Name" name="firstName"
                class="bg-gray-200 mb-2 shadow-none  dark:bg-gray-800" style="border: 1px solid #d3d5d8 !important;">
            <input type="text" placeholder="Last Name" name="lastName"
                class="bg-gray-200 mb-2 shadow-none  dark:bg-gray-800" style="border: 1px solid #d3d5d8 !important;">
        </div>
        <input type="text" placeholder="Email" name="email" class="bg-gray-200 mb-2 shadow-none  dark:bg-gray-800"
            style="border: 1px solid #d3d5d8 !important;">
        <input type="password" placeholder="Password" name="password"
            class="bg-gray-200 mb-2 shadow-none  dark:bg-gray-800" style="border: 1px solid #d3d5d8 !important;">
        <input type="password" placeholder="Confirm Password" name="confirm_password"
            class="bg-gray-200 mb-2 shadow-none  dark:bg-gray-800" style="border: 1px solid #d3d5d8 !important;">
        <div class="flex justify-start my-4 space-x-1">
            <div class="checkbox">
                <input type="checkbox" id="chekcbox1" checked>
                <label for="chekcbox1"><span class="checkbox-icon"></span> I Agree</label>
            </div>
            <a href="#"> Terms and Conditions</a>
        </div>
        <button type="submit"
            class="bg-gradient-to-br from-blue-500 py-3 rounded-md text-white text-xl to-blue-600 w-full">REGISTER</button>
        <div class="text-center mt-5 space-x-2">
            <p class="text-base"> Do you have an account? <a href="{{ route('user.login') }}"> Login </a></p>
        </div>
    </form>
</div>
@endsection
@section('script')
<script>
    $(function () {

        $(document).on("submit", "#userRegister", function () {
            var e = this;

            $(this).find("[type='submit']").html("REGISTER...");
            $.post($(this).attr('action'), $(this).serialize(), function (data) {

                $(e).find("[type='submit']").html("REGISTER");
                if (data.status) {
                    window.location = data.redirect_location;
                }

            }).fail(function (response) {

                var erroJson = JSON.parse(response.responseText);
                for (var err in erroJson) {
                    for (var errstr of erroJson[err])
                        $("[name='" + err + "']").after("<div class='alert alert-danger'>" + errstr + "</div>");
                        $(e).find("[type='submit']").html("REGISTER");
                    }
            });
            return false;
        });

    });
</script>
@endsection
