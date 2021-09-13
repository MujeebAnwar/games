<?php

namespace App\Http\Controllers\APi;

use App\Http\Controllers\Controller;
use App\Http\Validator\ValidatorManager;
use App\Models\Game;
use App\Models\Pc;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


use Illuminate\Support\Str;

class GameController extends Controller
{
    //  


    // Create Game

    public function createGames(Request $request)
    {
        DB::beginTransaction();
        try {


            $rules = [
                'name'  => 'required',
                'description' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'sort_id' => 'required',
                'avg_pc_name' => 'required',
                'avg_pc_processor' => 'required',
                'avg_pc_ram' => 'required',
                'avg_pc_graphicCard' => 'required',
                'best_pc_name' => 'required',
                'best_pc_processor' => 'required',
                'best_pc_ram' => 'required',
                'best_pc_graphicCard' => 'required'

            ];


            $request->validate($rules);



            $gameData = [];
            $avgPc = [];
            $avgPc['name'] = $request->avg_pc_name;
            $avgPc['processor'] = $request->avg_pc_processor;
            $avgPc['ram'] = $request->avg_pc_ram;
            $avgPc['graphicCard'] = $request->avg_pc_graphicCard;

            $bestPc = [];
            $bestPc['name'] = $request->best_pc_name;
            $bestPc['processor'] = $request->best_pc_processor;
            $bestPc['ram'] = $request->best_pc_ram;
            $bestPc['graphicCard'] = $request->best_pc_graphicCard;

            $image = $request->file('image');
            // $file = $image->getClientOriginalName();
            // $filename = pathinfo($file, PATHINFO_FILENAME);

            $fileName = Str::slug('image') . '_' . time() . '.' . $image->extension();
            $request->image->move(public_path('images/games'), $fileName);


            $gameData['name'] = $request->name;
            $gameData['description'] = $request->description;
            $gameData['image'] = $fileName;
            $gameData['sort_id'] = $request->sort_id;
            $gameData['avg_pc_name'] = $request->avg_pc_name;
            $gameData['avg_pc_processor'] = $request->avg_pc_processor;
            $gameData['avg_pc_ram'] = $request->avg_pc_ram;
            $gameData['avg_pc_graphicCard'] = $request->avg_pc_graphicCard;

            $gameData['best_pc_name'] = $request->best_pc_name;
            $gameData['best_pc_processor'] = $request->best_pc_processor;
            $gameData['best_pc_ram'] = $request->best_pc_ram;
            $gameData['best_pc_graphicCard'] = $request->avg_pc_graphicCard;


            Game::create($gameData);

            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Game Added Successfully'
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => $exception->getMessage()
            ]);
        }
    }

    // Create Game

    public function updateGame(Request $request)
    {
        DB::beginTransaction();
        try {


            $rules = [
                'name'  => 'required',
                'description' => 'required',
                'sort_id' => 'required',
                'avg_pc_name' => 'required',
                'avg_pc_processor' => 'required',
                'avg_pc_ram' => 'required',
                'avg_pc_graphicCard' => 'required',
                'best_pc_name' => 'required',
                'best_pc_processor' => 'required',
                'best_pc_ram' => 'required',
                'best_pc_graphicCard' => 'required'
            ];


            if ($request->has('image') && !empty($request->image)) {
                $rules['image'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            }


            $request->validate($rules);



            $gameData = [];
            $avgPc = [];
            $avgPc['name'] = $request->avg_pc_name;
            $avgPc['processor'] = $request->avg_pc_processor;
            $avgPc['ram'] = $request->avg_pc_ram;
            $avgPc['graphicCard'] = $request->avg_pc_graphicCard;

            $bestPc = [];
            $bestPc['name'] = $request->best_pc_name;
            $bestPc['processor'] = $request->best_pc_processor;
            $bestPc['ram'] = $request->best_pc_ram;
            $bestPc['graphicCard'] = $request->best_pc_graphicCard;


            if ($request->has('image') && !empty($request->image)) {
                $image = $request->file('image');
                $fileName = Str::slug('image') . '_' . time() . '.' . $image->extension();
                $request->image->move(public_path('images/games'), $fileName);
                $gameData['image'] = $fileName;
            }

            $gameData['name'] = $request->name;
            $gameData['description'] = $request->description;
            $gameData['sort_id'] = $request->sort_id;
            $gameData['avg_pc_name'] = $request->avg_pc_name;
            $gameData['avg_pc_processor'] = $request->avg_pc_processor;
            $gameData['avg_pc_ram'] = $request->avg_pc_ram;
            $gameData['avg_pc_graphicCard'] = $request->avg_pc_graphicCard;

            $gameData['best_pc_name'] = $request->best_pc_name;
            $gameData['best_pc_processor'] = $request->best_pc_processor;
            $gameData['best_pc_ram'] = $request->best_pc_ram;
            $gameData['best_pc_graphicCard'] = $request->avg_pc_graphicCard;
            Game::findOrFail($request->id)->update($gameData);

            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Game Updated Successfully'
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function deleteGame(Request $request, $id)
    {

        DB::beginTransaction();
        try {



            Game::find($id)->delete();

            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Game Deleted Successfully'
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => $exception->getMessage()
            ]);
        }
    }


    // Get Top 10 Games
    public function getTopGames()
    {
        # code.
        $games = Game::orderBy('sort_id')
            ->get();
        return response()->json([
            'status'  => true,
            'data' => $games
        ]);
    }


    public function homeData()
    {
        $games = Game::orderBy('sort_id')
            ->take(10)
            ->get();
        $allPc = Pc::whereHas('processors')->with('processors')
        ->where('pc_type',1)
        ->orderBy('id','DESC')
        ->get();

        $legacyPc = Pc::whereHas('processors')
        ->with('processors')
        ->where('pc_type',2)
        ->orderBy('id','DESC')
        ->get();


        $workstationPc = Pc::whereHas('processors')
        ->with('processors')
        ->where('pc_type',3)
        ->orderBy('id','DESC')
        ->get();

        
        return response()->json([
            'status'  => true,
            'data' => [
                'games'=>$games,
                'pc' => $allPc,
                'legacyPc' => $legacyPc,
                'workstationPc' => $workstationPc
            ]
        ]);
    }
}
