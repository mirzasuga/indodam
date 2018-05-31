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
            <td class="text-center lead" style="border-top: none;">null</td>
            
        </tr>
    </table>
</div>