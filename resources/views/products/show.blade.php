@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-6 h3">
                    Produkt
                </div>
                <div class="col-lg-6">
                    <span class="text-right">
                    @include('partials._productsform')
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body">
        <div class="row">
            <div class="col-lg-6">
                <div class="card-body">
                    <b-card title="Produktinfo, uppdaterad {{ formatPriceDate($product) }}">
                        <table class="table table-borderless">
                            <tr>
                                <td>Produkt:</td>
                                <td><strong>{{ $product->item }}</strong></td>
                            </tr>
                            <tr>
                                <td>Benämning:</td>
                                <td>
                                    {{ $product->item_description_swe }}
                                    @if (substr($product->item_description_swe,0,1) == '#') 
                                        <i class="text-danger">(# = Utgått)</i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>E-nummer:</td><td> {{ is_null($product->enummer)?'-':$product->enummer }}</td>
                            </tr>
                            <tr>
                                <td>Listpris :</td>
                                <td> 
                                    {{ formatPrice($product->listprice) }} 
                                   
                                </td>
                            </tr>
                            <tr>
                                <td>Produktgrupp:</td><td>{{ $product->group }}/{{ $product->family }}/{{ $product->subfamily }}</td>
                            </tr>
                        </table>
                    </b-card>
                </div>
                @showmodule('enable_product_replacements')
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
                @endshowmodule
            </div>

            <div class="col-lg-6">
                @showmodule('enable_demoprodukter')
                <div class="card-body">
                    <b-card title="Demoprodukter">
                        @if (count($product->demoproduct)==0)
                        Inga demoprodukter registerade
                        @else
                        <table class="table">
                            @foreach ($product->demoproduct as $item)
                            <tr>
                                <td>{{ $item->location->path() }}</td>
                                <td>{{ $item->status->description }}</td>
                                <td>{{ $item->comment }}</td>
                            </tr>
                            
                            @endforeach   
                        </table>
                        <b-button href="/demoproducts?filter={{ $product->item }}">Detaljer</b-button>
                        @endif
                    </b-card>
                </div>
                @endshowmodule
            </div>
        </div>
        </div>

    </div>
@endsection