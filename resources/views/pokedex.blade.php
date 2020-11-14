<!DOCTYPE html>
<html ng-app="pokedex">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pokédex</title>
    <link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/bootstrap-theme.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/main.css')}}">
</head>

<body>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <img src="img/logo.png">
                    Pokédex
                </a>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div>
            <div class="page-header">
                <h1>Pokédex <small class="pull-right">Mostrando <span class="badge">{{$qntPokemon}}</span> Pokémons</small></h1>
            </div>
            <div class='row' id='lista-pokemon'>
                @foreach($getPokemons  as $pokemon)
                  <div class="col-lg-3">
                      <div class="pokemon panel panel-primary">
                          <div class="panel-heading">
                              <h1>
                                  {{$pokemon->poke_name}}
                                  {{-- <small>Seed Pokémon</small> --}}
                                  <span class="label label-primary pull-right">#{{explode('/',$pokemon->pokeURL)[6]}}</span>
                              </h1>
                          </div>
                          <div class="panel-body">
                              <a >
                                  <img class="avatar center-block" src="img/pokemons/{{$pokemon->poke_name}}.png">
                              </a>
                          </div>
                          <div class="panel-footer">
                              <div class="text-center">
                                @foreach($pokemon->types as $type)
                                  <a>
                                      <span class="label type type-{{$type}}">
                                          {{$type}}
                                      </span>
                                  </a>
                                @endforeach
                              </div>
                          </div>
                      </div>
                  </div>
                @endforeach
                <div id="moreContent"></div>
                <div class='loadingContent'></div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="js/app.js"></script>
</body>

</html>
