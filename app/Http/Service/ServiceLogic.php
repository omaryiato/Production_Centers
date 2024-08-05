<?php

namespace App\Http\Service;


use App\Http\Repository\MainOracleRepo;
use Illuminate\Http\Request;


// ServiceLogic Class Contain All function thats do the logic for all requsets
class ServiceLogic
{
    protected $mainOracleRepo;

    public function __construct(MainOracleRepo $mainOracleRepo)
    {
        $this->mainOracleRepo = $mainOracleRepo;
    }

    // Index Funtion To Check The Hashkey
    public function checkUserValidation($hashkey)
    {
        return $this->mainOracleRepo->checkUserValidation($hashkey);
    }

    // getOrderList Funtion To Get Orders list from DB
    public function getOrderList($order_ID)
    {
        return $this->mainOracleRepo->getOrderList($order_ID);
    }

    // getOrderDetailsList Funtion To Get Order Details List from DB
    public function getOrderDetailsList($order_ID)
    {
        return $this->mainOracleRepo->getOrderDetailsList($order_ID);
    }

    // getOpmList Funtion To Get OPM list from DB
    public function getOpmList()
    {
        return $this->mainOracleRepo->getOpmList();
    }

    // getOrderHistoryList Funtion To Get Order History list from DB
    public function getOrderHistoryList($order_ID)
    {
        return $this->mainOracleRepo->getOrderHistoryList($order_ID);
    }

    // getOrderDetailsHistoryList Funtion To Get Order Details History list from DB
    public function getOrderDetailsHistoryList($order_ID)
    {
        return $this->mainOracleRepo->getOrderDetailsHistoryList($order_ID);
    }

    // assignOreder Funtion To Assign Order To The Factory (Update The Status)
    public function assignOreder($request)
    {
        return $this->mainOracleRepo->assignOreder($request);
    }

    // addNewOrder Funtion To Add New Order In Table Order
    public function addNewOrder($request)
    {
        return $this->mainOracleRepo->addNewOrder($request);
    }

    // getFactory Funtion To Get All Factory In DB
    public function getFactoryList()
    {
        return $this->mainOracleRepo->getFactoryList();
    }

    // editOrder Funtion To Edit Order Info 
    public function editOrderInfo($request)
    {
        return $this->mainOracleRepo->editOrderInfo($request);
    }

    // updateOrder Funtion To Update Order Status
    public function updateOrderInfo($request)
    {
        return $this->mainOracleRepo->updateOrderInfo($request);
    }

    // confirmOrder Funtion To Confirm Order From Project
    public function confirmOrder($request)
    {
        // $p_section_id         = $request->p_section_id;
        return $this->mainOracleRepo->confirmOrder($request);
    }
}
