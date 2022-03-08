<?php

namespace App\Http\Controllers\Api\Events;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Events\Event;
use App\Models\Events\ETicket;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Events\EventList as ListResource;
use Carbon\Carbon;
use App\Models\Sales\SalesEvent;
use App\Models\Sales\Sale;
use App\Http\Resources\Events\EventItem;


class EventController extends Controller
{
     public function index(Request $request)
    {
        $events = Event::orderBy('date_end','desc')
                    ->where('date_end','>',Carbon::now())
                    ->get();

        return new ListResource($events);
    }
    public function detail(Request $request,$id)
    {
        $events = Event::where('id',$id)->first();
        return new EventItem($events);
    }

    public function voucher(Request $request)
    {
        $data = 
                SalesEvent::select('sales_event.*')
                    ->leftJoin('sales', function($join) {
                    $join->on('sales.id', '=', 'sales_event.sale_id');
                })
                ->where('sales.payment_status','paid')
                ->where('sales_event.member_id',auth()->user()->id)
                ->where('sales_event.status',1)
                ->where('remainder','>',0)
                ->get();
        $output = array();
        foreach ($data as $row) {
            $output[] = array(
                "id" => $row->id,
                "sale_id" => $row->sale_id,
                "event_id" => $row->event_id,
                "remainder" => $row->remainder,
                "status" => $row->status,
                "created_at" => $row->created_at,
                "event" => new EventItem(Event::where('id',$row->event_id)->first())
            );
        }
        return response()->json([
            'success'=>true,
            'data'=>$output,
        ], 200);

    }

    public function ticket(Request $request)
    {
        $data = ETicket::where('phone',auth()->user()->phone)->get();
        $output = array();
        foreach ($data as $row) {
            $output[] = array(
                "id" => $row->id,
                "sales_event_id" => $row->sales_event_id,
                "event_id" => $row->event_id,
                "participant_name" => $row->participant_name,
                "phone" => $row->phone,
                "event" => new EventItem(Event::where('id',$row->event_id)->first())
            );
        }
        return response()->json([
            'success'=>true,
            'data'=>$output,
        ], 200);

    }
    public function generate_ticket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sales_id' => 'required',
            'sales_event_id'      => 'required',
            'event_id'   => 'required',
            'participant_name' => 'required',
            'phone' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
        ETicket::updateOrInsert([
            'sales_event_id' =>  $request->sales_event_id,
            'event_id' => $request->event_id,
            'phone' => $request->phone
        ],
            $request->all()
        );
        $tot_generate = ETicket::where("sales_event_id",$request->sales_event_id)->get()->count();
        $eventSales = SalesEvent::where('id',$request->sales_event_id)->first();
        $totalQty = $eventSales->qty;
        $remainder = $totalQty - $tot_generate;
        SalesEvent::find($request->sales_event_id)->update(['remainder'=>$remainder]);
        Sale::find($request->sales_id)->update(['status'=>4]);
        $message = "E-Ticket \nTicket anda sudah release,\n\nSilahkan buka aplikasi office-coffee anda ";
        nascondimiSendMessage($request->phone,$message);
        return response()->json([
            'success'=>true,
            'message'=>'Ticket di generate',
        ], 200);

    }
}
