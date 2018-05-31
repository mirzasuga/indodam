<div class="panel panel-default">
    <div class="panel-body">
       
        <!-- FORM -->
        
        <form action="{{ route('mining.increasePower') }}" method="POST" role="form">
            <legend>Tambah Mining Power</legend>
            {{ csrf_field() }}
            <div class="form-group">
                <label for="">Mining Power</label>
                <input type="text" class="form-control" name="mining_power" id="" placeholder="Input field">
            </div>
        
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
        

    </div>
</div>