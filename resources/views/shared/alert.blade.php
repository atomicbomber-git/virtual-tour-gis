@if(session("message.success"))
<div class="notification alert alert-success">
    <i class="fa fa-check"></i>
    {{ session("message.success") }}
</div>
@endif

@if(session("message.danger"))
<div class="notification alert alert-danger">
    <i class="fa fa-warning"></i>
    {{ session("message.danger") }}
</div>
@endif

@if(session("message.info"))
<div class="notification alert alert-info">
    <i class="fa fa-info"></i>
    {{ session("message.info") }}
</div>
@endif
