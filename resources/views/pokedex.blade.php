<!DOCTYPE html>
<html ng-app="pokedex">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pokédex</title>
    <link rel="icon" href="{{asset('/img/pokeball.png')}}" type="image/x-icon" />
    <link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/bootstrap-theme.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('/Fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('js/introJS/introjs-nassim.css')}}">
    <link rel="stylesheet" href="{{asset('js/introJS/introjs.min.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand text-center" href="#">
                    <img src="img/logo.png">
                    Pokédex
                </a>
            </div>
            <div class='pull-right'>
                <div class="searchbar">
                    <input class="search_input" type="text" name="" placeholder="Search...">
                    <a href="#" class="search_icon" onclick='swal.fire({title:"Function under development.."})'><i class="fa fa-search"></i></a>
                </div>
            </div>
        </div>
    </div><br /><br />
    <div class="container-fluid">
        <div class="modal fade" id="tradeHistory" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="">Trade History</h4>
              </div>
              <div class="modal-body">
                <div class='table-responsive'>
                  <table class='table table-striped table-hover'>
                    <thead>
                      <th>Trade ID</th>
                      <th>Ash Pokemons</th>
                      <th>Team Rocket Pokemons</th>
                      <th>Result</th>
                      <th>Transaction Date</th>
                    </thead>
                    <tbody id='tradeHistoryBody'>

                    </tbody>
                  </table>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn btn-primary"></button> --}}
              </div>
            </div>
          </div>
        </div>
        <div>
            <div id='tradePanel'>
                {{-- <div id='tradePanel'> --}}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">
                          <button class='btn btn-danger btn-sm pull-left' onclick='clearTradeList()' id='clearButton' style='visibility:hidden'><i class="fas fa-eraser"></i> Clear</button>
                          <img src='img/tradeSimulator.png' style='width:200px;position:sticky;' data-intro='Wellcome to Poketrade!'/>
                          <button class='btn btn-info btn-sm pull-right' onclick='getTradeHistory()'><i class='fa fa-history'></i> History</button>
                        </h3>
                        {{-- <h3 class="panel-title text-center" style='font-family:cursive;'>Trade Simulator</h3> --}}
                    </div>
                    <div class="panel-body" data-intro='Pokemons selected will be added on one of these two players!'>
                        <div class='text-center'>
                          <span id='ashXP'> </span> <span id='tradeResult'> ? </span><span id='teamRocketXP'> </span>
                        </div>
                        <div id='ashPanel' class='col-md-6' data-intro='Ash Pokemons will be added here...'>
                            <div id='ashPokeballs'>
                              <span class="iconify ashPokeball0" data-icon="mdi-pokeball" data-inline="false"></span>
                              <span class="iconify ashPokeball1" data-icon="mdi-pokeball" data-inline="false"></span>
                              <span class="iconify ashPokeball2" data-icon="mdi-pokeball" data-inline="false"></span>
                              <span class="iconify ashPokeball3" data-icon="mdi-pokeball" data-inline="false"></span>
                              <span class="iconify ashPokeball4" data-icon="mdi-pokeball" data-inline="false"></span>
                              <span class="iconify ashPokeball5" data-icon="mdi-pokeball" data-inline="false"></span>
                            </div>

                            <div id='ashPanelBody' class='pull-left' style='margin-top:0px;'>
                              <div class='ashPanel5 tradeList pull-right' style='padding:2px'>
                                <div class="panel panel-default">
                                  <div class="panel-body">

                                  </div>
                                </div>
                              </div>
                              <div class='ashPanel4 tradeList pull-right' style='padding:2px'>
                                <div class="panel panel-default">
                                  <div class="panel-body">

                                  </div>
                                </div>
                              </div>
                              <div class='ashPanel3 tradeList pull-right' style='padding:2px'>
                                <div class="panel panel-default">
                                  <div class="panel-body">

                                  </div>
                                </div>
                              </div>
                              <div class='ashPanel2 tradeList pull-right' style='padding:2px'>
                                <div class="panel panel-default">
                                  <div class="panel-body">

                                  </div>
                                </div>
                              </div>
                              <div class='ashPanel1 tradeList pull-right' style='padding:2px'>
                                <div class="panel panel-default">
                                  <div class="panel-body">

                                  </div>
                                </div>
                              </div>
                              <div class='ashPanel0 tradeList pull-right' style='padding:2px'>
                                <div class="panel panel-default">
                                  <div class="panel-body">

                                  </div>
                                </div>
                              </div>
                              <img class='pull-left' src='img/ash.webp' style='width:100px;'/>
                            </div>
                        </div>
                        {{-- <div class="vl" style=' border-left: 1px solid green;height: 100px;'></div> --}}
                        <div id='teamRocketPanel' class='col-md-6' data-intro='... and Team Rocket Pokemonn here'>
                            <div class='pull-right' id='teamRocketPokeballs'>
                              <span class="iconify teamRocketPokeball0" data-icon="mdi-pokeball" data-inline="false"></span>
                              <span class="iconify teamRocketPokeball1" data-icon="mdi-pokeball" data-inline="false"></span>
                              <span class="iconify teamRocketPokeball2" data-icon="mdi-pokeball" data-inline="false"></span>
                              <span class="iconify teamRocketPokeball3" data-icon="mdi-pokeball" data-inline="false"></span>
                              <span class="iconify teamRocketPokeball4" data-icon="mdi-pokeball" data-inline="false"></span>
                              <span class="iconify teamRocketPokeball5" data-icon="mdi-pokeball" data-inline="false"></span>
                            </div><br />
                            <img class='pull-right' src='img/team_rocket.png' style='width:100px;position:sticky;'/>
                            <div id='teamRocketPanelBody ' style='margin-top:0px;'>
                              <div class='rocketTeamPanel0 tradeList pull-right' style='padding:2px'>
                                <div class="panel panel-default">
                                  <div class="panel-body">

                                  </div>
                                </div>
                              </div>
                              <div class='rocketTeamPanel1 tradeList pull-right' style='padding:2px'>
                                <div class="panel panel-default">
                                  <div class="panel-body">

                                  </div>
                                </div>
                              </div>
                              <div class='rocketTeamPanel2 tradeList pull-right' style='padding:2px'>
                                <div class="panel panel-default">
                                  <div class="panel-body">

                                  </div>
                                </div>
                              </div>
                              <div class='rocketTeamPanel3 tradeList pull-right' style='padding:2px'>
                                <div class="panel panel-default">
                                  <div class="panel-body">

                                  </div>
                                </div>
                              </div>
                              <div class='rocketTeamPanel4 tradeList pull-right' style='padding:2px'>
                                <div class="panel panel-default">
                                  <div class="panel-body">

                                  </div>
                                </div>
                              </div>
                              <div class='rocketTeamPanel5 tradeList pull-right' style='padding:2px'>
                                <div class="panel panel-default">
                                  <div class="panel-body">

                                  </div>
                                </div>
                              </div>
                            </div>

                        </div>

                    </div>

                    <div class="panel-footer" style='display:none' id='tradeFooter'>
                      <div class='text-center'>
                        <button class='btn btn-success' onclick='saveTrade()'> <i class='fa fa-save'></i> &ensp;Save trade</button>
                      </div>
                    </div>
                </div>
            </div>
            <div class="page-header">
                {{-- <h1>Pokédex <small class="pull-right"><span class=""><b>{{$qntPokemon}}</b></span> Pokémons found ! </small></h1> --}}
                <h1><img src='img/pokedex.png' style='width:200px;position:sticky;' data-intro='You can search for desired Pokemons here in your Pokedex'/> <small class="pull-right"><span class=""><b>{{$qntPokemon}}</b></span> Pokémons found ! </small></h1>
                <button class='btn btn-sm btn-danger' onclick='updateDatabase()'><i class="fas fa-sync-alt"></i> Update Pokedex Database</button>
                <br />
            </div>
            <div class='row' id='lista-pokemon'>
                @foreach($getPokemons as $key => $pokemon)
                <div class="col-md-3">
                    <div class="pokemon panel panel-primary">
                        <div class="panel-heading">
                            <h1>
                                {{strtoupper($pokemon->poke_name)}}
                                {{-- <small>Seed Pokémon</small> --}}
                                <span class="label label-primary pull-right">#{{explode('/',$pokemon->pokeURL)[6]}}</span>
                            </h1>
                        </div>
                        <div class="panel-body">
                            <a onclick="addPokeTrade('{{$pokemon->poke_name}}','{{$pokemon->base_experience}}','.ashPanel')" ><img data-toggle="tooltip" title="Add in Ash trade!" class='ashImage' src='img/pokeball_2.png' style='width:35px;position:sticky;' {{ $key ==  0 ? 'data-intro=To&ensp;add&ensp;a&ensp;pokemon&ensp;to&ensp;Ash,&ensp;click&ensp;in&ensp;the&ensp;red&ensp;Pokeball&ensp;' : ''  }}/></a>
                            <a onclick="addPokeTrade('{{$pokemon->poke_name}}','{{$pokemon->base_experience}}','.rocketTeamPanel')"><img data-toggle="tooltip" title="Add in Team Rocket trade!" class='teamRocketImage pull-right' src='img/teamrocket_ball.png' style='width:32px;position:sticky;' {{ $key ==  0 ? 'data-intro=To&ensp;add&ensp;a&ensp;pokemon&ensp;to&ensp;Team&ensp;Rocket,&ensp;click&ensp;in&ensp;the&ensp;black&ensp;Pokeball&ensp;' : ''  }}/></a>
                            <a>
                                <img class="avatar center-block" src="img/pokemons/{{$pokemon->poke_name}}.png">
                            </a>
                        </div>
                        <div class="panel-footer">
                          <span style='font-size:0.9em'><i class="fa fa-heartbeat"></i> HP: {{$pokemon->HP}}</span>
                          <span style='font-size:0.9em' class='pull-right'><i class="fa fa-fist-raised"></i> XP: {{$pokemon->base_experience}}</span>
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
    <script src="js/jquery/jquery-3.3.1.min.js"></script>
    <script src="js/app.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/iconify.min.js"></script>
    <script src="js/sweetalert2.js"></script>
    <script src="js/introJS/intro.min.js"></script>
</body>

</html>
