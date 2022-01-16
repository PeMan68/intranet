@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header h3">
            Produkter
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card-body">
                    <b-card title="{{ $product->item }}">
                        <table>
                            <tr>
                                <td>
                                    {{ $product->item_description_swe }}
                                    @if (substr($product->item_description_swe,0,1) == '#') 
                                        <i class="text-danger">(# = Utgått)</i>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </b-card>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-body">
                    <b-card title="Demolager">
                        @if (count($product->demoproduct)==0)
                            Inga produkter registerade på något Demolager
                        @else
                            {{$product->demoproduct[0]}}   
                        @endif
                    </b-card>
                </div>
            </div>
        </div>
    </div>
@endsection