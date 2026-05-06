@extends('layouts.app')

@section('title', 'Sepetim')
@section('meta_description', 'Sepetinizdeki ürünleri inceleyin ve siparişinizi onaylayın.')

@push('styles')
<style>
    .cart-wrapper {
        max-width: 760px;
        margin: 0 auto;
    }

    .cart-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        padding: 18px 24px;
        border-bottom: 1px solid var(--clr-border);
        transition: background var(--transition);
    }

    .cart-row:first-child { border-radius: var(--radius-lg) var(--radius-lg) 0 0; }
    .cart-row:last-child  { border-bottom: none; }
    .cart-row:hover       { background: rgba(214,168,79,0.06); }

    .item-info { flex: 1; }

    .item-name {
        font-weight: 600;
        font-size: 1rem;
        color: var(--clr-text);
        margin-bottom: 4px;
    }

    .item-unit-price {
        font-size: 0.82rem;
        color: var(--clr-text-mute);
    }

    .qty-controls {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .qty-btn {
        width: 34px;
        height: 34px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: 700;
        text-decoration: none;
        transition: transform var(--transition), filter var(--transition);
    }

    .qty-btn:hover { transform: scale(1.15); filter: brightness(1.2); }
    .qty-btn.plus  { background: var(--clr-success); color: #fff; }
    .qty-btn.minus { background: var(--clr-warn);    color: #fff; }

    .qty-number {
        font-size: 1rem;
        font-weight: 700;
        color: var(--clr-text);
        min-width: 24px;
        text-align: center;
    }

    .item-subtotal {
        font-weight: 700;
        color: var(--clr-gold);
        min-width: 90px;
        text-align: right;
        font-size: 0.95rem;
    }

    .del-btn {
        background: transparent;
        border: 1px solid rgba(224,82,82,0.3);
        color: var(--clr-danger);
        width: 32px;
        height: 32px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 0.9rem;
        transition: background var(--transition), transform var(--transition);
    }

    .del-btn:hover {
        background: var(--clr-danger);
        color: #fff;
        transform: scale(1.1);
    }

    /* ── Summary footer ── */
    .cart-summary {
        margin-top: 24px;
        padding: 24px;
        border-radius: var(--radius-lg);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .total-label  { font-size: 0.9rem; color: var(--clr-text-mute); margin-bottom: 4px; }
    .total-amount { font-size: 2rem; font-weight: 800; color: var(--clr-gold); }

    /* ── Empty state ── */
    .empty-cart {
        text-align: center;
        padding: 80px 20px;
    }

    .empty-cart-icon {
        font-size: 5rem;
        display: block;
        margin-bottom: 20px;
        animation: pulse 3s ease-in-out infinite;
    }

    .empty-cart h2 {
        font-size: 1.4rem;
        color: var(--clr-text-mute);
        font-weight: 500;
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
@php $cart = session('cart', []); @endphp

<h1 class="page-title">Sepetim <small>{{ count($cart) }} ürün</small></h1>

<div class="cart-wrapper">

    @if(count($cart) > 0)

        <div class="glass">
            @foreach($cart as $id => $item)
                <div class="cart-row">
                    <div class="item-info">
                        <div class="item-name">{{ $item['name'] }}</div>
                        <div class="item-unit-price">{{ number_format($item['price'], 2) }} ₺ / adet</div>
                    </div>

                    <div class="qty-controls">
                        <a href="{{ route('cart.decrease', $id) }}" class="qty-btn minus" id="dec-{{ $id }}" title="Azalt">−</a>
                        <span class="qty-number">{{ $item['quantity'] }}</span>
                        <a href="{{ route('cart.increase', $id) }}" class="qty-btn plus"  id="inc-{{ $id }}" title="Artır">+</a>
                    </div>

                    <div class="item-subtotal">
                        {{ number_format($item['price'] * $item['quantity'], 2) }} ₺
                    </div>

                    <a href="{{ route('cart.remove', $id) }}" class="del-btn" id="del-{{ $id }}" title="Kaldır">✕</a>
                </div>
            @endforeach
        </div>

        <div class="cart-summary glass">
            <div>
                <div class="total-label">Genel Toplam</div>
                <div class="total-amount">
                    {{ number_format(collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']), 2) }} ₺
                </div>
            </div>

            <div style="display:flex; gap:12px; flex-wrap:wrap;">
                <a href="{{ route('menu') }}" class="btn btn-ghost" id="continue-shopping">← Alışverişe Devam</a>
                <form action="{{ route('order.confirm') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-gold" style="padding: 14px 32px;" id="confirm-btn">
                        ✅ Siparişi Onayla
                    </button>
                </form>
            </div>
        </div>

    @else

        <div class="empty-cart">
            <span class="empty-cart-icon">🛒</span>
            <h2>Sepetiniz boş</h2>
            <a href="{{ route('menu') }}" class="btn btn-gold" style="padding:14px 32px;" id="go-menu-btn">
                Menüye Git
            </a>
        </div>

    @endif

</div>
@endsection