<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//utilizar modelo
use App\Image;
use App\Comment;
use App\Like;
//guardarImagen
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
//para getName
use Illuminate\Http\Response;

class ImageController extends Controller {

    //solo personal autorizado
    public function __construct() {
        $this->middleware('auth');
    }

    public function create() {
        return view('image.create');
    }

    public function save(Request $request) {
        //validacion
        $validate = $this->validate($request, [
            'description' => 'required',
            'image_path' => 'required|mimes:jpg,jpeg,png,gif|max:512'
        ]);

        //recepcionDatos
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        //asignar valores nuevos objeto
        $user = \Auth::user();
        $image = new Image();
        $image->user_id = $user->id;
        $image->description = $description;



        //subir fichero
        if ($image_path) {
            //time fechay hora unica del momento
            $image_path_name = time() . $image_path->getClientOriginalName();
            //File::get coger del archivo original, el temportal y guardalo en el VHD 
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            //guardar base de datos
            $image->image_path = $image_path_name;
        }


        //ejecutar cambios en BBDD
        $image->save();

        return redirect()->route('home')->with(['message' => 'OK, foto subida']);


        //var_dump($user->id);
        //die();
        //var_dump($image);
        //die();
        //var_dump($image_path);
        //var_dump($description);
        //die();
    }

    public function getImage($filename) {
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }

    //mostrar detalles foto lista
    public function detail($id) {
        //metodo find saca el objeto
        $image = Image::find($id);
        //var_dump($image);
        //die();
        return view('image.detail', ['image' => $image]);
    }

    //eliminar imagen & asociados
    public function delete($id) {

        //obtener usuario autorizado
        $user = \Auth::user();

        //obtener imagenes & associados
        $image = Image::find($id);
        $comments = Comment::where('image_id', $id)->get();
        $likes = Like::where('image_id', $id)->get();

        //condicion & eliminacion Imagen & assoc
        if ($user && $image && $image->user->id == $user->id) {
            //eliminar associados imagen
            if ($comments && count($comments) >= 1) {
                foreach ($comments as $comment) {
                    $comment->delete();
                }
            }

            if ($likes && count($likes) >= 1) {
                foreach ($likes as $like) {
                    $like->delete();
                }
            }

            //eliminar imagen
            Storage::disk('images')->delete($image->image_path);
            $image->delete();

            $message = array('message' => 'Ok,imagen borrada');
        } else {
            $message = array('message' => 'KO,imagen no borrada');
        }

        //redirecion
        return redirect()->route('home')->with($message);
    }

    public function edit($id) {
        $user = \Auth::user();
        $image = Image::find($id);

        if ($user && $image && $image->user->id == $user->id) {
            return view('image.edit', [
                'image' => $image
            ]);
        } else {
            return redirect()->route('home');
        }
    }

    public function update(Request $request) {

        //Validación
        $validate = $this->validate($request, [
            'description' => 'required',
            'image_path' => 'image'
        ]);

        // Recoger datos
        $image_id = $request->input('image_id');
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        // Conseguir objeto image
        $image = Image::find($image_id);
        $image->description = $description;

        // Subir fichero
        if ($image_path) {
            $image_path_name = time() . $image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }

        
        // Actualizar registro
		$image->update();
        
        return redirect()->route('image.detail', ['id' => $image_id])
						 ->with(['message' => 'OK,Imagen actualizada']);
        
        //var_dump($image_id);
        //var_dump($description);
        //die();
    }

}
