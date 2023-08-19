@extends('adminlte::page')


@section('content')
    @if(session()->has('user_data'))
        <!-- Contenido que solo se muestra a usuarios autenticados -->
        <div style="background: linear-gradient(to right, #008080 , #000000); text-align: right; padding: 10px; font-weight: bold; color: white;">
        ¡Bienvenido(a), {{ session('user_data')['NOM_PERSONA'] }}!
        </div>



        <div class="image-container">
            <div class="text">  Justicia Municipal  </div>
        </div>

        <div>
            <h1> </h1>
        </div>

        <div class="slideshow-container">
        
            <div class="mySlides">
                <q>Departamento de justicia municipal </q>
                <p class="author">Talanga </p>
            </div>

            <div class="mySlides">
                <q>Talanga cada dia avanzando mas  </q>
                <p class="author"> SofTeam</p>
            </div>

            <div class="mySlides">
                <q>Somos Grandes</q>
                <p class="author">-Equipo Suave</p>
            </div>
            
            <a class="prev" onclick="plusSlides(-1)">❮</a>
            <a class="next" onclick="plusSlides(1)">❯</a>

        </div>

        <div class="dot-container">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
        </div>

        <script>
            var slideIndex = 1;
            showSlides(slideIndex);

            function plusSlides(n) {
                showSlides(slideIndex += n);
            }

            function currentSlide(n) {
                showSlides(slideIndex = n);
            }

            function showSlides(n) {
                var i;
                var slides = document.getElementsByClassName("mySlides");
                var dots = document.getElementsByClassName("dot");
                if (n > slides.length) {
                    slideIndex = 1
                }
                if (n < 1) {
                    slideIndex = slides.length
                }
                for (i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";
                }
                for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" active", "");
                }
                slides[slideIndex - 1].style.display = "block";
                dots[slideIndex - 1].className += " active";
            }
        </script>
        @if(session('notification'))
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    Swal.fire({
                        icon: '{{ session('notification')['type'] }}',
                        title: '{{ session('notification')['title'] }}',
                        text: '{{ session('notification')['message'] }}',
                    });
                </script>
        @endif
        @stop

    @section('css')


        <style>
            .checked {
                color: orange;
            }
        </style>

        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
            }

            .image-container {
                background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                                linear-gradient(to bottom, #87CEEB, #2E8B57); /* Degradado de colores de naturaleza */
                background-size: cover;
                position: relative;
                height: 400px;
            }

            /* Estilos al image-container */
            .image-container {
                /* Otros estilos de la image-container */
                position: relative;
                height: 400px;
            }

            .text {
                /* Estilos del texto */
                background-color: transparent;
                color: white;
                font-size: 6vw; /* Ajusta el tamaño del texto según tus necesidades */
                font-weight: bold;
                text-align: center;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 100%; /* Asegura que el texto ocupe todo el ancho de la container */
            }

        </style>

        <!--Estilo del segundo diseño-->
        <style>
            * {
                box-sizing: border-box
            }

            body {
                font-family: Verdana, sans-serif;
                margin: 0
            }

            .mySlides {
                display: none
            }

            img {
                vertical-align: middle;
            }


            /* Slideshow container */
            .slideshow-container {
                position: relative;
                background: #f3fcfdf1;
            }

            /* Slides */
            .mySlides {
                display: none;
                padding: 80px;
                text-align: center;
            }

            /* Next & previous buttons */
            .prev,
            .next {
                cursor: pointer;
                position: absolute;
                top: 50%;
                width: auto;
                margin-top: -30px;
                padding: 16px;
                color: rgb(82, 139, 139);
                font-weight: bold;
                font-size: 20px;
                border-radius: 0 3px 3px 0;
                user-select: none;
            }

            /* Position the "next button" to the right */
            .next {
                position: absolute;
                right: 0;
                border-radius: 3px 0 0 3px;
            }

            /* On hover, add a black background color with a little bit see-through */
            .prev:hover,
            .next:hover {
                background-color: rgba(0, 0, 0, 0.8);
                color: white;
            }

            /* The dot/bullet/indicator container */
            .dot-container {
                text-align: center;
                padding: 20px;
                background: #ddd;
            }

            /* The dots/bullets/indicators */
            .dot {
                cursor: pointer;
                height: 15px;
                width: 15px;
                margin: 0 2px;
                background-color: #bbb;
                border-radius: 50%;
                display: inline-block;
                transition: background-color 0.6s ease;
            }

            /* Add a background color to the active dot/circle */
            .active,
            .dot:hover {
                background-color: #717171;
            }

            /* Add an italic font style to all quotes */
            q {
                font-style: italic;
            }

            /* Add a blue color to the author */
            .author {
                color: cornflowerblue;
            }
        </style>
    @else
        <!-- Contenido para usuarios no autenticados -->
        <script>
            window.location.href = "{{ route('login') }}"; // Cambia 'login' con la ruta correcta
        </script>
    @endif

@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
   

@stop





