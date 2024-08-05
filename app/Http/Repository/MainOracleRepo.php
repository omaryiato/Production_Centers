<?php

namespace App\Http\Repository;

use Illuminate\Support\Facades\DB;


// MainOracleRepo Class Contain All function thats deal with DB
class MainOracleRepo
{

    // Index Funtion To Check The Hashkey
    public function checkUserValidation($hashkey)
    {
        return DB::select("SELECT xxajmi_sshr_ticketing.xxajmi_user_valid('$hashkey') AS User_Validate FROM dual");
    }

    // getOrderList Funtion To Get Orders list from DB
    public function getOrderList($order_ID)
    {
        //
    }

    // getOrderDetailsList Funtion To Get Order Details list from DB
    public function getOrderDetailsList($order_ID)
    {
        //
    }

    // getOpmList Funtion To Get OPM list from DB
    public function getOpmList()
    {
        //
    }

    // getOrderHistoryList Funtion To Get Order History list from DB
    public function getOrderHistoryList($order_ID)
    {
        //
    }

    // getOrderDetailsHistoryList Funtion To Get Order Details History list from DB
    public function getOrderDetailsHistoryList($order_ID)
    {
        //
    }

    // assignOreder Funtion To Update Order Requset (Assign the order)
    public function assignOreder($request)
    {
        //
    }

    // addNewOrder Funtion To Add New Order In Table Order
    public function addNewOrder($request)
    {
        //
    }

    // getFactory Funtion To Fetch Factory List From DB
    public function getFactoryList()
    {
        //
    }

    // editOrder Funtion To Edit Order Info 
    public function editOrderInfo($request)
    {
        //
    }

    // updateOrder Funtion To Update Order Status
    public function updateOrderInfo($request)
    {
        //
    }

    // confirmOrder Funtion To Confirm Order From Project 
    public function confirmOrder($request)
    {
        //
    }
}
