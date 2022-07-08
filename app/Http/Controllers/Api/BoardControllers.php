<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\BoardCardRequest;
use App\Http\Requests\BoardColumnRequest;
use App\Http\Resources\BoardCardsResource;
use App\Http\Resources\BoardColumnResource;
use App\Models\BoardCard;
use App\Models\BoardColumn;
use Illuminate\Http\Request;

class BoardControllers extends Controller
{

    public function index()
    {
        return BoardColumnResource::collection(BoardColumn::with('cards')->get());
    }


    public function store(BoardColumnRequest $request)
    {
        $data = $request->validated();
        $item = BoardColumn::create($data);
        return new BoardColumnResource($item);
    }

    public function delete(Request $request)
    {

        $item = BoardColumn::findOrFail($request->id);
        $item->cards()->delete();
        $item->delete();

        return new BoardColumnResource($item);
    }


    public function storeCard(BoardCardRequest $request)
    {
        $data = $request->validated();
        if(!empty($request->id)){
            $item = BoardCard::find($request->id);
            $item->update($data);
        }else {
            $order = BoardCard::where('column_id', $data['column_id'])->max('order');
            $data['order'] = $order + 1;

            $item = BoardCard::create($data);
        }
        return new BoardCardsResource($item);
    }


    public function cards_orders(Request $request)
    {
       if(!empty($request->cardTo)){
           if($request->cardTo['column_id'] != $request->card['column_id']){
               BoardCard::where('id', $request->card['id'])->update([
                   'column_id' => $request->cardTo['column_id']
               ]);
           }
       }
    }

}
