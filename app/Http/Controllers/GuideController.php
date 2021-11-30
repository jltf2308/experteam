<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Requests\GuideRequest;

class GuideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guides = Guide::getListGuide();
        $dataGuideCard = [];
        $dataGuideList = [];
        $dataGuide = [
            'cardData' => [],
            'listData' => [],
        ];
        foreach ($guides as $key => $guide) {
            $array1 = [
                "id" => $guide->id,
                "title" => $guide->guide_number,
                "body" => [
                    "Fecha de envio" => $guide->shipping_date,
                    "Nombre remitente" => $guide->sender_name,
                    "País de origen" => $guide->country_origin,
                    "Nombre destinatario" => $guide->recipient_name,
                    "País de destino" => $guide->destination_country,
                    "Total" => $guide->total,
                ],
            ];
            array_push($dataGuideCard, $array1);

            $array2 =[
                'id' => $guide->id,
                'body' => [
                    "Nº de guia" => $guide->guide_number,
                    "Fecha de envio" => $guide->shipping_date,
                    "Total" => $guide->total,
                    "Nombre remitente" => $guide->sender_name,
                    "País de origen" => $guide->country_origin,
                    "Nombre destinatario" => $guide->country_origin,
                    "País de destino" => $guide->country_origin,
                ],
            ];
            array_push($dataGuideList, $array2);
        }
        $dataGuide['cardData'] = $dataGuideCard;
        $dataGuide['listData'] = $dataGuideList;

        return [
            'pagination' =>  [
                'total'         =>  $guides->total(),
                'current_page'  =>  $guides->currentPage(),
                'per_page'      =>  $guides->perPage(),
                'last_page'     =>  $guides->lastPage(),
                'from'          =>  $guides->firstItem(),
                'to'            =>  $guides->lastPage(),
            ],
            'guideFormat' => $dataGuide,
            'guideList' => $guides,

        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuideRequest $request)
    {
        $guide = new Guide;

        foreach ($guide->getFillable() as $key => $value) {
            $guide->$value = $request->$value;
        }
        $guide->save();
    
        return response()->json([
            'statusCode'=>200,
            'message' =>'Datos guardados correctamente',
            'id' => $guide->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Guide  $guide
     * @return \Illuminate\Http\Response
     */
    public function show(Guide $guide)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Guide  $guide
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Guide $guide)
    {
        foreach ($guide->getFillable() as $key => $value) {
            $guide->$value = $request->$value;
        }
        $guide->save();

        $invoice = Invoice::where('id', $guide->invoices[0]->id)->first();
        if($invoice){
            $totalfactura = $this->recalculateInvoice($guide->total);
            $invoice->subtotal = $totalfactura['subtotal'];
            $invoice->taxes = $totalfactura['taxes'];
            $invoice->total = $totalfactura['total'];
            $invoice->save();
        }
        
        
        return response()->json([
            'statusCode'=>200,
            'message' =>'Datos guardados correctamente',
            'id' => $guide->id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guide  $guide
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guide $guide)
    {
        $guide->delete();
        return response()->json([
            'statusCode'=>200,
            'message' =>'Datos eliminados correctamente',
            'id' => $guide->id
        ]);
    }

    public function recalculateInvoice($total)
    {
        $subtotal = $total;
        $taxes = $total * 0.12;
        $totalInvoice = $subtotal + $taxes;
        

        return $newtotal = [
            'subtotal' => $total,
            'taxes' => $taxes,
            'total' => $totalInvoice
        ];
    }
}
