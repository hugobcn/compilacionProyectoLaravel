<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//cargar modelo
use App\Like;

class LikeController extends Controller
{
    //solo personal autorizado
    public function __construct()
    {
        $this->middleware('auth');
    } 
     
    public function index() {
        $user = \Auth::user();
		$likes = Like::where('user_id', $user->id)
                        ->orderBy('id', 'desc')
                        ->paginate(5);
		
		return view('like.index',[
			'likes' => $likes
		]);
        
    }
        
    
    public function like($image_id) {
        //Recoger datos del usuario y la imagen
        $user =\Auth::user();
        
        //condicion  no duplicar like
        $isset_like = Like::where('user_id',$user->id)
                            ->where('image_id',$image_id)
                            ->count();
                            //->get(); sacar daros objeto
                           
        //verificar si ya ha sido likeing
        if($isset_like == 0)
        {
         //crear objeto y recoger datos   
        $like = new Like();
        
        $like->user_id = $user->id;
        $like->image_id = (int) $image_id;
        
        //Guardar 
        $like->save();
        
        //devolver Json
        return response()->json([
            'like'=>$like
        ]);
            
        }else{
             return response()->json([
            'message'=>'KO, like ya existia'
        ]);
        }
        
        
        /*
        http://twitter-laravel.com/like/7
        var_dump($like);
        die();
        var_dump($isset_like);
        die();
        */
    }
    
    public function dislike($image_id) {
         //Recoger datos del usuario y la imagen
        $user =\Auth::user();
        
        //condicion existe like
        $like = Like::where('user_id',$user->id)
                            ->where('image_id',$image_id)
                            ->first();  //coger primer metodo
                                                       
        //verificar si ya ha sido likeing
        if($like)
        {

        //eliminar like 
        $like->delete();
        
        //devolver Json
        return response()->json([
            'like'=>$like,
             'message'=> 'Ok,dislike hecho'
        ]);
            
        }else{
             return response()->json([
            'message'=>'KO, dislike inexistente'
        ]);
        }
                
       //http://twitter-laravel.com/dislike/7
        
    }
    
    
    
}
