<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\pokeType;
use App\Models\pokemon;
use DB;
use File;
use Image;
use Storage;


class pokedexController extends Controller
{

    function updatePokemons(){
      pokemon::truncate();
      $pokemonsURL = "https://pokeapi.co/api/v2/pokemon?offset=0&limit=2000";
      $pokeJson = json_decode(file_get_contents($pokemonsURL), true);

      foreach($pokeJson['results'] as $pokeJson){
        $pokemon = new pokemon;
        $pokemon->poke_name = $pokeJson['name'];
        $pokemon->pokeURL = $pokeJson['url'];
        $pokemon->save();
      }
    }

    function updateTypes(){
      pokeType::truncate();

      $typesURL =  "https://pokeapi.co/api/v2/type/";
      $typeJson = json_decode(file_get_contents($typesURL), true);

      // dd($typeJson['results']);
      foreach($typeJson['results'] as $type){
        $pokeType = new pokeType;
        $pokeType->description = $type['name'];
        $pokeType->type_url = $type['url'];
        $pokeType->save();
      }
    }

    function updateTypesRelation(){

      DB::table('pokemon_has_type')->truncate();
      File::cleanDirectory('img/pokemons/');

      $getPokemons = DB::table('pokemon')
      ->select('id','poke_name','pokeURL')
      ->get();

      foreach($getPokemons as $pokemon){
        $getPokeTypeURL = $pokemon->pokeURL;
        $PokeTypeJson = json_decode(file_get_contents($getPokeTypeURL), true);
        foreach($PokeTypeJson['types'] as $pokeType){
          $pokeTypeID = pokeType::where('description',$pokeType['type']['name'])->first();
          DB::table('pokemon_has_type')
          ->insert([
            'type_id'    => $pokeTypeID->id,
            'pokemon_id' => $pokemon->id
          ]);
        }
        $imgURL = $PokeTypeJson['sprites']['other']['official-artwork']['front_default'];
        Image::make($imgURL)->save(public_path('/img/pokemons/'.$pokemon->poke_name.'.png'));
      }
    }

    public function update(){

      // $this->updateTypes();
      // $this->updatePokemons();
      $this->updateTypesRelation();
      $this->updateJSON();

      dd('success');

    }

    function updateJSON(){
      $getPokemons = DB::table('pokemon')
      ->select('id','poke_name','pokeURL')
      ->get();
      // ->take(200);

      $qntPokemon = count($getPokemons);

      foreach($getPokemons as $pokemon){
          $typesArr=array();
          $types = DB::table('pokemon_has_type as PHT')
          ->select('PT.description')
          ->join('poke_type as PT','PT.id','PHT.type_id')
          ->where('PHT.pokemon_id',$pokemon->id)
          ->groupBy('PT.description')
          ->get();
          foreach($types as $type){
            array_push($typesArr,$type->description);
          }
          $pokemon->types = $typesArr;
      }


      // return json_encode($getPokemons->toJson());
      Storage::put('pokedex.json', $getPokemons);

    }


    public function getPokedexData(){
      $getPokemons = DB::table('pokemon')
      ->select('id','poke_name','pokeURL')
      ->take(10)
      ->get();

      $qntPokemon = count($getPokemons);

      foreach($getPokemons as $pokemon){
          $typesArr=array();
          $types = DB::table('pokemon_has_type as PHT')
          ->select('PT.description')
          ->join('poke_type as PT','PT.id','PHT.type_id')
          ->where('PHT.pokemon_id',$pokemon->id)
          ->groupBy('PT.description')
          ->get();
          foreach($types as $type){
            array_push($typesArr,$type->description);
          }
          $pokemon->types = $typesArr;
      }


      // return json_encode($getPokemons->toJson());
      // dd(Storage::put('pokedex.json', $getPokemons));
      // $this->updateJSON();

      // dd();

      return view('pokedex',compact('getPokemons','qntPokemon'));
    }

}
