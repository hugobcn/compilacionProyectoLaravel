<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//gestionar imagenes
use App\Image;
//almacenar datos e imagen en disco
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //extraer todas las imagenes
        //$images = Image::orderBy('id','desc')->get();
        
        //extraer datos y paginar los archivos
        //http://twitter-laravel.com/home?page=2
          $images = Image::orderBy('id','desc')->paginate(4);                                        
        
        //$file = Storage::disk('users')->get();
        //var_dump($images_users);
        //die();
        
        
        return view('home',['images'=>$images]);
    }
    
    
    
   
}
