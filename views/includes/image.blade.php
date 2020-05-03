<!-- <div class="card pub_image">  -->
<div class="card  pub_image">
    <div class="card-header ">
        @if($image->user->image)
        <div class="container-avatar2">
            <img  src="{{route('user.file',['filename'=> $image->user->image])}}" class="avatar2"/> 
        </div>
        @endif
        <div class ="data-user">
            <a href="{{route('profile',['id'=>$image->user->id])}}">
                {{$image->user->name.' '.$image->user->surname.' | '.$image->user->image }}
                <span class=" nickname">
                    {{' | @ '.$image->user->nick}}
                </span>
            </a>
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

        <div class="comments">
            <a href="{{route('image.detail',['id'=>$image->id])}}" class="btn btn-sm btn-warning btn-comentarios">Comentarios ({{count($image->comments)}})</a>
            <!--contar cometarios-->

        </div>

    </div>
    {{--
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}

    @endif

    You are logged in!
    --}}
</div>
        </div>