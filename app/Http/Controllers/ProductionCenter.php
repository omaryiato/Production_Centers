<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Service\ServiceLogic;
use Illuminate\Support\Facades\DB;
use App\Helpers\ResponsHelper;
use setasign\Fpdi\Fpdi;
use App\Services\PdfService;

// use App\Helper\UploadDocumnetAcrchive;

class ProductionCenter extends Controller
{
    protected $serviceLogic;
    protected $pdfService;
    protected $uploadTemplet;

    public function __construct(ServiceLogic $serviceLogic, PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
        $this->serviceLogic = $serviceLogic;
        // $this->uploadTemplet = $uploadTemplet;
    }

    // Index Funtion To Check The The Hashkey
    public function index(Request $request)
    {
        try {
            $hashkey = $request->hash_key;

            $hashkey = $this->serviceLogic->checkUserValidation($hashkey);
            return ResponsHelper::success($hashkey);
        } catch (\Exception $e) {
            return ResponsHelper::error($e->getMessage());
        }
    }

    // orderList Funtion To Get Orders Requeset list from DB
    public function orderList(Request $request)
    {
        try {
            $order_ID = $request->orderID;
            // dd($order_ID);
            $order_list = $this->serviceLogic->getOrderList($order_ID);
            return ResponsHelper::success($order_list);
        } catch (\Exception $e) {
            return ResponsHelper::error($e->getMessage());
        }
    }

    // orderDetailsLisr Funtion To Get  Order Details List from DB
    public function orderDetailsLisr(Request $request)
    {
        try {
            $order_ID = $request->orderID;
            // dd($order_ID);
            $order_details_list = $this->serviceLogic->getOrderDetailsList($order_ID);
            return ResponsHelper::success($order_details_list);
        } catch (\Exception $e) {
            return ResponsHelper::error($e->getMessage());
        }
    }

    // opmList Funtion To Get OPM list from DB
    public function opmList()
    {
        try {
            $opm_list = $this->serviceLogic->getOpmList();
            return ResponsHelper::success($opm_list);
        } catch (\Exception $e) {
            return ResponsHelper::error($e->getMessage());
        }
    }

    // orderHistoryList Funtion To Get Order History list from DB
    public function orderHistoryList(Request $request)
    {
        try {
            $order_ID = $request->orderID;
            $order_history_list = $this->serviceLogic->getOrderHistoryList($order_ID);
            return ResponsHelper::success($order_history_list);
        } catch (\Exception $e) {
            return ResponsHelper::error($e->getMessage());
        }
    }

    // orderDetailsHistoryList Funtion To Get Order Details History list from DB
    public function orderDetailsHistoryList(Request $request)
    {
        try {
            $order_ID = $request->orderID;
            $order_details_history_list = $this->serviceLogic->getOrderDetailsHistoryList($order_ID);
            return ResponsHelper::success($order_details_history_list);
        } catch (\Exception $e) {
            return ResponsHelper::error($e->getMessage());
        }
    }

    // assignOreder Funtion To Assign The Order To The Factory
    public function assignOreder(Request $request)
    {
        try {
            $order_info = $this->serviceLogic->assignOreder($request);
            return ResponsHelper::success($order_info);
        } catch (\Exception $e) {
            return ResponsHelper::error($e->getMessage());
        }
    }

    // newOrder Funtion To Add New Order In Table Order
    public function newOrder(Request $request)
    {
        try {
            $order_Info = $this->serviceLogic->addNewOrder($request);
            return ResponsHelper::success($order_Info);
        } catch (\Exception $e) {
            return ResponsHelper::error($e->getMessage());
        }
    }

    // getFactory Funtion To Fetch All Factory In DB
    public function getFactory()
    {
        try {
            $factory_Info = $this->serviceLogic->getFactory();
            return ResponsHelper::success($factory_Info);
        } catch (\Exception $e) {
            return ResponsHelper::error($e->getMessage());
        }
    }

    // editOrder Funtion To Edit Order Info 
    public function editOrder(Request $request)
    {
        try {
            $order_Info = $this->serviceLogic->editOrder($request);
            return ResponsHelper::success($order_Info);
        } catch (\Exception $e) {
            return ResponsHelper::error($e->getMessage());
        }
    }

    // updateOrder Funtion To Update Order Status
    public function updateOrder(Request $request)
    {
        try {
            $order_Info = $this->serviceLogic->updateOrder($request);
            return ResponsHelper::success($order_Info);
        } catch (\Exception $e) {
            return ResponsHelper::error($e->getMessage());
        }
    }

    // confirmOrder Funtion To Confirm Order From Project Last Stage
    public function confirmOrder(Request $request)
    {
        try {
            $order_id = $this->serviceLogic->confirmOrder($request);
            return ResponsHelper::success($order_id);
        } catch (\Exception $e) {
            return ResponsHelper::error($e->getMessage());
        }
    }
}
