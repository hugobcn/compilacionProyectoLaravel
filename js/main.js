var url = 'http://twitter-laravel.com';
window.addEventListener("load", function () {
    //alert("OK, JS cargado");
    // chequear si Jquery funciona
    //$('body').css('background','red');

    //vonvertir de puntero a manita
    $('.btn-like').css('cursor', 'pointer');
    $('.btn-dislike').css('cursor', 'pointer');
    //convertir botton con un click like
    //like -> dislike y  black-> red
    //.unbind('click') para limpiar eventos antetriores del click opcional no necesario
    function like() {
        $('.btn-like').unbind('click').click(function () {
            console.log('like');
            $(this).addClass('btn-dislike').remove('btn-like');
            $(this).attr('src',url+'/img/heart-red.png');
            //$(this).attr('src','img/heart-red.png');
            
            ///AJAX///
        //data('id') recoge atributo de la pagina data-id="{{$image->id}}"
        //success:  miisage si funciona
         $.ajax({
            url: url+'/like/'+$(this).attr('data-id'),       //data('id'),
            type: 'GET',
            success: function(response){
                 //console.log(response); datos del objeto
                if(response.like){
                    console.log('Ok,AJAX like publicacion');
                }else{
                    console.log('KO,AJAX likelizado publicacion');
                }
            }
        });
           
            dislike();
        });

            }
    //llamar funciones 
    like();
    //convertir botton con un click dislike
    //dislike -> like y red-> black
    //.unbind('click') para limpiar eventos antetriores del click
    function dislike() {
        $('.btn-dislike').unbind('click').click(function () {
            console.log('dislike');
            $(this).addClass('btn-like').remove('btn-dislike');
            $(this).attr('src', url+'/img/heart-black.png');
            //$(this).attr('src','img/heart-black.png');
              ///AJAX///
        //data('id') recoge atributo de la pagina data-id="{{$image->id}}"
        //success:  miisage si funciona
         $.ajax({
            url: url+'/dislike/'+$(this).data('id'),     //.attr('data-id'),       //.data('id'),
            type: 'GET',
            success: function(response){
                //console.log(response); datos del objeto
                if(response.dislike){
                    console.log('Ok,AJAX dislike publicacion');
                }else{
                    console.log('KO,AJAX ya dislike publicacion');
                }
            }
        });
            
            
            
            like();
        });
        
        
        
    }

    //llamar funciones
    dislike();

    // BUSCADOR
    //cambiar atributo action del elemento
	$('#buscador').submit(function(e){
		$(this).attr('action',url+'/gente/'+$('#buscador #search').val());
	});

});