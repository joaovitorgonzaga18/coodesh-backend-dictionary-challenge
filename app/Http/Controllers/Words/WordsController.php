<?php

namespace App\Http\Controllers\Words;

use App\Domain\Words\WordsDataValidator;
use App\Http\Controllers\Controller;
use App\Models\UserFavorite;
use App\Models\UserHistory;
use App\Models\Words;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Exception;

class WordsController extends Controller {

    private const WORDS_API_BASE_URI = 'https://api.dictionaryapi.dev/api/v2/';
    private const DEFAULT_PAGE_LIMIT = 4;
    
    public function search(Request $request): JsonResponse {

        try {            

            $current_page = ($request->query('current_page')) ? $request->query('current_page') : 1;

            $pageLimit = ($request->query('limit')) ? $request->query('limit') : self::DEFAULT_PAGE_LIMIT;
            $search = $request->query('search');

            $validator = new WordsDataValidator();
            $validator->validateSearch($search);

            $words = Words::where('word', 'LIKE', $search."%")->get();
            $qtd = count($words);      
            
            $items = collect($words)->forPage($current_page, $pageLimit);     
            
            $results = [];
            $total_pages = round($qtd / $pageLimit);
            
            foreach($items as $item) {
                $results[] = $item->word;
            }      

            $response = array(
                'results' => $results,
                'totaldocs' => $qtd,
                'page' => $current_page,
                'totalPages' => $total_pages,
                'hasNext' => ($current_page < $total_pages),
                'hasPrev' => ($current_page > 1)
            );

            return $this->buildSuccessResponse($response);
            
        } catch(Exception $e) {
            return $this->buildBadRequestResponse($e->getMessage());
        }
        
    }

    public function wordInfo(Request $request, string $search): JsonResponse {

        try{

            $client = new Client(['base_uri' => self::WORDS_API_BASE_URI]);

            $validator = new WordsDataValidator();

            $validator->validateSearch($search);

            $response = json_decode($client->request('GET', 'entries/en/'.$search)->getBody());                  

            $userHistory = UserHistory::create([
                'user_id' => ($request->all('user_id')['user_id']),
                'word' => $search,
                'added' => date('Y-m-d h:i:s')
            ]);

            $userHistory->save();

            return $this->buildSuccessResponse($response);

        } catch(Exception $e) {
            return $this->buildBadRequestResponse($e->getMessage());
        }

    }

    public function favoriteWord(Request $request, string $word): JsonResponse {

        try {                    
            
            $user_id = $request->all('user_id')['user_id'];

            $userFavorite = UserFavorite::create([
                'user_id' => $user_id,
                'word' => $word,
                'added' => date('Y-m-d h:i:s')
            ]);

            $userFavorite->save();

            return $this->buildSuccessResponse(['user_id' => $user_id, 'word' => $word]);

        } catch(Exception $e) {
            return $this->buildBadRequestResponse($e->getMessage());
        }

    }

    public function unfavoriteWord(Request $request, string $word): JsonResponse {

        try {                    
            
            $user_id = $request->all('user_id')['user_id'];

            $validator = new WordsDataValidator();
            $validator->checkIfExistFavorite($user_id, $word);

            $userFavorite = UserFavorite::where('user_id', $user_id)->where('word', $word)->delete();

            $userFavorite->save();

            return $this->buildSuccessResponse(['user_id' => $user_id, 'word' => $word]);

        } catch(Exception $e) {
            return $this->buildBadRequestResponse($e->getMessage());
        }

    }

}
