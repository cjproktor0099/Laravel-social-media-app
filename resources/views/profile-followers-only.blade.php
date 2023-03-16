<div class="list-group">
    @foreach ($followers as $follower)
    <a href="/profile/{{$follower->userFollowing->id}}" class="list-group-item list-group-item-action">
        <img class="avatar-tiny" src="{{$follower->userFollowing->avatar}}" />
        <strong>{{$follower->userFollowing->username}}</strong> on {{$follower->userFollowing->created_at->format('M-d-Y')}}
      </a>
    @endforeach
</div>