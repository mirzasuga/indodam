<div class="panel panel-default">
      <div class="panel-heading">
            <h3 class="panel-title">History Withdraw</h3>
      </div>
      <div class="panel-body">

        
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($withdraws as $item)
                    <tr>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->amount }}</td>
                        <td>{{ $item->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        

      </div>
</div>

