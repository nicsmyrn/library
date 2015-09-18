@extends('admin.dashboard')

@section('header')
    Προβολή Αδημοσίευτων
@endsection

@section('content')
    <div class="row">
        @if($products)
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Check</th>
                        <th>Title</th>
                        <th>Barcode</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td><input type="checkbox"/> </td>
                            <td><a href="{!! route('Admin::Unpublished::confirmUnpublished', [$product->barcode]) !!}"> {!! $product->title !!}</a></td>
                            <td>{!! $product->barcode !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Δεν υπάρχουν αδημοσίευτα</p>
        @endif

    </div>

@endsection
