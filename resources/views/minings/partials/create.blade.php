
<div class="panel panel-default">
    <div class="panel-body">
       
        <!-- FORM -->
        
        <form action="{{ route('mining.store') }}" method="POST" role="form">
            <legend>Mulai Mining</legend>
            {{ csrf_field() }}
            <div class="form-group">
                <label for="">Mining Power</label>
                <input type="text" class="form-control" name="mining_power" id="" placeholder="Input field">
            </div>
        
            <button type="submit" class="btn btn-primary">Start</button>
        </form>
        

    </div>
</div>
