@if(session($session_var))
<div class="notification alert alert-{{ $state }}">
    {{ session($session_var) }}
</div>
@endif