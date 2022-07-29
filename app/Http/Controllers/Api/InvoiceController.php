<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\User;
use Validator;
use Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class InvoiceController extends Controller
{
    public function postCreate(Request $request)
    {
        $input = $request->all();

        if(isset($input['id']))
        {
            $invoice = Invoice::find($input['id']);
        }
        else
        {
            $invoice = new Invoice;
        }

        $validator = Validator::make($input,$invoice->rules());

        if($validator->fails())
        {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $invoice->user_id = Auth::user()->id;
        $invoice->title = $request->title;
        $invoice->description =  $request->description;
        $invoice->total_amount = $request->total_amount;
        if($request->photo != NULL)
        {
            $photo = time().'jpg';
            file_put_contents('storage/invoices/',$photo, base64_decode($request->photo));
            $invoice->photo = $photo;
        }
        $invoice->save();

        return response()->json([
            'sucess' => true,
            'message' => 'Invoice is saved successfully'
        ]); 

        // if(isset($input['id']))
        // {
        //     if(isset($input['photo']))
        //     {
        //         $invoice->photo = $this->handleFile($request, 'photo');
        //     }
        // }
        // else
        // {
        //     $invoice->photo = $this->handleFile($request, 'photo');   
        // }
        
        
         
    }
}
