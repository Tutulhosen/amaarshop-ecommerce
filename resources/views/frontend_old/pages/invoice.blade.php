<!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Order Report</title>
    
    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 0px 30px 30px 30px;
            border: 1px solid #eee;
            font-size: 10px;
            line-height: 12px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #000;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            cellpadding:0px;
        }

        .invoice-box table td {
            padding: 0px;
            vertical-align: top;
        }
        .invoice-box table.details td {
            padding: 0px;
            vertical-align: top;
        }
        .invoice-box table td h2{margin: 0px;}

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box tr.information table tr td:nth-child(2) {
            text-align: left;
        }

        .invoice-box tr.information table.details tr.heading td:nth-child(2) {
            text-align: center;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 10px;
        }


        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 20px;
        }


        .invoice-box table tr.information table.details td {
            padding-bottom: 0px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td{
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        .invoice-box table tr.item td:nth-child(1){
            max-width: 150px;
            padding-right: 10px;
        }
        .invoice-box table tr.item td:nth-child(3){
            text-align: right;
        }
        .invoice-box table tr.item td:nth-child(4){
            text-align: right;
        }
        .invoice-box table tr.item td:nth-child(5){
            text-align: right;
        }
        .invoice-box table tr.item td:nth-child(6){
            text-align: right;
        }
        .invoice-box table tr.terms_conditions td:nth-child(1){
            padding: 50px 30px 30px 0px;
        }
        .invoice-box table tr.terms_conditions td:nth-child(2){
            padding: 50px 0px 30px;
        }
        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(2) {
            text-align: left;
        }
        table.details tr.heading td:nth-child(1){
            text-align: left;
            vertical-align: middle;
        }
        table.details tr.heading td:nth-child(2){
            text-align: left;
            vertical-align: middle;
        }
        table.details tr.heading td:nth-child(3){
            text-align: right;
            vertical-align: middle;
        }
        table.details tr.heading td:nth-child(4){
            text-align: right;
            vertical-align: middle;
        }
        table.details tr.heading td:nth-child(5){
            text-align: right;
            vertical-align: middle;
        }
        table.details tr.heading td:nth-child(6){
            text-align: right;
            vertical-align: middle;
        }
        .text-left{text-align: left !important;}
        .text-right{text-align: right !important;}
        .item.selected td{background:blue;color:#fff;}
    </style>
</head>

<body cz-shortcut-listen="true" data-new-gr-c-s-check-loaded="8.912.0" data-gr-ext-installed="">
    <div class="invoice-box" style="position: relative">
        {{-- <div class="download_btn" style="position: absolute; top: 10px; right: 10px; padding: 10px; background-color: red; width: 50px; border-radius: 5px; text-align: center;">
            <a style="color: white; text-decoration: none;" href="{{ route('download.invoice', $single_order->order_code) }}">Download</a>
        </div> --}}
        
        <table cellpadding="0" cellspacing="0">
            <tbody>
                <tr class="top">
                    <td colspan="2">
                        <table>
                            <tbody><tr>
                                <td class="title" style="text-align:center;">
                                    <img src="{{asset('frontend/image/6649146b6febe.png')}}" style="margin:auto;height: 90px;">
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">
                                    <h2>Order</h2>
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
                <tr class="information">
                    <td colspan="2">
                        <table>
                            <tbody>
                                <tr>
                                    <td style="width:50%;">
                                        <table class="details">
                                            <tbody>
                                                <tr>
                                                    <th style="width:100px;">Order No.</th>
                                                    <td>:</td>
                                                    <td>{{$single_order->order_code}}</td>
                                                </tr><tr>
                                                    <th>Order Date</th>
                                                    <td>:</td>
                                                    <td>{{$single_order->order_date}}</td>
                                                </tr><tr>
                                                    <th>Aprx Delivery</th>
                                                    <td>:</td>
                                                    <td>{{$single_order->delivery_date ?? '----'}}</td>
                                                </tr><tr>
                                                    <th>Customer Name</th>
                                                    <td>:</td>
                                                    <td>{{$single_order->full_name}}</td>
                                                </tr><tr>
                                                    <th>Phone</th>
                                                    <td>:</td>
                                                    <td>{{$single_order->phone_number}}</td>
                                                </tr><tr>
                                                    <th>Address</th>
                                                    <td>:</td>
                                                    <td>{{$single_order->delivery_address}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td></td>
                                    
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr class="information">
                    <td colspan="2">
                        <table class="details">
                            <tbody>
                                <tr class="heading">
                                    <td class="text-left">SL.</td>
                                    <td class="text-left">Title</td>
                                    <td class="text-right">Qty</td>
                                    <td class="text-left">&nbsp;&nbsp;Unit</td>
                                    <td class="text-right" style="width:100px">Price (BDT)</td>
                                    <td class="text-right" style="width:100px">Vat (BDT)</td>
                                    <td class="text-right" style="width:100px">Total (BDT)</td>
                                </tr>
                        
                                @php $total = 0; $discount_price=0;@endphp
                                @foreach($order_invoice as $key => $item)
                                @php
                                    // Calculate total for each item
                                    $discount_price=$item->offer_cost-$item->discount;
                                    $itemTotal = $item->products_qty * $discount_price;
                                    $total += $itemTotal;
                                @endphp
                                <tr class="item">
                                    <td class="text-left">{{ $key + 1 }}</td>
                                    <td class="text-left">{{ $item->title }}</td>
                                    <td class="text-right">{{ $item->products_qty }}</td>
                                    <td class="text-left">&nbsp;&nbsp;pc</td>
                                    <td class="text-right">{{ number_format($discount_price, 2) }}</td>
                                    <td class="text-right">0.00</td>
                                    <td class="text-right">{{ number_format($itemTotal, 2) }}</td>
                                </tr>
                                @endforeach
                        
                                <tr class="heading">
                                    <td colspan="2" class="text-right">Subtotal:</td>
                                    <td class="text-right">{{ $order_invoice->sum('products_qty') }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right">{{ number_format($total, 2) }}</td>
                                </tr>
                        
                                <!-- Additional charges and total -->
                                <tr class="heading">
                                    <td colspan="2"></td>
                                    <td class="text-right"></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right">Delivery charges:</td>
                                    <td class="text-right">{{delivery_charge($item->delivery_charge)}}</td>
                                </tr>
                                {{-- <tr class="heading">
                                    <td colspan="2"></td>
                                    <td class="text-right"></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right">Discount:</td>
                                    <td class="text-right">(-)0.00</td>
                                </tr> --}}
                                <tr class="heading">
                                    <td colspan="2" class="text-right"></td>
                                    <td class="text-right"></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right">Total:</td>
                                    <td class="text-right">{{ number_format($total + delivery_charge($item->delivery_charge), 2) }}</td>
                                </tr>
                                
                            </tbody>
                        </table>
                        
                            
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><br><br></td>
                </tr>
                <tr>
                    <td>
                        {{-- Printed by- Mr. Faysal Kabir (Munna) @ 01/09/2024 03:12 AM --}}
                    </td>
             
                    
                    @if (!Auth::user())
                    <td><a href="{{route('home')}}" >Home</a></td>  
                    @endif
                </tr>
            </tbody>
        </table>
    </div>

</body>
<grammarly-desktop-integration data-grammarly-shadow-root="true"></grammarly-desktop-integration></html>