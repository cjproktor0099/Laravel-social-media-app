<x-profile :sharedData="$sharedData" doctitle="{{$sharedData['username']}}'s Followed Users">
@include('profile-followed-only')
  </x-profile>