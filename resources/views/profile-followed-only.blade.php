<div class="list-group">
    @foreach ($followed as $followed)
    <a href="/profile/{{$followed->followedUser->id}}" class="list-group-item list-group-item-action">
        <img class="avatar-tiny" src="{{$followed->followedUser->avatar}}" />
        <strong>{{$followed->followedUser->username}}</strong> on {{$followed->followedUser->created_at->format('M-d-Y')}}
      </a>
    @endforeach
</div>