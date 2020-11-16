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

      $countPokeURL = "https://pokeapi.co/api/v2/pokemon";
      $countPoke = json_decode(file_get_contents($countPokeURL), true)['count'];

      $qntPokemon = pokemon::count();

      if($qntPokemon!=$countPoke){//Check if new pokemons were added OR removed (??)

        pokemon::truncate();
        $pokemonsURL = "https://pokeapi.co/api/v2/pokemon?offset=0&limit=".$countPoke;//getALL Pokemons
        $pokeJson = json_decode(file_get_contents($pokemonsURL), true);

        foreach($pokeJson['results'] as $poke){
          $pokeURL = $poke['url'];
          $pokemon = new pokemon;
          $pokemon->poke_name = $poke['name'];
          $pokemon->pokeURL = $poke['url'];
          $pokeStatsJSON = json_decode(file_get_contents($pokeURL), true);// get XP and HP
          $pokemon->base_experience = $pokeStatsJSON['base_experience'];//XP
          if(count($pokeStatsJSON['stats'])>0){
            $pokemon->HP = $pokeStatsJSON['stats'][0]['base_stat'];//HP
          }
          $pokemon->save();
        }
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
      $this->updatePokemons();
      // $this->updateTypesRelation();

      return response()->json('success');

    }

    public function getPokedexData(){
      $getPokemons = json_decode($this->getIncrementalData(0,0)->content());
      $qntPokemon = pokemon::count();

      return view('pokedex',compact('getPokemons','qntPokemon'));
    }

    public function getIncrementalData($offset,$qSearch){
      $getPokemons = DB::table('pokemon')
      ->select('id','poke_name','pokeURL','HP','base_experience')
      ->skip($offset)
      ->take(12)
      ->get();

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

      return response()->json($getPokemons);
    }

    public function save(Request $request){
      $fair = $request->fair;

      $ashArr=[];
      foreach($request->ashList as $pokemons){
        array_push($ashArr,$pokemons['pokeName']);
      }
      $teamRocketArr=[];
      foreach($request->teamRocketList as $pokemons){
        array_push($teamRocketArr,$pokemons['pokeName']);
      }

      $ashList = implode(',',$ashArr);
      $teamRocketList = implode(',',$teamRocketArr);

      DB::table('trade_history')
      ->insert([
        'ashPokemons' => $ashList,
        'teamRocketPokemons' => $teamRocketList,
        'fair' =>$fair
      ]);


      return response()->json('success');

    }

    public function getTradeHistory(){

      $historyData = DB::table('trade_history')
      ->select('id','ashPokemons','teamRocketPokemons','fair','created_at')
      ->get();

      return response()->json($historyData);

    }


}
