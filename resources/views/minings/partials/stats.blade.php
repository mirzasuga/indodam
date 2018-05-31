<div class="panel panel-default table-responsive hidden-xs">
    <table class="table table-condensed table-bordered">
        <tr>
            <td class="col-xs-2 text-center">Mining Power</td>
            <td class="col-xs-2 text-center">Start</td>
            <td class="col-xs-2 text-center">End</td>
            <td class="col-xs-2 text-center">Mining Income</td>
            
        </tr>
        <tr>

            <td class="text-center lead" style="border-top: none;">{{ $mining->virtualMiningBalance() }}</td>
            <td class="text-center lead" style="border-top: none;">{{ $mining->started_mining }}</td>
            <td class="text-center lead" style="border-top: none;">{{ $mining->end_mining }}</td>
            <td class="text-center lead" style="border-top: none;">{{$mining->mining_income}}</td>
            
        </tr>
    </table>
    
</div>


<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <a href="{{ route('mining.stop') }}" class="btn btn-primary">Stop Mining</a>
    </div>
</div>