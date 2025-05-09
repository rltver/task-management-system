{{--<img src="{{ asset('storage/' . (auth()->user()->profile_photo ?? 'default.png')) }}" alt="Profile picture" width="100">--}}
<img src="{{Storage::url('img/profilePictures/'. (auth()->user()->profile_photo ?? 'default.png'))}}" alt="dasdawd">
