@extends('user.index')
@section('content')
<div class="lg:p-12 max-w-md max-w-xl lg:my-0 my-12 mx-auto p-6 space-y-">
    <h1 class="lg:text-3xl text-xl font-semibold  mb-6"> Reset password</h1>
    <p class="mb-2 text-black text-lg"> Email or Phone Number</p>
    <form action="#" id="userReset">
        @method('POST')
        @csrf
        <input type="text" placeholder="Email" name="email" class="bg-gray-200 mb-2 shadow-none  dark:bg-gray-800"
            style="border: 1px solid #d3d5d8 !important;">
        <input type="password" placeholder="Password" name="password"
            class="bg-gray-200 mb-2 shadow-none  dark:bg-gray-800" style="border: 1px solid #d3d5d8 !important;">
        <input type="password" placeholder="Confirm Password" name="password_confirmation"
            class="bg-gray-200 mb-2 shadow-none  dark:bg-gray-800" style="border: 1px solid #d3d5d8 !important;">
        <button type="submit"
            class="bg-gradient-to-br from-pink-500 py-3 rounded-md text-white text-xl to-red-400 w-full">Reset Password</button>
    </form>
</div>
@endsection
@section('script')
<script>
    $(function () {

$(document).on("submit", "#userReset", function () {
    var e = this;

    $(this).find("[type='submit']").html("Reset password...");
    $.post($(this).attr('action'), $(this).serialize(), function (data) {

        $(e).find("[type='submit']").html("Reset password");
        if (data.status) {
            window.location = data.redirect_location;
        }

    }).fail(function (response) {

        var erroJson = JSON.parse(response.responseText);
        for (var err in erroJson) {
            for (var errstr of erroJson[err])
                $("[name='" + err + "']").after("<div class='alert alert-danger' style='color:red'>" + errstr + "</div>");
        }

    });
    return false;
});

});
</script>
@endsection
