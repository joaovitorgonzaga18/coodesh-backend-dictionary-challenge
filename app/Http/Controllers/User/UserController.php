<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserFavorite;
use App\Models\UserHistory;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller {

    private const DEFAULT_PAGE_LIMIT = 4;
    
    public function profile(Request $request): JsonResponse {

        try{

            $response = [];

            $user_id = $request->all('user_id')['user_id'];

            $user = User::where('uuid', $user_id)->first();
            
            $response = [
                'id' => $user->uuid,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ];

            return $this->buildSuccessResponse($response);

        } catch(Exception $e) {
            return $this->buildBadRequestResponse($e->getMessage());
        }

    }

    public function history(Request $request): JsonResponse {

        try{

            $response = [];
            
            $user_id = $request->all('user_id')['user_id'];

            $current_page = $request->query('current_page');

            $pageLimit = self::DEFAULT_PAGE_LIMIT;

            $words = UserHistory::where('user_id', $user_id)->orderByDesc('added')->get();   
            $qtd = count($words);               
            
            $collection = collect($words);
            $items = $collection->forPage($current_page, $pageLimit);
            
            $results = [];
            $total_pages = round($qtd / $pageLimit);
            
            foreach($items as $item) {
                $results[] = [
                    'word' => $item->word,
                    'added' => $item->added
                ];
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

    public function favorites(Request $request): JsonResponse {

        try{

            $response = [];
            
            $user_id = $request->all('user_id')['user_id'];

            $current_page = $request->query('current_page');

            $pageLimit = self::DEFAULT_PAGE_LIMIT;

            $words = UserFavorite::where('user_id', $user_id)->orderByDesc('added')->get();   
            $qtd = count($words);               
            
            $collection = collect($words);
            $items = $collection->forPage($current_page, $pageLimit);
            
            $results = [];
            $total_pages = round($qtd / $pageLimit);
            
            foreach($items as $item) {
                $results[] = [
                    'word' => $item->word,
                    'added' => $item->added
                ];
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

}
