@extends('layouts.app')

@section('title', 'Siparişler')
@section('meta_description', 'Geçmiş ve mevcut siparişlerinizi görüntüleyin.')

@push('styles')
<style>
    .orders-grid {
        display: grid;
        gap: 20px;
    }

    .order-card {
        border-radius: var(--radius-lg);
        overflow: hidden;
        border: 1px solid var(--clr-border);
        background: rgba(255,248,235,0.05);
        transition: border-color var(--transition), box-shadow var(--transition);
    }

    .order-card:hover {
        border-color: rgba(214,168,79,0.4);
        box-shadow: var(--shadow-md);
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        background: rgba(214,168,79,0.08);
        border-bottom: 1px solid var(--clr-border);
    }

    .order-number {
        font-weight: 700;
        color: var(--clr-gold);
        font-size: 0.95rem;
    }

    .order-date {
        font-size: 0.8rem;
        color: var(--clr-text-mute);
        margin-top: 2px;
    }

    .order-badge {
        background: linear-gradient(135deg, var(--clr-gold), var(--clr-gold-dark));
        color: #1a1208;
        font-size: 0.9rem;
        font-weight: 700;
        padding: 6px 16px;
        border-radius: 99px;
    }

    .order-items {
        padding: 16px 24px;
    }

    .order-item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid rgba(214,168,79,0.1);
        font-size: 0.9rem;
    }

    .order-item-row:last-child { border-bottom: none; }

    .order-item-name {
        color: var(--clr-text);
        font-weight: 500;
    }

    .order-item-detail {
        display: flex;
        gap: 20px;
        color: var(--clr-text-mute);
        font-size: 0.85rem;
    }

    .order-item-detail strong { color: var(--clr-gold); }

    /* ── Empty state ── */
    .empty-orders {
        text-align: center;
        padding: 80px 20px;
    }

    .empty-orders-icon {
        font-size: 5rem;
        display: block;
        margin-bottom: 20px;
    }

    .empty-orders h2 {
        font-size: 1.4rem;
        color: var(--clr-text-mute);
        font-weight: 500;
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
<h1 class="page-title">Sipariş Geçmişi <small>Tüm siparişleriniz aşağıda listelenmektedir</small></h1>

@if($orders->count() > 0)
    <div class="orders-grid">
        @foreach($orders as $order)
            <div class="order-card" id="order-{{ $order->id }}">

                <div class="order-header">
                    <div>
                        <div class="order-number">#{{ $order->id }} numaralı sipariş</div>
                        <div class="order-date">{{ $order->created_at->format('d.m.Y — H:i') }}</div>
                    </div>
                    <div class="order-badge">{{ number_format($order->total, 2) }} ₺</div>
                </div>

                <div class="order-items">
                    @foreach($order->items as $item)
                        <div class="order-item-row">
                            <span class="order-item-name">{{ $item->name }}</span>
                            <div class="order-item-detail">
                                <span>x{{ $item->quantity }}</span>
                                <strong>{{ number_format($item->price * $item->quantity, 2) }} ₺</strong>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        @endforeach
    </div>
@else
    <div class="empty-orders">
        <span class="empty-orders-icon">🧾</span>
        <h2>Henüz sipariş verilmedi</h2>
        <a href="{{ route('menu') }}" class="btn btn-gold" style="padding:14px 32px;" id="start-order-btn">
            İlk Siparişini Ver
        </a>
    </div>
@endif
@endsection