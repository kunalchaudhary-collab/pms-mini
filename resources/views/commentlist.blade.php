
<ul> 
@foreach($comments as $c)
    <li>
        <b>{{ $c->user->name }}</b>:
        {{ $c->content }} <small> by  {{ $c->user->email }}</small>
        — <small>{{ $c->created_at->diffForHumans() }}</small>
    </li>
@endforeach
</ul>


