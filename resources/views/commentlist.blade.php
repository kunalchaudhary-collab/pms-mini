
<ul> 
@foreach($comments as $c)
    <li>
        <b>{{ $c->user->name }}</b>:
        {{ $c->content }}
        — <small>{{ $c->created_at->diffForHumans() }}</small>
    </li>
@endforeach
</ul>


