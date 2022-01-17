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
                <div class="card-body">
                    <b-card title="Ersättningsprodukter">
                        @if (count($product->replacements)==0)
                        Inga ersättningsprodukter registerade
                    @else
                        <table class="table">
                            @foreach ($product->replacements as $item)
                               <tr>
                                <td><a href="{{ url('products', $item->id) }}">{{ $item->item }}</a></td>   
                                <td>{{ $item->item_description_swe }}</td>
                                <td>{{ $item->pivot->comment }}</td>

                                </tr> 
                            @endforeach
                        </table>
                        
                    @endif
                    </b-card>
    
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-body">
                    <b-card title="Demolager för {{ $product->item }} ">
                        @if (count($product->demoproduct)==0)
                        Inga produkter registerade på något Demolager
                        @else
                        <table class="table">
                            @foreach ($product->demoproduct as $item)
                            <tr>
                                <td>{{ $item->status->description }}</td>
                                <td>{{ $item->location->path() }}</td>
                                <td>{{ $item->comment }}</td>
                            </tr>
                            
                            @endforeach   
                        </table>
                        <b-button href="/demoproducts?filter={{ $product->item }}">Detaljer</b-button>
                        @endif
                    </b-card>
                </div>
            </div>
        </div>

    </div>
@endsection