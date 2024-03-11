<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{

    private $disk = "public";
    public function loadView()
    {
        $files = [];

        foreach (Storage::disk($this->disk)->files() as $file) {
            $name = str_replace("$this->disk/", "", $file);

            $picture = "";

            $downloadLink = route("download", $name);

                $files[] = [
                    "picture" => $picture,
                    "name" => $name,
                    "link" => $downloadLink,
                    "size" => Storage::disk($this->disk)->size($name)
                ];
        }

        return view('selections', ["files"=>$files]);
    }

    public function storeFile(Request $req){
        // Storage::disk('public')->put("texto.txt", "Hola"); //PERMITE GUARDAR Y ESCRIBIR
        if($req->isMethod('POST')){
            $file = $req->file('file');
            $name = $req->input('name');

            $file->storeAs('',$name.".".$file->extension(), $this->disk);
        }
        return redirect()->route('listaSelecciones');
    }

    public function downloadFile($name){

    }
}
