
<div class="panel panel-default">
    <div class="panel-body">
       
       <form action="{{ route('withdraw.store') }}" method="POST" role="form">
           <legend>Form Permintaan Withdraw</legend>
            {{ csrf_field() }}
           <div class="form-group">
               <label for="">Jumlah Withdraw</label>
               <input type="number" name="amount" class="form-control" id="" placeholder="Input field">
           </div>
       
           <button type="submit" class="btn btn-primary">Kirim Permintaan</button>
       </form>
       
    </div>
</div>
