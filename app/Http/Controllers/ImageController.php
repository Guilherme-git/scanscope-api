<?php

namespace App\Http\Controllers;

use App\Models\Health;
use App\Models\Image;
use App\Models\Medication;
use App\Models\Smoker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function create(Request $request)
    {
        $image = new Image();

        if ($request->image != '' && $request->image != null && strpos($request->image, ';base64')) {
            $base64 = $request->image;

            //obtem a extensão
            $extension = explode('/', $base64);
            $extension = explode(';', $extension[1]);
            $extension = '.' . $extension[0];

            //gera o nome
            $name = time() . $extension;

            //obtem o arquivo
            $separatorFile = explode(',', $base64);
            $file = $separatorFile[1];
            $path = 'image';

            //envia o arquivo
            Storage::put("$path/$path.$name", base64_decode($file));

            $image->image = "$path/$path.$name";
        }
        $image->latitude = $request->latitude;
        $image->longitude = $request->longitude;
        $image->patient = $request->patient;
        $image->date = $request->date;
        $image->name = $request->name;
        $image->email = $request->email;
        $image->birthdate = $request->birthdate;
        $image->age = $request->age;
        $image->gender = $request->gender;
        $image->covid = $request->covid;
        $image->pathology = $request->pathology;
        $image->save();

        $health = new Health();
        $health->value = $request['healthProblem']['value'];
        $health->others = $request['healthProblem']['others'];
        $health->image = $image->id;
        $health->save();

        $smoker = new Smoker();
        $smoker->value = $request['smoker']['value'];
        $smoker->others = $request['smoker']['others'];
        $smoker->image = $image->id;
        $smoker->save();

        $medication = new Medication();
        $medication->value = $request['medication']['value'];
        $medication->others = $request['medication']['others'];
        $medication->image = $image->id;
        $medication->save();


        return response()->json(["message"=>"Save", "image"=>[$image->latitude,$image->longitude,$image->image]]);
    }

    public function edit(Request $request)
    {
        $image = Image::find($request->idImage);
        $image->latitude = $request->latitude;
        $image->longitude = $request->longitude;
        $image->date = $request->date;
        $image->name = $request->name;
        $image->email = $request->email;
        $image->birthdate = $request->birthdate;
        $image->age = $request->age;
        $image->gender = $request->gender;
        $image->covid = $request->covid;
        $image->pathology = $request->pathology;

        $health = Health::where('image','=',$request->idImage)->get();
        $healthD = Health::find($health->get(0)->id);
        $healthD->value = $request['healthProblem']['value'];
        $healthD->others = $request['healthProblem']['others'];

        $smoker = Smoker::where('image','=',$request->idImage)->get();
        $smokerD = Smoker::find($smoker->get(0)->id);
        $smokerD->value = $request['smoker']['value'];
        $smokerD->others = $request['smoker']['others'];

        $medication = Medication::where('image','=',$request->idImage)->get();
        $medicationD = Medication::find($medication->get(0)->id);
        $medicationD->value = $request['medication']['value'];
        $medicationD->others = $request['medication']['others'];


        if ($request->image != '' && $request->image != null && strpos($request->image, ';base64')) {
            Storage::delete($image->image);
            $base64 = $request->image;

            //obtem a extensão
            $extension = explode('/', $base64);
            $extension = explode(';', $extension[1]);
            $extension = '.' . $extension[0];

            //gera o nome
            $name = time() . $extension;

            //obtem o arquivo
            $separatorFile = explode(',', $base64);
            $file = $separatorFile[1];
            $path = 'image';

            //envia o arquivo
            Storage::put("$path/$path.$name", base64_decode($file));

            $image->image = "$path/$path.$name";
        }
        $image->save();
        $healthD->save();
        $smokerD->save();
        $medicationD->save();
        return response()->json(["message"=>"Save", "image"=>[$image->latitude,$image->longitude,$image->image]]);
    }

    public function show(Request $request)
    {
        $image = Image::where('id','=',$request->idImage)
            ->with('healthProblem')
            ->with('medication')
            ->with('smoker')
            ->get();

        return $image->get(0);
    }

    public function list(Request $request)
    {
        $image = Image::orderBy('id','DESC')
            ->with('healthProblem')
            ->with('medication')
            ->with('smoker')
            ->get();
        return $image;
    }

    public function delete(Request $request)
    {
        $image = Image::find($request->idImage);

        $health = Health::where('image','=',$request->idImage)->get();
        $healthD = Health::find($health->get(0)->id);
        $healthD->delete();

        $smoker = Smoker::where('image','=',$request->idImage)->get();
        $smokerD = Smoker::find($smoker->get(0)->id);
        $smokerD->delete();

        $medication = Medication::where('image','=',$request->idImage)->get();
        $medicationD = Medication::find($medication->get(0)->id);
        $medicationD->delete();

        if($image->image !== null) {
            Storage::delete($image->image);
        }
        $image->delete();
        return response()->json(['message'=>"Deleted"]);
    }
}
