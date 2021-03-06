<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use YDB;
class DataCtrl extends Controller
{
    //


    public function index($tahun,Request $request){
    	$req='';
    	if($request->q){
    		$req=$request->q;
    	}

    	$data=DB::table('data as d')
    	->leftJoin('category as i',[['i.id','=','d.organization_id'],['i.type','=',DB::raw("'INSTANSI'")]])
    	->leftJoin(DB::raw("(select GROUP_CONCAT(concat(c.id,'|',c.name),'||') as names,dg.id_data from category as c left join data_group as dg on dg.id_category where c.type='TEMA' group by dg.id) as tema"),'tema.id_data','=','d.id')
    	

    	->selectRaw('d.*,i.name as oranization_name,i.image_path as organization_image_path,tema.names as temas,i.name as orgas')
    	->where([
    		['d.name','like',DB::raw("'%".$req."%'")],
    		
    	])
    	->orWhere([
    		['d.name','like',DB::raw("'%".$req."%'")],
    		
    	])
    	->orWhere([
    		['i.name','like',DB::raw("'%".$req."%'")],

    	])->orderBy('d.updated_at','desc')->paginate(10);

    	return view('data.query')->with(['data'=>$data,'request'=>$request]);

    	
    }


    public function categorical($tahun,$instansi,$slug=null,Request $request){
    	$req='';
    	if($request->q){
    		$req=$request->q;
    	}

    	$instansi_data=DB::table('category')->where('id',$instansi)->first();

    	if(!$instansi_data){
    		return abort('404');
    	}

    	$data=DB::table('data as d')
    	->leftJoin('category as i',[['i.id','=','d.organization_id'],['i.type','=',DB::raw("'INSTANSI'")]])
    	->leftJoin(DB::raw("(select GROUP_CONCAT(concat(c.id,'|',c.name),'||') as names,dg.id_data from category as c left join data_group as dg on dg.id_category where c.type='TEMA' group by dg.id) as tema"),'tema.id_data','=','d.id')
    	->selectRaw('d.*,i.name as oranization_name,i.image_path as organization_image_path,tema.names as temas,i.name as orgas');

    	if($instansi_data->type=='TEMA'){
    		$data=$data->Where([
    		['d.name','like',DB::raw("'%".$req."%'")],
    		['tema.names','like',DB::raw("'%".$instansi_data->name."%'")],
    	])
    	->orWhere([
    		['d.name','like',DB::raw("'%".$req."%'")],
    		['i.id','like',DB::raw("'%".$instansi_data->name."%'")],
    		
    	])
    	->orWhere([
    		['i.name','like',DB::raw("'%".$req."%'")],
    		['i.id','like',DB::raw("'%".$instansi_data->name."%'")],


    	])->orderBy('d.updated_at','desc')->paginate(10);
    	}else{

    		$data=$data->where([
	    		['d.name','like',DB::raw("'%".$req."%'")],
	    		['i.id','=',DB::raw($instansi)],
	    	])
	    	->orWhere([
	    		['d.name','like',DB::raw("'%".$req."%'")],
	    		['i.id','=',DB::raw($instansi)],
	    		
	    	])
	    	->orWhere([
	    		['i.name','like',DB::raw("'%".$req."%'")],
	    		['i.id','=',DB::raw($instansi)],


	    	])->orderBy('d.updated_at','desc')->paginate(10);

    	}
    	

    	return view('data.query')->with(['data'=>$data,'request'=>$request,'instansi'=>$instansi_data]);

    	
    }


    public function detail($tahun,$id,$slug=null){
        $instansi=null;
        $data=DB::table('data as d')
        ->where('id',$id)->first();
        // dd($data);

        if($data){
            $instansi=$instansi_data=DB::table('category')->where('id',$data->organization_id)->first();
            switch ($data->delivery_type) {
                case 'DATASET':
                    return view('data.data-set')->with(['data'=>$data,'instansi'=>$instansi]);
                    break;
                
                default:
                    # code...
                    break;
            }
        }else{
            return abort(404);
        }
       

    }
}
