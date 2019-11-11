@extends('layouts.app')

@section('content')
<style>


    @page {
        size: auto;  /* auto is the initial value */
        margin: 0mm; /* this affects the margin in the printer settings */
    }
    @media print {
        #printPageButton {
            display: none;
        }
    }
</style>


    <div class="box">


        <div  id="printPageButton"  class="box-body">
            <h2 class="page-header">
                <i class="fa fa-pie-chart"></i> Informes por Fecha
            </h2>
            <form method="get">
                {{csrf_field()}}


                <div class="col-xs-6">
                    <label for="exampleInputEmail1">Desde:</label>
                    <input required type="date" class="form-control" name="from" placeholder="" value="{{isset($from) ? date('Y-m-d', strtotime($from)) : '' }}">
                </div>
                <div class="col-xs-6">
                    <label for="exampleInputEmail1">Hasta:</label>
                    <input required type="date" class="form-control" name="to" placeholder="" value="{{isset($to) ? date('Y-m-d', strtotime($to)) : '' }}">
                </div>



                    <div class="col-xs-12 form-group">
                        {!! Form::label('client_id', trans('quickadmin.bookings.fields.client').' *', ['class' => 'control-label']) !!}
                        {!! Form::select('client_id', $clients, old('client_id'), ['class' => 'form-control select2']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('client_id'))
                            <p class="help-block">
                                {{ $errors->first('client_id') }}
                            </p>
                        @endif
                    </div>


                <div class="col-xs-12">
                    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i>Filtrar</button>

                    <button class='btn btn-primary' id="printPageButton" onClick="window.print();"><i class="fa fa-print"></i> Imprimir</button>


                </div>

            </form>
        </div>
    </div>
    @if(isset($from))

        <div class="box">
            <div class="box-body">
                <h2 class="page-header">
                    <i class="fa fa-pie-chart"></i> Reporte de Reservas por Cliente desde <b>{{date('d-m-Y', strtotime($from))}}</b>
                    hasta <b>{{date('d-m-Y', strtotime($to))}}</b>
                </h2>

                <div class="row">

                    <div class="col-xs-6">
                        <p class="lead">Resumen:</p>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody><tr>
                                    <th style="width:50%">Total:</th>
                                    <td>{{$total_amount}}</td>
                                </tr>
                                <tr>
                                    <th>Cantidad Check-in</th>
                                    <td>{{$quantity_of_bookings}}</td>
                                </tr>
                                </tbody></table>
                        </div>
                    </div>
                </div>

                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th>Id Booking</th>
                        <th>Usuario</th>
                        <th>Desde:</th>
                        <th>Hasta</th>
                        <th>Habitacion</th>
                        <th>Monto</th>


                    </tr>

                    @foreach($bookings as $booking)
                        <tr>
                            <td>{{$booking->id}}</td>
                            <td>{{$booking->first_name}} {{$booking->last_name}}</td>
                            <td>{{date('Y-m-d H:i', strtotime($booking->time_from))}}</td>
                            <td>{{date('Y-m-d H:i', strtotime($booking->time_to))}}</td>
                            <th>{{$booking->room_numer}}</th>
                            <td>{{$booking->amount}}</td>
                        </tr>
                    @endforeach


                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>Total: </b></td>
                        <td><b style="color:red">{{$total_amount}}</b></td>
                    </tr>
                    </tbody>
                </table>


            </div>
        </div>
    @endif


@stop