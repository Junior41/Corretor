<html>
    <head>
        <title>Página principal</title>
        <link rel="stylesheet" href= "{{asset('css/app.css')}}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    </head>
    <body>
        <nav class="nav">
            <a class="nav-link active" href="https://www.instagram.com/juniorbrandaoo_/"><i class="bi-instagram"></i></a>
            <a class="nav-link active" href="https://www.linkedin.com/in/junior-brand%C3%A3o-415b981a5/"><i class="bi-linkedin"></i></a>
            <a class="nav-link active" href="https://github.com/Junior41"><i class="bi-github"></i></a>
        </nav>
        @isset($data)
            @if(count($data) > 0)
                @component('componentes.index', ["palavras" => $data[0], "linhas" => $data[1], "porcentagemErro" => $porcentagemErro] )
            @else
                @component('componentes.index', ["palavras" => [], "linhas" => [], "porcentagemErro" => $porcentagemErro] )
            @endif

            @endcomponent

        @else
            @component('componentes.form')
            @endcomponent
        @endisset

    </body>
</html>