<x-layouts.guest-qr>
    <x-slot name="title">Receipt - {{ $order->order_number }}</x-slot>

    <div class="receipt-container">
        <!-- Receipt Content -->
        <div class="receipt">
            <!-- Header / Outlet Info -->
            <div class="receipt-header">
                <h1 class="outlet-name">{{ $order->outlet->name }}</h1>
                @if($order->outlet->address)
                    <p class="outlet-address">{{ $order->outlet->address }}</p>
                @endif
                @if($order->outlet->phone)
                    <p class="outlet-phone">Tel: {{ $order->outlet->phone }}</p>
                @endif
            </div>

            <div class="receipt-divider"></div>

            <!-- Order Info -->
            <div class="receipt-section">
                <table class="info-table">
                    <tr>
                        <td>No. Pesanan</td>
                        <td class="text-right font-bold">{{ $order->order_number }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td class="text-right">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @if($order->table)
                        <tr>
                            <td>Meja</td>
                            <td class="text-right">{{ $order->table->name }}</td>
                        </tr>
                    @endif
                    @if($order->customer_name)
                        <tr>
                            <td>Nama</td>
                            <td class="text-right">{{ $order->customer_name }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td>Tipe</td>
                        <td class="text-right">{{ ucfirst(str_replace('_', ' ', $order->order_type)) }}</td>
                    </tr>
                </table>
            </div>

            <div class="receipt-divider"></div>

            <!-- Order Items -->
            <div class="receipt-section">
                <h2 class="section-title">ITEM PESANAN</h2>
                <table class="items-table">
                    @foreach($order->items as $item)
                        <tr>
                            <td colspan="3" class="item-name">{{ $item->menu_item_name }}</td>
                        </tr>
                        <tr>
                            <td class="item-qty">{{ $item->quantity }} x</td>
                            <td class="item-price">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                            <td class="item-subtotal text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @if($item->notes)
                            <tr>
                                <td colspan="3" class="item-notes">Note: {{ $item->notes }}</td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            </div>

            <div class="receipt-divider"></div>

            <!-- Totals -->
            <div class="receipt-section">
                <table class="totals-table">
                    <tr>
                        <td>Subtotal</td>
                        <td class="text-right">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @if($order->tax_amount > 0)
                        <tr>
                            <td>Pajak</td>
                            <td class="text-right">Rp {{ number_format($order->tax_amount, 0, ',', '.') }}</td>
                        </tr>
                    @endif
                    @if($order->service_charge > 0)
                        <tr>
                            <td>Service Charge</td>
                            <td class="text-right">Rp {{ number_format($order->service_charge, 0, ',', '.') }}</td>
                        </tr>
                    @endif
                    @if($order->discount_amount > 0)
                        <tr>
                            <td>Diskon</td>
                            <td class="text-right">-Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</td>
                        </tr>
                    @endif
                    <tr class="total-row">
                        <td><strong>TOTAL</strong></td>
                        <td class="text-right"><strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                    </tr>
                </table>
            </div>

            <div class="receipt-divider"></div>

            <!-- QR Code for Tracking -->
            <div class="receipt-qr">
                <p class="qr-label">Lacak Pesanan Anda</p>
                {!! QrCode::size(150)->generate(route('qr.track', $order->order_number)) !!}
                <p class="qr-number">{{ $order->order_number }}</p>
            </div>

            <div class="receipt-divider"></div>

            <!-- Footer -->
            <div class="receipt-footer">
                <p class="thank-you">Terima kasih atas kunjungan Anda!</p>
                <p class="footer-text">{{ config('app.name') }}</p>
                @if($order->outlet->website ?? false)
                    <p class="footer-text">{{ $order->outlet->website }}</p>
                @endif
            </div>
        </div>

        <!-- Print Button (hidden when printing) -->
        <div class="no-print print-button-container">
            <button onclick="window.print()" class="btn-primary py-3 px-6 text-lg">
                <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print Receipt
            </button>
            <button onclick="window.close()" class="btn-outline py-3 px-6 text-lg mt-3">
                Close
            </button>
        </div>
    </div>

    <style>
        /* Print Styles */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            .receipt-container {
                width: 80mm;
                margin: 0;
                padding: 0;
            }

            .receipt {
                padding: 10mm;
            }

            @page {
                size: 80mm auto;
                margin: 0;
            }
        }

        /* Screen Styles */
        @media screen {
            body {
                background-color: rgb(var(--color-neutral-100));
            }

            .receipt-container {
                max-width: 400px;
                margin: 2rem auto;
                padding: 1rem;
            }

            .receipt {
                background: white;
                padding: 2rem 1.5rem;
                border-radius: 0.5rem;
                box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            }

            .print-button-container {
                text-align: center;
                margin-top: 2rem;
            }
        }

        /* Common Styles */
        .receipt {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12pt;
            line-height: 1.4;
            color: #000;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 1rem;
        }

        .outlet-name {
            font-size: 18pt;
            font-weight: bold;
            margin: 0 0 0.5rem 0;
            text-transform: uppercase;
        }

        .outlet-address,
        .outlet-phone {
            font-size: 10pt;
            margin: 0.25rem 0;
        }

        .receipt-divider {
            border-top: 1px dashed #000;
            margin: 1rem 0;
        }

        .receipt-section {
            margin: 1rem 0;
        }

        .section-title {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .info-table,
        .items-table,
        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td,
        .totals-table td {
            padding: 0.25rem 0;
        }

        .items-table td {
            padding: 0.15rem 0;
        }

        .item-name {
            font-weight: bold;
            padding-top: 0.5rem !important;
        }

        .item-qty {
            width: 20%;
        }

        .item-price {
            width: 40%;
        }

        .item-subtotal {
            width: 40%;
            font-weight: bold;
        }

        .item-notes {
            font-size: 10pt;
            font-style: italic;
            color: #666;
            padding-bottom: 0.25rem !important;
        }

        .total-row {
            border-top: 1px solid #000;
            font-size: 14pt;
            padding-top: 0.5rem !important;
        }

        .total-row td {
            padding-top: 0.5rem;
        }

        .receipt-qr {
            text-align: center;
            margin: 1rem 0;
        }

        .receipt-qr svg {
            display: block;
            margin: 0.5rem auto;
        }

        .qr-label {
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .qr-number {
            font-size: 10pt;
            margin-top: 0.5rem;
        }

        .receipt-footer {
            text-align: center;
            margin-top: 1rem;
        }

        .thank-you {
            font-size: 12pt;
            font-weight: bold;
            margin: 0.5rem 0;
        }

        .footer-text {
            font-size: 10pt;
            margin: 0.25rem 0;
        }

        .text-right {
            text-align: right;
        }
    </style>

    <script>
        // Auto-trigger print dialog on mobile
        if (window.matchMedia) {
            const mediaQueryList = window.matchMedia('print');
            mediaQueryList.addListener((mql) => {
                if (!mql.matches) {
                    // After print, optionally close window
                    // window.close();
                }
            });
        }
    </script>
</x-layouts.guest-qr>
