<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Resources\CustomerResource;
use Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cust = Customer::all();

        // Ambil fungsi dari app/Http/Controllers/Controller
        return $this->successResponse(CustomerResource::collection($cust), 'Berhasil Ambil Data');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'nama' => 'required',
            'email' => 'required'
        ]);

        if($validator->fails()){
            // Ambil fungsi dari app/Http/Controllers/Controller
            return $this->errorResponse('Validation Error', $validator->errors());
        }

        $kirim = Customer::create($input);

        // Ambil fungsi dari app/Http/Controllers/Controller
        return $this->successResponse(new CustomerResource($kirim), 'Berhasil Simpan Data');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cust = Customer::find($id);
        
        if(is_null($cust)){
            // Ambil fungsi dari app/Http/Controllers/Controller
            return $this->errorResponse( "Customer tidak ada.");
        }

        // Ambil fungsi dari app/Http/Controllers/Controller
        return $this->successResponse(new CustomerResource($cust), 'Berhasil Ambil Data');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'nama' => 'required',
            'email' => 'required'
        ]);

        if($validator->fails()){
            // Ambil fungsi dari app/Http/Controllers/Controller
            return $this->errorResponse('Validation Error', $validator->errors());
        }

        $customer->nama = $input['nama'];
        $customer->email = $input['email'];
        $customer->save();

        // Ambil fungsi dari app/Http/Controllers/Controller
        return $this->successResponse(new CustomerResource($customer), 'Berhasil Simpan Data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        // Ambil fungsi dari app/Http/Controllers/Controller
        return $this->successResponse([], 'Berhasil Hapus Data');
    }
}
