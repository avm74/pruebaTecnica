<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Functions;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpParser\Comment\Doc;
use stdClass;

class ReturnDocumentsController extends Controller
{
    public function getDocuments($relevance){

        if($relevance == 'todos'){
            $highRelevanceDocuments = Document::where('relevance', '=', 'Alta')->get();
            $mediumRelevanceDocuments = Document::where('relevance', '=', 'Media')->get();
            $lowRelevanceDocuments = Document::where('relevance', '=', 'Baja')->get();

            $highRelevanceArray = $this->getDocumentsIntoArray($highRelevanceDocuments);
            $mediumRelevanceArray = $this->getDocumentsIntoArray($mediumRelevanceDocuments);
            $lowRelevanceArray = $this->getDocumentsIntoArray($lowRelevanceDocuments);

            return response()->json([
                'code' => 200,
                'response' =>[
                    'documentos' => [
                        'alta' => $highRelevanceArray,
                        'media' => $mediumRelevanceArray,
                        'baja' => $lowRelevanceArray,
                    ]
                ]
            ]);

        }

        if($relevance == 'alta'){
            $highRelevanceDocuments = Document::where('relevance', '=', 'Alta')->get();

            $highRelevanceArray = $this->getDocumentsIntoArray($highRelevanceDocuments);

            return response()->json([
                'code' => 200,
                'response' =>[
                    'documentos' => $highRelevanceArray
                ]
            ]);
        }

        if($relevance == 'media'){
            $mediumRelevanceDocuments = Document::where('relevance', '=', 'Media')->get();

            $mediumRelevanceArray = $this->getDocumentsIntoArray($mediumRelevanceDocuments);

            return response()->json([
                'code' => 200,
                'response' =>[
                    'documentos' => $mediumRelevanceArray
                ]
            ]);
        }

        if($relevance == 'baja'){
            $lowRelevanceDocuments = Document::where('relevance', '=', 'Baja')->get();

            $lowRelevanceArray = $this->getDocumentsIntoArray($lowRelevanceDocuments);

            return response()->json([
                'code' => 200,
                'response' =>[
                    'documentos' => $lowRelevanceArray
                ]
            ]);
        }

        return response()->json([
            'code' => 400,
            'response' => 'ERROR AL FILTRAR POR RELEVANCIA. El parámetro relevancia debe tener uno de los siguientes valores: "todos", "alta", "media" o "baja".'
        ]);

    }

    private function getDocumentsIntoArray($documents){

        $docsArray = [];

        foreach ($documents as $document){

            $documentInfo = new stdClass();

            $documentInfo->document_id = $document->id;
            $documentInfo->user_id = $document->user_id;
            $documentInfo->name = $document->name;
            $documentInfo->description = $document->description;
            $documentInfo->created_at = date('d-m-Y H:i', strtotime($document->created_at));
            $documentInfo->updated_at = date('d-m-Y H:i', strtotime($document->updated_at));

            $docsArray[] = $documentInfo;
        }

        return $docsArray;

    }
}
