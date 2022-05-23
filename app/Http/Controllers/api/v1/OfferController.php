<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Offer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Offer\OfferResource;
use App\Http\Requests\offer\OfferStoreRequest;
use App\Http\Resources\Offer\OfferIndexCollection;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new OfferIndexCollection(Offer::get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OfferStoreRequest $request)
    {
        $last_offer = Offer::orderBy('id', 'DESC')->first();
        $newId = $last_offer->id + 1;

        //return response()->json($request);

        $data = $request->merge(['id' => $newId])->validated();
        $data['id'] = $newId;
        offer::create($data);
        $newOffer = Offer::find($newId);
        //$newOffer->id = $newId;

        if (isset($request->pictures)) {
            if (is_array($request->pictures)) {
                foreach ($request->pictures as $picture) {
                    $newOffer->insertPicture($picture);
                }
            }
        }

        if (isset($request->params)) {
            if (is_array($request->params)) {
                foreach ($request->params as $param) {
                    if (isset($param['name']) && isset($param['value'])) {
                        $newOffer->insertParam($newId, $param['name'], $param['value']);                       
                    }
                }
            }
        }
        return new OfferResource($newOffer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new OfferResource(Offer::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OfferStoreRequest $request, $id)
    {
        $offer = Offer::findOrFail($id);
        $offer->update($request->validated());
        return new OfferResource($offer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
