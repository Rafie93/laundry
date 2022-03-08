@extends('app.app')
@section('content')
  <div class="container-fluid">
    <div class="row">

        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li class="active">Payment Method</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <form method="POST" action="{{Route('paymentmethod.store')}}">
                {{ csrf_field() }}
            <div class="card flex-fill">
                <div >
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Status</td>
                                <td>Dibebankan</td>
                                <td>Method</td>
                                <td>Fee</td>
                                <td>Fee Type</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($payments->count() > 0)
                                @foreach ($payments as $item)
                                    <tr>
                                        {!! Form::hidden('code[]', $item->code) !!}
                                        <td>{!! Form::select('status[]', ['1' => 'Aktif', '0' => 'Tidak Aktif'], $item->status,['class'=>'form-control']) !!}</td>
                                        <td>{!! Form::select('charged[]', ['customer' => 'Customer', 'oc' => 'Office Coffe'], $item->charged, ['class'=>'form-control']) !!}</td>
                                        <td>{!! Form::text('name[]', $item->name, ['class'=>'form-control', 'readonly']) !!}</td>
                                        <td>{!! Form::number('fee[]', $item->fee, ['class'=>'form-control','step' => '0.1']) !!} </td> 
                                        <td>{!! Form::select('type[]', ['percentage' => 'Percentage', 'nominal' => 'Nominal'], $item->type, ['class'=>'form-control']) !!}</td>  
                                    </tr>
                                @endforeach
                            @else 
                                 <tr>
                                <td colspan="4">Bank Transfer</td>
                                <td></td>
                            </tr>
                          
                            <tr>
                                {!! Form::hidden('code[]', 'BCA') !!}
                                <td>{!! Form::select('status[]', ['1' => 'Aktif', '0' => 'Tidak Aktif'], '0',['class'=>'form-control']) !!}</td>
                                <td>{!! Form::select('charged[]', ['customer' => 'Customer', 'oc' => 'Office Coffe'], 'oc', ['class'=>'form-control']) !!}</td>
                                <td>{!! Form::text('name[]', 'BCA', ['class'=>'form-control','readonly']) !!}</td>
                                <td>{!! Form::number('fee[]', '4000', ['class'=>'form-control','step' => '0.1']) !!} </td> 
                                <td>{!! Form::select('type[]', ['percentage' => 'Percentage', 'nominal' => 'Nominal'], 'nominal', ['class'=>'form-control']) !!}</td>  
                            </tr>
                            <tr>
                                {!! Form::hidden('code[]', 'BRIVA') !!}
                                <td>{!! Form::select('status[]', ['1' => 'Aktif', '0' => 'Tidak Aktif'], '0',['class'=>'form-control']) !!} </td>
                                <td>{!! Form::select('charged[]', ['customer' => 'Customer', 'oc' => 'Office Coffe'], 'oc', ['class'=>'form-control']) !!}</td>
                                <td>{!! Form::text('name[]', 'BRIVA', ['class'=>'form-control','readonly']) !!} </td>
                                <td> {!! Form::number('fee[]', '4000', ['class'=>'form-control','step' => '0.1']) !!}</td>
                                <td>{!! Form::select('type[]', ['percentage' => 'Percentage', 'nominal' => 'Nominal'], 'nominal', ['class'=>'form-control']) !!}</td>  
                            </tr>
                             <tr>
                                {!! Form::hidden('code[]', 'BNI') !!}
                                <td>{!! Form::select('status[]', ['1' => 'Aktif', '0' => 'Tidak Aktif'], '0',['class'=>'form-control']) !!} </td>
                                <td>{!! Form::select('charged[]', ['customer' => 'Customer', 'oc' => 'Office Coffe'], 'oc', ['class'=>'form-control']) !!}</td>
                                <td>{!! Form::text('name[]', 'BNI', ['class'=>'form-control','readonly']) !!} </td>
                                <td> {!! Form::number('fee[]', '4000', ['class'=>'form-control','step' => '0.1']) !!}</td>
                                <td>{!! Form::select('type[]', ['percentage' => 'Percentage', 'nominal' => 'Nominal'], 'nominal', ['class'=>'form-control']) !!}</td>  
                            </tr>
                             <tr>
                                {!! Form::hidden('code[]', 'MANDIRI') !!}
                                <td>{!! Form::select('status[]', ['1' => 'Aktif', '0' => 'Tidak Aktif'], '0',['class'=>'form-control']) !!} </td>
                                <td>{!! Form::select('charged[]', ['customer' => 'Customer', 'oc' => 'Office Coffe'], 'oc', ['class'=>'form-control']) !!}</td>
                                <td>{!! Form::text('name[]', 'MANDIRI', ['class'=>'form-control','readonly']) !!} </td>
                                <td> {!! Form::number('fee[]', '4000', ['class'=>'form-control','step' => '0.1']) !!}</td>
                                <td>{!! Form::select('type[]', ['percentage' => 'Percentage', 'nominal' => 'Nominal'], 'nominal', ['class'=>'form-control']) !!}</td>  
                            </tr>
                             <tr>
                                {!! Form::hidden('code[]', 'PERMATA') !!}
                                <td>{!! Form::select('status[]', ['1' => 'Aktif', '0' => 'Tidak Aktif'], '0',['class'=>'form-control']) !!} </td>
                                <td>{!! Form::select('charged[]', ['customer' => 'Customer', 'oc' => 'Office Coffe'], 'oc', ['class'=>'form-control']) !!}</td>
                                <td>{!! Form::text('name[]', 'Permata BANK', ['class'=>'form-control','readonly']) !!} </td>
                                <td> {!! Form::number('fee[]', '4000', ['class'=>'form-control','step' => '0.1']) !!}</td>
                                <td>{!! Form::select('type[]', ['percentage' => 'Percentage', 'nominal' => 'Nominal'], 'nominal', ['class'=>'form-control']) !!}</td>  
                            </tr>
                             <tr>
                                <td colspan="4">E-Wallet</td>
                                <td></td>
                            </tr>
                            <tr>
                                {!! Form::hidden('code[]', 'GoPay') !!}
                                <td>{!! Form::select('status[]', ['1' => 'Aktif', '0' => 'Tidak Aktif'], '0',['class'=>'form-control']) !!} </td>
                                <td>{!! Form::select('charged[]', ['customer' => 'Customer', 'oc' => 'Office Coffe'], 'oc', ['class'=>'form-control']) !!}</td>
                                <td>{!! Form::text('name[]', 'GoPay', ['class'=>'form-control','readonly']) !!} </td>
                                <td> {!! Form::number('fee[]', '2', ['class'=>'form-control','step' => '0.1']) !!}</td>
                                <td>{!! Form::select('type[]', ['percentage' => 'Percentage', 'nominal' => 'Nominal'], 'percentage', ['class'=>'form-control']) !!}</td>  
                            </tr>
                            <tr>
                                {!! Form::hidden('code[]', 'ShopeePay') !!}
                                <td>{!! Form::select('status[]', ['1' => 'Aktif', '0' => 'Tidak Aktif'], '0',['class'=>'form-control']) !!} </td>
                                <td>{!! Form::select('charged[]', ['customer' => 'Customer', 'oc' => 'Office Coffe'], 'oc', ['class'=>'form-control']) !!}</td>
                                <td>{!! Form::text('name[]', 'ShopeePay', ['class'=>'form-control','readonly']) !!} </td>
                                <td> {!! Form::number('fee[]', '0.7', ['class'=>'form-control','step' => '0.1']) !!}</td>
                                <td>{!! Form::select('type[]', ['percentage' => 'Percentage', 'nominal' => 'Nominal'], 'percentage', ['class'=>'form-control']) !!}</td>
                            </tr>
                             <tr>
                                {!! Form::hidden('code[]', 'QRIS') !!}
                                <td>{!! Form::select('status[]', ['1' => 'Aktif', '0' => 'Tidak Aktif'], '0',['class'=>'form-control']) !!} </td>
                                <td>{!! Form::select('charged[]', ['customer' => 'Customer', 'oc' => 'Office Coffe'], 'oc', ['class'=>'form-control']) !!}</td>
                                <td>{!! Form::text('name[]', 'QRIS', ['class'=>'form-control','readonly']) !!} </td>
                                <td> {!! Form::number('fee[]', '0', ['class'=>'form-control','step' => '0.1']) !!}</td>
                                <td>{!! Form::select('type[]', ['percentage' => 'Percentage', 'nominal' => 'Nominal'], 'percentage', ['class'=>'form-control']) !!}</td>
                            </tr>
                            <tr>
                                <td colspan="4">Credit Card</td>
                                <td></td>
                            </tr>
                              <tr>
                                {!! Form::hidden('code[]', 'Visa') !!}
                                <td>{!! Form::select('status[]', ['1' => 'Aktif', '0' => 'Tidak Aktif'], '0',['class'=>'form-control']) !!} </td>
                                <td>{!! Form::select('charged[]', ['customer' => 'Customer', 'oc' => 'Office Coffe'], 'oc', ['class'=>'form-control']) !!}</td>
                                <td>{!! Form::text('name[]', 'Visa', ['class'=>'form-control','readonly']) !!} </td>
                                <td> {!! Form::number('fee[]', '2.9', ['class'=>'form-control','step' => '0.1']) !!}</td>
                                <td>{!! Form::select('type[]', ['percentage' => 'Percentage', 'nominal' => 'Nominal'], 'percentage', ['class'=>'form-control']) !!}</td>
                            </tr>
                             <tr>
                                {!! Form::hidden('code[]', 'Mastercard') !!}
                                <td>{!! Form::select('status[]', ['1' => 'Aktif', '0' => 'Tidak Aktif'], '0',['class'=>'form-control']) !!} </td>
                                <td>{!! Form::select('charged[]', ['customer' => 'Customer', 'oc' => 'Office Coffe'], 'oc', ['class'=>'form-control']) !!}</td>
                                <td>{!! Form::text('name[]', 'Mastercard', ['class'=>'form-control','readonly']) !!} </td>
                                <td> {!! Form::number('fee[]', '0', ['class'=>'form-control','step' => '0.1']) !!}</td>
                                <td>{!! Form::select('type[]', ['percentage' => 'Percentage', 'nominal' => 'Nominal'], 'percentage', ['class'=>'form-control']) !!}</td>
                            </tr>
                            @endif
                            <tr>
                                <br/>
                                <td colspan="5"><button type="submit" class="btn btn-lg btn-info mg">UPDATE</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <br>
            </div>
            </form>
        </div>
       
    </div>

</div>  
@endsection