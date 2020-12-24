@extends('vendor.adminlte.dashboard')

@section('content')
<div class="background-primary p-10 " style="min-height: 200px; position: relative;">
    <h1 class="text-center text-white"><b>MASUK PORTAL DATA</b></h1>
    <div class=" col-md-4 col-xs-12 col-sm-6" style="position: absolute; margin:auto; top:100px; left:0px; right: 0px;">
        <div class="box box-solid">
            <form action="" method="post">

               <div class="box-body">
                    @csrf
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                         <input type="password" name="password" class="form-control">
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-xl w-100">MASUK</button>
                </div>

            </form>

        </div>
    </div>
</div>
@stop
