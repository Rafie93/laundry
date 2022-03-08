@extends('app.app')
@section('content')
  <div class="container-fluid">
    <div class="row">

        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li class="active">Pengaturan Tarif Kurir</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <form method="POST" action="{{Route('courier.store')}}">
                {{ csrf_field() }}
            <div class="card flex-fill">
                <div >
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Status</td>
                                <td>Name</td>
                                <td>Distance (Km)</td>
                                <td>Rate</td>
                                <td>Rate Min Distance (Km)</td>
                                <td>Min Rate</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($couriers->count() > 0)
                                @foreach ($couriers as $item)
                                    <tr>
                                        {!! Form::hidden('id[]', $item->id) !!}
                                        <td>{!! Form::select('status[]', ['1' => 'Aktif', '0' => 'Tidak Aktif'], $item->status,['class'=>'form-control']) !!}</td>
                                        <td>{!! Form::text('name[]', $item->name, ['class'=>'form-control', 'readonly']) !!}</td>
                                        <td>{!! Form::number('distance[]', $item->distance, ['class'=>'form-control']) !!} </td> 
                                        <td>{!! Form::number('rate[]', $item->rate, ['class'=>'form-control']) !!} </td> 
                                        <td>{!! Form::number('min_distance[]', $item->min_distance, ['class'=>'form-control']) !!} </td> 
                                        <td>{!! Form::number('min_rate[]', $item->min_rate, ['class'=>'form-control']) !!} </td> 
                                        
                                    </tr>
                                @endforeach
                            @else 
                                <tr>
                                    <td>{!! Form::select('status[]', ['1' => 'Aktif', '0' => 'Tidak Aktif'], 0,['class'=>'form-control']) !!}</td>
                                    <td>{!! Form::text('name[]', 'COURIER INTERNAL', ['class'=>'form-control', 'readonly']) !!}</td>
                                    <td>{!! Form::number('distance[]', '1', ['class'=>'form-control']) !!} </td> 
                                    <td>{!! Form::number('rate[]', '2000', ['class'=>'form-control']) !!} </td> 
                                    <td>{!! Form::number('min_distance[]', '7', ['class'=>'form-control']) !!} </td> 
                                    <td>{!! Form::number('min_rate[]', '10000', ['class'=>'form-control']) !!} </td> 
                                    
                                </tr>
                                 <tr>
                                    <td>{!! Form::select('status[]', ['1' => 'Aktif', '0' => 'Tidak Aktif'], 0,['class'=>'form-control']) !!}</td>
                                    <td>{!! Form::text('name[]', 'COURIER LOCAL', ['class'=>'form-control', 'readonly']) !!}</td>
                                    <td>{!! Form::number('distance[]', '1', ['class'=>'form-control']) !!} </td> 
                                    <td>{!! Form::number('rate[]', '2000', ['class'=>'form-control']) !!} </td> 
                                    <td>{!! Form::number('min_distance[]', '7', ['class'=>'form-control']) !!} </td> 
                                    <td>{!! Form::number('min_rate[]', '10000', ['class'=>'form-control']) !!} </td> 
                                    
                                </tr>
                          
                            @endif
                            <tr>
                                <br/>
                                <td colspan="4"><button type="submit" class="btn btn-lg btn-info mg">UPDATE</button></td>
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