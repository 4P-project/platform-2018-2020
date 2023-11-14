<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Invoice: {{ $invoice->id }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background: #fff;
            background-image: none;
            font-size: 15px;
        }

        address {
            margin-top: 15px;
        }

        h2 {
            font-size: 28px;
            color: #cccccc;
        }

        .container {
            padding-top: 30px;
        }

        .invoice-head td {
            padding: 0 8px;
        }

        .invoice-body {
            background-color: transparent;
        }

        .logo {
            padding-bottom: 10px;
        }

        .table th {
            vertical-align: bottom;
            font-weight: bold;
            padding: 8px;
            line-height: 20px;
            text-align: left;
        }

        .table td {
            padding: 8px;
            line-height: 20px;
            text-align: left;
            vertical-align: top;
            border-top: 1px solid #dddddd;
        }

        .well {
            margin-top: 15px;
        }
    </style>
</head>

<body>
<div class="container">
    <table style="margin-left: auto; margin-right: auto" width="550">
        <tr>
            <td align="left">
                <img src="img/4thpillar/logo_dark.png">
            </td>
            <td align="right">
                Invoice #: {{ $invoice->id }}
                <br/>
                Created: {{ $invoice->date()->toFormattedDateString() }}
            </td>
        </tr>
        <tr valign="top">

            <!-- Organization Name / Date -->
            <td align="left">
                <br/><br/>
                Cetrti Steber d.o.o.
                <br/>
                Parmova ulica 53
                <br/>
                1000 Ljubljana
                <br/>
                ID: 8098492000
            </td>
            <td align="right">
                <br/><br/>
                @if (session('is_corporate', false))
                    {{ auth()->user()->kyc->company_name }}
                    <br/>
                    {{ auth()->user()->kyc->business_address }}
                    <br/>
                    {{ auth()->user()->kyc->tax_id_number }}
                    <br/>
                    {{ auth()->user()->kyc->email }}
                @else
                    {{ auth()->user()->email }}
                @endif
                <br/>
                <br/>
            </td>
        </tr>
        <tr valign="top">
            <td colspan="2">

                <!-- Extra / VAT Information -->
                @if (isset($vat))
                    <p>
                        {{ $vat }}
                    </p>
                @endif

                <br><br>

                <!-- Invoice Table -->
                <table width="100%" class="table" border="0">
                    <tr>
                        <th align="left">Description</th>
                        <th align="right">Amount</th>
                    </tr>

                    <!-- Display The Invoice Charges -->
                    <tr>
                        <td>
                            @if ($invoice->planId)
                                Subscription To "{{ $invoice->planId }}"
                            @elseif (isset($invoice->customFields['description']))
                                {{ $invoice->customFields['description'] }}
                            @else
                                Charge
                            @endif
                        </td>

                        <td>{{ $invoice->subtotal() }}</td>
                    </tr>

                    <!-- Display The Add-Ons -->
                    @if ($invoice->hasAddOn())
                        <tr>
                            <td>Add-Ons ({{ implode(', ', $invoice->addOns()) }})</td>
                            <td>{{ $invoice->addOn() }}</td>
                        </tr>
                    @endif

                <!-- Display The Discount -->
                    @if ($invoice->hasDiscount())
                        <tr>
                            <td>Discounts ({{ implode(', ', $invoice->coupons()) }})</td>
                            <td>-{{ $invoice->discount() }}</td>
                        </tr>
                @endif

                <!-- Display The Final Total -->
                    <tr style="border-top:2px solid #000;">
                        <td style="text-align: right;"><strong>Total</strong>
                        </td>
                        <td><strong>{{ $invoice->total() }}</strong></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
