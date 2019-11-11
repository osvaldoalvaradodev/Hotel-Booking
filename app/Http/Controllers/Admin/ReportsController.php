<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Clients;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Booking;

class ReportsController extends Controller
{
    public function index(Request $request){

        //si existe un request este realizarala la operacion
        $input = $request->all();

           $clients = Clients::get()->pluck('name','id');
        if(isset($input['from'])){

            $from = Carbon::parse($request->input('from'))->startOfDay();
            $to = Carbon::parse($request->input('to'))->endOfDay();
            $client_id = $input['client_id'];

            //obtiene los datos de la BD
            $bookings = DB::table('bookings')
                ->select(DB::raw('bookings.*,
                                    customers.first_name as first_name,
                                    customers.last_name as last_name,
                                    rooms.room_number as room_numer
                                    '))
                ->leftJoin('customers','bookings.customer_id','=','customers.id')
                ->leftJoin('rooms','bookings.room_id','=','rooms.id')
                ->where('bookings.deleted_at','=',null)
                ->where('bookings.client_id','=',$input['client_id'])
                ->whereBetween('bookings.time_from', [$from, $to])
                ->get();

            $total_amount = 0;
            $quantity_of_bookings = 0;
            foreach ($bookings as $booking) {
                $total_amount = $booking->amount + $total_amount;
                $quantity_of_bookings = $quantity_of_bookings + 1;
            }


            //retorna la vista
            //return view('reports.desinfectionsByDate',compact('from','to','desinfecciones','total_general','total_desinsectaciones','total_desratizaciones','total_desinfecciones'));

            return view('admin.reports.clientsales',compact('clients','total_amount','quantity_of_bookings','bookings','from','to'));

            /*
         $users = User::select(\DB::raw('users.*, SUM(analytics.revenue) as revenue'))
         ->leftJoin('analytics', 'analytics.user_id', '=', 'users.id')
         ->groupBy('users.id')
         ->get();
             * */
        }else{

            return view('admin.reports.clientsales',compact('clients'));
        }


    }
}
