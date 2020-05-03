{{--llamar plantilla--}}
@extends('layouts.app')
{{--dentro del contenedor--}}
@section('content')
<!--<h1>Configuracion de mi cuenta</h1> para prueba inicial -->
<div class="container">
    <div class="row justify-content-center">                
        <div class="col-md-8">
            <div class="card">     
                <div class ="card-header">Editar mi imagen</div>
                <div class="card-body">
                    <!--{{ route('image.update',$image->id) }}-->
                   <form method="POST" action="{{ route('image.update',$image->id) }}" enctype="multipart/form-data">
				@csrf
                 <!-- id_imagen  -->                   
		<input type="hidden" name="image_id" value="{{$image->id}}" />
                              
                        
                        <!--imagen-->

                        <div class="form-group row">
                            <label for="image_path" class="col-md-3 col-form-label text-md-right">Imagen</label>
                            <div class ="col-md-7">

                                @if($image->image_path)
                                <div class="container-avatar2">
                                   <img src ='{{route('image.file',['filename'=> $image->image_path])}}' class="avatar2"/>
                                </div>
                                @endif

                                <input id="image_path" type="file" name="image_path" class="form-control" />

                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)

                                        <li>{{ $error }}</li>

                                        @endforeach
                                    </ul>
                                </div>
                                @endif




                            </div>    
                        </div>

                        <!--description-->
                        <div class="form-group row">
                            <label for="description" class="col-md-3 col-form-label text-md-right">Descripcion</label>
                            <div class ="col-md-7">
                                <textarea id="description"  name="description" class="form-control" class="form-control">{{$image->description}}</textarea>

                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror


                            </div>    
                        </div>

                        <!--submit-->
                        <div class="form-group row">
                            <div class ="col-md-6 offset-md-3">
                                <input  type="submit" value="EditarImagen" class="btn btn-primary" />
                            </div>    
                        </div>


                    </form>
                </div>               
            </div>



        </div>
    </div>
</div>
@endsection




