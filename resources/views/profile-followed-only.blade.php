<div class="list-group">
    @foreach ($followed as $followed)
    <a href="/profile/{{$followed->userFollowing->id}}" class="list-group-item list-group-item-action">
        <img class="avatar-tiny" src="{{$followed->userFollowing->avatar}}" />
        <strong>{{$followed->userFollowing->username}}</strong> on {{$followed->userFollowing->created_at->format('M-d-Y')}}
      </a>
    @endforeach
</div>