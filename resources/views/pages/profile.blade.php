<div class="flex flex-col items-center my-6 uk-visible@s">
    <div
        class="bg-gradient-to-tr from-green-300 to-blue-600 p-1 rounded-full transition m-0.5 mr-2  w-24 h-24">
        <img src="{{ asset('assets/images/avatars/'.Auth::user()->avatarString = null ? Auth::user()->avatarString : 'no-avt.png' .'')}}"
            class="bg-gray-200 border-4 border-white rounded-full w-full h-full">
    </div>
    <a href="profile.html" class="text-xl font-medium capitalize mt-4 uk-link-reset"> {{ Auth::user()->firstName }} {{ Auth::user()->lastName }}
    </a>
    <div class="flex justify-around w-full items-center text-center uk-link-reset text-gray-800 mt-6">
        <div>
            <a href="#">
                <strong>Post</strong>
                <div> 130</div>
            </a>
        </div>
        <div>
            <a href="#">
                <strong>Following</strong>
                <div> 1,230</div>
            </a>
        </div>
        <div>
            <a href="#">
                <strong>Followers</strong>
                <div> 2,430</div>
            </a>
        </div>
    </div>
</div>
