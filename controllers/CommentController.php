<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//cargar Modelo para BBDD
use App\Comment;

class CommentController extends Controller
{
    
    //solo personal autorizado
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    public function save(Request $request)
    {
        
        //validar datos
        $validate = $this->validate($request,[
            'image_id' => 'integer|required|',
            'content'=> 'string|required',
        ]);

        //recoger datos
        //\Auth::user(); recoger  dato usuario
        $user = \Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');
        
        //cargar en BBDD
        $comment = new Comment();
        //Asignar nuevos valores a asignar
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;
        
        //guardar datos en BBDD
        $comment -> save();
        
        //redirecion
        return redirect()-> route('image.detail',['id'=>$image_id])
                         -> with(['message'=>'OK, comentario publicado']);
        
        //var_dump($content);
        //var_dump($image_id);
        //die();
                
                
    }
    
    public function delete($id) {
        //conseguir usuario logueado
        $user = \Auth::user();
        
        //conseguir objeto del comentario
        //find conseguir objeto de ese registro
        $comment = Comment::find($id);
        
        // Comprobar si soy el dueño del  comentario o imagen
        if($user && ($comment -> user_id == $user->id || $comment->image->user_id == $user->id)){
            //borrado comentario
            $comment-> delete();
            
            //redirecion
        return redirect()-> route('image.detail',['id'=>$comment->image->id])
                         -> with(['message'=>'OK, comentario borrado']);
        }else{
            //redirecion
        return redirect()-> route('image.detail',['id'=>$comment->image->id])
                         -> with(['message'=>'KO, comentario NO borrado']);
        }
    }
    
}
