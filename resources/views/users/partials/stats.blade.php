<div class="panel panel-default table-responsive hidden-xs">
    <table class="table table-condensed table-bordered">
        <tr>
            <td class="col-xs-2 text-center">{{ trans('user.wallet') }}</td>
            <td class="col-xs-2 text-center">{{ trans('user.wallet_edinar') }}</td>
            <td class="col-xs-2 text-center">{{ trans('app.status') }}</td>
            
        </tr>
        <tr>
            <td class="text-center lead" style="border-top: none;">{{ $user->wallet }}</td>
            <td class="text-center lead" style="border-top: none;">{{ $user->wallet_edinar }}</td>
            <td class="text-center lead" style="border-top: none;">{{ $user->status }}</td>
            
        </tr>
    </table>
</div>

<ul class="list-group visible-xs">
    <li class="list-group-item">{{ trans('user.wallet') }} <span class="pull-right">{{ $user->wallet }}</span></li>
    <li class="list-group-item">{{ trans('user.wallet_edinar') }} <span class="pull-right">{{ $user->wallet_edinar }}</span></li>
    <li class="list-group-item">{{ trans('app.status') }} <span class="pull-right">{{ $user->status }}</span></li>
    <li class="list-group-item">{{ trans('user.role') }} <span class="pull-right">{{ $user->role }}</span></li>
</ul>
@if (auth()->user()->can('see-detail', $user) && $user->notes)
<div class="well well-sm">
    <strong>{{ trans('user.notes') }}</strong><br>{!! nl2br($user->notes) !!}
</div>
@endif

<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script>
let dam = "{{ $user->wallet }}";
    let mining = (dam * 0.5) / 100;
    let counter = mining / 86400;
    let n = new Date();
    n.getHours();
    let nd = (n.getHours() * 3600) + (n.getMinutes() * 60);
    let res = nd * counter;
    let fresult = res;
    $("#counter").html(fresult);
$(document).ready(function() {
    
    
    setInterval(() => {
        fresult += counter;
        $("#counter").html(fresult.toFixed(8));
    },1000);
});
</script>
