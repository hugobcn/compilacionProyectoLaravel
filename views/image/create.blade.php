{{--llamar plantilla--}}
@extends('layouts.app')
{{--dentro del contenedor--}}
@section('content')
<!--<h1>Configuracion de mi cuenta</h1> para prueba inicial -->
<div class="container">
    <div class="row justify-content-center">                
        <div class="col-md-8">
            <div class="card">     
                <div class ="card-header">Subir nueva Imagen</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('image.save') }}" enctype="multipart/form-data">
                        @csrf
                        <!--imagen-->

                        <div class="form-group row">
                            <label for="image_path" class="col-md-3 col-form-label text-md-right">Imagen</label>
                            <div class ="col-md-7">
                                <input id="image_path" type="file" name="image_path" class="form-control" class="form-control @error('image_path') is-invalid @enderror" required/>

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
                                <textarea id="description"  name="description" class="form-control" class="form-control @error('description') is-invalid @enderror"></textarea>

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
                                <input  type="submit" value="subir" class="btn btn-primary" />
                            </div>    
                        </div>


                    </form>
                </div>               
            </div>



        </div>
    </div>
</div>
@endsection


