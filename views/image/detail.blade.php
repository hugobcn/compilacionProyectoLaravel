@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('includes.message');

            <!-- <div class="card pub_image">  -->
            <div class="card  pub_image pub_image_detail">
                <div class="card-header ">
                    @if($image->user->image)
                    <div class="container-avatar2">
                        <img  src="{{route('user.file',['filename'=> $image->user->image])}}" class="avatar2"/> 
                    </div>
                    @endif
                    <div class ="data-user">
                        {{$image->user->name.' '.$image->user->surname.' | '.$image->user->image }}
                        <span class=" nickname">
                            {{' | @ '.$image->user->nick}}
                        </span>

                    </div>

                </div>

                <div class="card-body">
                    <div class='image-container'>
                        <img src ='{{route('image.file',['filename'=> $image->image_path])}}'/>
                    </div>


                    <div class='description'>                        
                        <span class='nickname'>{{'@'.$image->user->nick}}</span>
                        <span class="nickname date">{{' | '.\FormatTime::LongTimeFilter($image->created_at)}}</span>
                        <p>{{$image->description}}</
                    </div>



                    <!-- botton comentios -->


                    <div class='likes'>
                        <!--{{var_dump($image->likes)}}-->

                        <!--chequear si usuario ha dado like imagen-->
                        <?php $user_like = false; ?>
                        @foreach($image->likes as $like)
                        @if($like->user->id == Auth::user()->id)
                        <?php $user_like = true; ?>
                        @endif
                        @endforeach

                        @if($user_like)
                        <!-- data-id="{{$image->id}}"  para gestionar  mediante ajax-->
                        <img  src="{{asset('img/heart-red.png')}}" data-id="{{$image->id}}"  class="btn-dislike"/>
                        @else
                        <img  src="{{asset('img/heart-black.png')}}" data-id="{{$image->id}}"  class="btn-like"/>
                        @endif
                        <span class="number_likes">{{count($image->likes)}}</span>
                    </div>

                    <!-- si usuario existe y es el quie lo ha creado-->
                    <!-- https://getbootstrap.com/docs/4.0/components/modal/ -->
                    @if(Auth::user() &&  Auth::user()->id == $image->user->id)
                    <div class="action">
                        <a href="{{ route('image.edit', ['id' => $image->id]) }}" class="btn btn-sm btn-primary">Actualizar</a>             
                        
                        <!--<a href="{{ route('image.delete', ['id' => $image->id]) }}" class="btn btn-sm btn-danger">Borrar</a>-->

                        <!-- Button to Open the Modal -->
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModal">
                            Eliminar
                        </button>

                        <!-- The Modal -->
                        <div class="modal" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">¿Estas seguro?</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        Si eliminar esta imagen nunca podrás recuperarla, ¿estas seguro de querer borrarla?
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
                                        <a href="{{ route('image.delete', ['id' => $image->id]) }}" class="btn btn-danger">Borrar definitivamente</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    @endif

                    <div class="clearfix"></div>

                    <div class="comments">
                        <h2>Comentarios ({{count($image->comments)}})</h2>
                        <hr>

                        <form method="POST" action="{{ route('comment.save') }}">
                            @csrf
                            <input type="hidden" name="image_id" value="{{$image->id}}" />
                            <p>
                                <textarea class="form-control" name="content" required></textarea>
                                @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            </p>
                            <button type="submit" class="btn btn-success">Enviar</button>
                        </form>
                        <hr>
                        <!-- mostrar listado comentario -->
                        @foreach($image->comments as $comment)

                        <div class="comment">

                            <span class='nickname'>{{'@'.$comment->user->nick}}</span>
                            <span class="nickname date">{{' | '.\FormatTime::LongTimeFilter($comment->created_at)}}</span>
                            <p>{{$comment->content}}
                                <br>
                                <!-- botton eliminar comentario -->

                                @if(Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id))
                                <a href="{{route('comment.delete',['id'=>$comment->id])}}" class="btn btn-smn btn-danger">
                                    Eliminar
                                </a>
                                @endif
                            </p>
                        </div>

                        @endforeach
                    </div>





                </div>

            </div>
        </div>


    </div>



</div>
</div>
@endsection


