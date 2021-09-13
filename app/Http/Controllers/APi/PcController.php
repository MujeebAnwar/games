<?php

namespace App\Http\Controllers\APi;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Validator\ValidatorManager;
use App\Models\Pc;
use App\Models\Processor;
use Exception;
use Illuminate\Support\Str;





use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class PcController extends Controller
{
    // Return All Pc


    public function index()
    {
        $allPc = pc::orderBy('id','DESC')
        ->get();
    return response()->json([
        'status'  => true,
        'data' => $allPc
    ]);
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'name'  => 'required',
                'mother_board' => 'required',
                'processor' => 'required',
                'ram' => 'required',
                'graphic_card' => 'required',
                'power_supply' => 'required',
                'casing' => 'required',
                'ssd' => 'required',
                'hdd' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'processor_price' => 'required',
                'total_price' => 'required',
              

            ];
            // 'ram_price' => 'required',
            // 'ssd_price' => 'required',
            // 'hdd_price' => 'required',
            // 'ps_price' => 'required',
            // dd($request->all());


            $request->validate($rules);

           

            $processorsList =explode(',',$request->processor);
            $processorsPrice =explode(',',$request->processor_price);
            if(count($processorsList) != count($processorsPrice))
            {

                return response()->json([
                    'status'  => false,
                    'message' => 'Processors List And Price Not Matched'
                ]);
            }
            $image = $request->file('image');
            $fileName = Str::slug('image') . '_' . time() . '.' . $image->extension();
            $request->image->move(public_path('images/pc'), $fileName);
            
            $pcData = [];
            $pcData['name'] = $request->name;
            $pcData['mother_board'] = $request->mother_board;
            $pcData['ram'] = $request->ram;
            $pcData['graphic_card'] = $request->graphic_card;
            $pcData['casing'] = $request->casing;
            $pcData['ssd'] = $request->ssd;
            $pcData['hdd'] = $request->hdd;
            $pcData['power_supply'] = $request->power_supply;
            $pcData['pc_type'] = 1;
            $pcData['image'] = $fileName;
            $pcData['total_price'] = $request->total_price;

            $pcData['ram_price'] = $request->ram_price;
            $pcData['ssd_price'] = $request->ssd_price;
            $pcData['hdd_price'] = $request->hdd_price;
            $pcData['ps_price'] = $request->ps_price;

            // '' => 'required',
            // '' => 'required',
            // '' => 'required',
            // '' => 'required',
            $pc = Pc::create($pcData);
            $processors = [];
            foreach($processorsList as $key=>$processor)
            {
                $processors[] = [
                    'name' => $processor,
                    'pc_id' => $pc->id,
                    'price' => $processorsPrice[$key]
                ];
            }
            Processor::insert($processors);
            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'PC Added Successfully'
            ]);
            
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => $exception->getMessage()
            ]);
        }
    }


    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'name'  => 'required',
                'mother_board' => 'required',
                'processor' => 'required',
                'ram' => 'required',
                'graphic_card' => 'required',
                'power_supply' => 'required',
                'casing' => 'required',
                'ssd' => 'required',
                'hdd' => 'required',
                'processor_price' => 'required',
                'total_price' => 'required',
                'ram_price' => 'required',
                'ssd_price' => 'required',
                'hdd_price' => 'required',
                'ps_price' => 'required',


            ];

            if ($request->has('image') && !empty($request->image)) {
                $rules['image'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            }

            $request->validate($rules);

            $processorsList =explode(',',$request->processor);
            $processorsPrice =explode(',',$request->processor_price);
            if(count($processorsList) != count($processorsPrice))
            {

                return response()->json([
                    'status'  => false,
                    'message' => 'Processors List And Price Not Matched'
                ]);
            }

          
            $pcData = [];

              
            if ($request->has('image') && !empty($request->image)) {
                $image = $request->file('image');
                $fileName = Str::slug('image') . '_' . time() . '.' . $image->extension();
                $request->image->move(public_path('images/pc'), $fileName);
                $pcData['image'] = $fileName;
            }
            $pcData['name'] = $request->name;
            $pcData['mother_board'] = $request->mother_board;
            $pcData['ram'] = $request->ram;
            $pcData['graphic_card'] = $request->graphic_card;
            $pcData['casing'] = $request->casing;
            $pcData['ssd'] = $request->ssd;
            $pcData['hdd'] = $request->hdd;
            $pcData['power_supply'] = $request->power_supply;
            $pcData['total_price'] = $request->total_price;

            $pcData['ram_price'] = $request->ram_price;
            $pcData['ssd_price'] = $request->ssd_price;
            $pcData['hdd_price'] = $request->hdd_price;
            $pcData['ps_price'] = $request->ps_price;


            $pc  = Pc::findOrFail($request->pc_id);
            $pc->update($pcData);

            $processors = [];
            foreach($processorsList as $key=>$processor)
            {
                $processors[] = [
                    'name' => $processor,
                    'pc_id' => $pc->id,
                    'price' => $processorsPrice[$key]
                ];
            }
            Processor::where('pc_id',$pc->id)->delete();
            Processor::insert($processors);
            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'PC Updated Successfully'
            ]);
            
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => $exception->getMessage()
            ]);
        }
    }



    public function delete(Request $request, $id)
    {

        DB::beginTransaction();
        try {



            Pc::findOrFail($id)->delete();
            Processor::where('pc_id',$id)->delete();

            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Pc Deleted Successfully'
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => $exception->getMessage()
            ]);
        }
    }


    // Legacy PC Store


    public function legacyStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'name'  => 'required',
                'mother_board' => 'required',
                'processor' => 'required',
                'ram' => 'required',
                'graphic_card' => 'required',
                'power_supply' => 'required',
                'casing' => 'required',
                'ssd' => 'required',
                'hdd' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'processor_price' => 'required',
                'total_price' => 'required',
                'ram_price' => 'required',
                'ssd_price' => 'required',
                'hdd_price' => 'required',
                'ps_price' => 'required',



            ];



            $request->validate($rules);

           

            $processorsList =explode(',',$request->processor);
            $processorsPrice =explode(',',$request->processor_price);
            if(count($processorsList) != count($processorsPrice))
            {

                return response()->json([
                    'status'  => false,
                    'message' => 'Processors List And Price Not Matched'
                ]);
            }
            
            $image = $request->file('image');
            $fileName = Str::slug('image') . '_' . time() . '.' . $image->extension();
            $request->image->move(public_path('images/pc'), $fileName);

            

            $pcData = [];

            $pcData['name'] = $request->name;
            $pcData['mother_board'] = $request->mother_board;
            $pcData['ram'] = $request->ram;
            $pcData['graphic_card'] = $request->graphic_card;
            $pcData['casing'] = $request->casing;
            $pcData['ssd'] = $request->ssd;
            $pcData['hdd'] = $request->hdd;
            $pcData['power_supply'] = $request->power_supply;
            $pcData['pc_type'] = 2;
            $pcData['image'] = $fileName;
            $pcData['total_price'] = $request->total_price;

            
            $pcData['ram_price'] = $request->ram_price;
            $pcData['ssd_price'] = $request->ssd_price;
            $pcData['hdd_price'] = $request->hdd_price;
            $pcData['ps_price'] = $request->ps_price;

            $pc = Pc::create($pcData);

            $processors = [];
            foreach($processorsList as $key=>$processor)
            {
                $processors[] = [
                    'name' => $processor,
                    'pc_id' => $pc->id,
                    'price' => $processorsPrice[$key]
                ];
            }
            Processor::insert($processors);
            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'PC Added Successfully'
            ]);
            
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => $exception->getMessage()
            ]);
        }
    }


    // WorK Station Pc

    public function workstationStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'name'  => 'required',
                'mother_board' => 'required',
                'processor' => 'required',
                'ram' => 'required',
                'graphic_card' => 'required',
                'power_supply' => 'required',
                'casing' => 'required',
                'ssd' => 'required',
                'hdd' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'processor_price' => 'required',
                'total_price' => 'required',
                'ram_price' => 'required',
                'ssd_price' => 'required',
                'hdd_price' => 'required',
                'ps_price' => 'required',



            ];


            $request->validate($rules);

           

            $processorsList =explode(',',$request->processor);
            $processorsPrice =explode(',',$request->processor_price);
            if(count($processorsList) != count($processorsPrice))
            {

                return response()->json([
                    'status'  => false,
                    'message' => 'Processors List And Price Not Matched'
                ]);
            }
            $image = $request->file('image');
            $fileName = Str::slug('image') . '_' . time() . '.' . $image->extension();
            $request->image->move(public_path('images/pc'), $fileName);

            $pcData = [];

            $pcData['name'] = $request->name;
            $pcData['mother_board'] = $request->mother_board;
            $pcData['ram'] = $request->ram;
            $pcData['graphic_card'] = $request->graphic_card;
            $pcData['casing'] = $request->casing;
            $pcData['ssd'] = $request->ssd;
            $pcData['hdd'] = $request->hdd;
            $pcData['power_supply'] = $request->power_supply;
            $pcData['pc_type'] = 3;
            $pcData['image'] = $fileName;
            $pcData['total_price'] = $request->total_price;

            $pcData['ram_price'] = $request->ram_price;
            $pcData['ssd_price'] = $request->ssd_price;
            $pcData['hdd_price'] = $request->hdd_price;
            $pcData['ps_price'] = $request->ps_price;

            
            $pc = Pc::create($pcData);

            $processors = [];
            foreach($processorsList as $processor)
            foreach($processorsList as $key=>$processor)
            {
                $processors[] = [
                    'name' => $processor,
                    'pc_id' => $pc->id,
                    'price' => $processorsPrice[$key]
                ];
            }
            Processor::insert($processors);
            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'PC Added Successfully'
            ]);
            
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => $exception->getMessage()
            ]);
        }
    }
}



