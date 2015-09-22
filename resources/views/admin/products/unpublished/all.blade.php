@extends('admin.dashboard')

@section('header')
    Προβολή Αδημοσίευτων
@endsection

@section('content')
        @if($products)
                <table id="allUnpublished" class="display select" cellspacing="0" cellpadding="0" width="100%">
                    <thead>
                        <tr>
                            <th><input name="select_all" value="1" type="checkbox"> </th>
                            <th>Title</th>
                            <th>Barcode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{!! $product->id !!}</td>
                                <td><a href="{!! route('Admin::Unpublished::confirmUnpublished', [$product->barcode]) !!}"> {!! $product->title !!}</a></td>
                                <td>{!! $product->barcode !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        @else
            <p>Δεν υπάρχουν αδημοσίευτα</p>
        @endif
@endsection

@section('scripts.footer')
    @include('admin.products.unpublished._footer')
@endsection
