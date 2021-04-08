<?php

namespace App\Http\Controllers\Word;

use App\Http\Controllers\Controller;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WordController extends Controller
{
    public function index()
    {
        $traffic_accident = Word::where("type", 0)->get(); //Trafik kazası
        $work_accident = Word::where("type", 1)->get(); //İş kazası
        $tows = Word::where("type", 2)->get(); //Çekici Bildirimi

        return view('word.index')
            ->with("traffic_accident", $traffic_accident)
            ->with("work_accident", $work_accident)
            ->with("tows", $tows);
    }

    public function getAdd()
    {
        return view('word.add');
    }

    public function create(Request $request)
    {
        $rules = [
            'accident_type' => 'required',
            'word' => 'required',
        ];
        $errorMessage = [
            'accident_type.required' => 'Lütfen Kaza Tipini Seçiniz!',
            'word.required' => 'Lütfen kelimeyi giriniz!'
        ];
        $validator = Validator::make($request->all(), $rules, $errorMessage);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $accident_type = $request->get("accident_type");
        $word = $request->get("word");
        $wordCreate = new Word;
        $wordCreate->type = $accident_type;
        $wordCreate->name = $word;
        $wordCreate->save();
        return redirect()->route('admin.word.index');
    }

    public function delete(Request $request){
        try{
            $id = $request->get("id");
            $word = Word::where("id", $id)->first();
            if(isset($word)){
                $word->delete();
                return response()->json(['status' => 1, 'message' => "Başarıyla Silindi!"]);
            }else{
                return response()->json(['status' => 0, 'message' => "ID BULUNAMADI!"]);
            }
        }catch (\Exception $e){
            return response()->json(['status' => 0, 'message' => "Bir Hata Oluştu: ".$e->getMessage()]);
        }
    }
}
