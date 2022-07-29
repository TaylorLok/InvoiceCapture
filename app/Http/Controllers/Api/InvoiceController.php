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
    }

    public function update(Request $request)
    {
        $invoice = Invoice::find($request->id);

        //check the user editing his own invoice
        if(Auth::user()->id != $request->id)
        {
            return response()->json([
                'sucess' => false,
                'message' => 'Unauthorized access'
            ]);
        }
        $invoice->title = $request->title;
        $invoice->description =  $request->description;
        $invoice->total_amount = $request->total_amount;
        if($request->photo != NULL)
        {
            storage::update('public/invoices/'.$invoice->photo);
        }
        $invoice->update();
        return response()->json([
            'sucess' => true,
            'message' => 'Invoice edited successfully!'
        ]);
        
    }

    public function delete(Request $request)
    {
        $invoice = Invoice::find($request->id);

        //check the user editing his own invoice
        if(Auth::user()->id != $request->id)
        {
            return response()->json([
                'sucess' => false,
                'message' => 'Unauthorized access'
            ]);
        }
        else
        {
            $invoice->title = $request->title;
            $invoice->description =  $request->description;
            $invoice->total_amount = $request->total_amount;
            if($request->photo != NULL)
            {
                storage::delete('public/invoices/'.$invoice->photo);
            }
            $invoice->delete();
            return response()->json([
                'sucess' => true,
                'message' => 'Invoice deleted successfully!'
            ]);
        }
    }

    public function display_invoice()
    {
        $invoices = Invoice::where('user_id', Auth::id())
                            ->orderBy('id','DESC')
                            ->get();
        return response()->json([
            'sucess' => true,
            'invoices' => $invoices
        ]);
    }
}
