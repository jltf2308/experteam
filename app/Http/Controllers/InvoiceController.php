<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Requests\InvoiceRequest;

class InvoiceController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::getListInvoice();
        $guides = Guide::getAllGuides();
        $dataInvoiceCard = [];
        $dataInvoiceList = [];
        $dataInvoice = [
            'cardData' => [],
            'listData' => [],
        ];
        foreach ($invoices as $key => $invoice) {
            $array1 = [
                "id" => $invoice->id,
                "title" => $invoice->secuencial,
                "status" => $invoice->status,
                "guides" => $invoice->guides,
                "body" => [
                    "Establecimiento" => $invoice->establishment,
                    "Punto de emision" => $invoice->emission_point,
                    "fecha de emision" => $invoice->date_issue,
                    "Total" => $invoice->total,
                ],
                
            ];
            array_push($dataInvoiceCard, $array1);

            $array2 =[
                'id' => $invoice->id,
                "guides" => $invoice->guides,
                'body' => [
                    "secuencial" => $invoice->secuencial,
                    "Nº de guia" => $invoice->secuencial,
                    "Establecimiento" => $invoice->establishment,
                    "Punto de emision" => $invoice->emission_point,
                    "fecha de emision" => $invoice->date_issue,
                    "Total" => $invoice->total,
                ],
            ];
            array_push($dataInvoiceList, $array2);
        }
        $dataInvoice['cardData'] = $dataInvoiceCard;
        $dataInvoice['listData'] = $dataInvoiceList;


        $dataGuidesList = [];
        foreach ($guides as $key => $guide) {
            $array2 =[
                'body' => [
                    '' => $guide->id,
                    "Número de guia" => $guide->guide_number,
                    "Total" => $guide->total,
                ],
            ];
            array_push($dataGuidesList, $array2);
        }

        return [
            'pagination' =>  [
                'total'         =>  $invoices->total(),
                'current_page'  =>  $invoices->currentPage(),
                'per_page'      =>  $invoices->perPage(),
                'last_page'     =>  $invoices->lastPage(),
                'from'          =>  $invoices->firstItem(),
                'to'            =>  $invoices->lastPage(),
            ],
            'invoiceFormat' => $dataInvoice,
            'invoiceList' => $invoices,
            'guides' => $dataGuidesList,
            'checkGuides' => Guide::getGuidesWithInvoices()

        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $invoice = new Invoice;

        foreach ($invoice->getFillable() as $key => $value) {
            $invoice->$value = $request->$value;
        }
        $invoice->status=0;
        $invoice->save();

        $invoicesGuides = [];
        foreach ($request->guides as $key => $value) {
            array_push($invoicesGuides, $value['guide_id']);
        }

        $invoice->guides()->attach($invoicesGuides);



    
        return response()->json([
            'statusCode'=>200,
            'message' =>'Datos guardados correctamente',
            'id' => $invoice->id
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
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Guide  $guide
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        foreach ($invoice->getFillable() as $key => $value) {
            $invoice->$value = $request->$value;
        }
        $invoice->save();
        
        return response()->json([
            'statusCode'=>200,
            'message' =>'Datos guardados correctamente',
            'id' => $invoice->id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guide  $guide
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return response()->json([
            'statusCode'=>200,
            'message' =>'Datos eliminados correctamente',
            'id' => $invoice->id
        ]);
    }

    public function getGuidesWithoutInvoices()
    {
        $guides = Guide::getGuidesWithoutInvoices();
        
        $dataGuidesList = [];
        foreach ($guides as $key => $guide) {
            $array2 =[
                'id'=> $guide->id,
                'body' => [
                    '' => $guide->id,
                    "Número de guia" => $guide->guide_number,
                    "Total" => $guide->total,
                ],
            ];
            array_push($dataGuidesList, $array2);
        }

        return [
            'guides' => $dataGuidesList
        ];
    }

}
