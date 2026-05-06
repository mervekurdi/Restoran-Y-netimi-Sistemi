@extends('layouts.app')

@section('title', 'Menü')
@section('meta_description', 'Lezzet Durağı restoran menüsü — kategoriler ve fiyatlar ile tüm yemeklerimize göz atın.')

@push('styles')
<style>
    .menu-layout {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 28px;
        align-items: start;
    }

    @media (max-width: 900px) {
        .menu-layout { grid-template-columns: 1fr; }
        .cart-panel  { order: -1; }
    }

    /* ── Category chips ── */
    .category-section { margin-bottom: 36px; }

    .category-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(214, 168, 79, 0.15);
        border: 1px solid rgba(214, 168, 79, 0.3);
        color: var(--clr-gold);
        font-size: 0.8rem;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 99px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 14px;
    }

    /* ── Menu items ── */
    .menu-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        padding: 18px 20px;
        border-radius: var(--radius-md);
        background: rgba(255, 248, 235, 0.05);
        border: 1px solid var(--clr-border);
        margin-bottom: 12px;
        transition: background var(--transition), transform var(--transition), border-color var(--transition);
    }

    .menu-item:hover {
        background: rgba(214, 168, 79, 0.08);
        border-color: rgba(214, 168, 79, 0.4);
        transform: translateX(4px);
    }

    .food-name {
        font-weight: 600;
        font-size: 1rem;
        color: var(--clr-text);
        margin-bottom: 4px;
    }

    .food-price {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--clr-gold);
    }

    /* ── Cart panel ── */
    .cart-panel {
        position: sticky;
        top: 88px;
        padding: 24px;
    }

    .cart-panel-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--clr-gold);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .cart-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        padding: 12px 0;
        border-bottom: 1px solid var(--clr-border);
    }

    .cart-item:last-of-type { border-bottom: none; }

    .cart-item-name {
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--clr-text);
        flex: 1;
    }

    .cart-item-qty {
        font-size: 0.8rem;
        color: var(--clr-text-mute);
    }

    .cart-item-controls {
        display: flex;
        gap: 4px;
    }

    .ctrl-btn {
        width: 28px;
        height: 28px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
        transition: transform var(--transition), filter var(--transition);
    }

    .ctrl-btn:hover { transform: scale(1.15); filter: brightness(1.15); }

    .ctrl-btn.plus  { background: var(--clr-success); color: #fff; }
    .ctrl-btn.minus { background: var(--clr-warn);    color: #fff; }
    .ctrl-btn.del   { background: var(--clr-danger);  color: #fff; }

    .cart-total {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--clr-gold);
        margin: 18px 0 16px;
        display: flex;
        justify-content: space-between;
    }

    .cart-empty {
        text-align: center;
        padding: 32px 20px;
        color: var(--clr-text-mute);
        font-size: 0.9rem;
    }

    .cart-empty-icon { font-size: 2.5rem; display: block; margin-bottom: 10px; }
</style>
@endpush

@section('content')
<h1 class="page-title">Menü <small>Kategorilere göz atın ve sepetinize ekleyin</small></h1>

<div class="menu-layout">

    {{-- ── LEFT: Menu items ── --}}
    <div class="menu-left">
        @forelse($categories as $category)
            <div class="category-section">
                <div class="category-chip">🍴 {{ $category->name }}</div>

                @foreach($category->menus as $menu)
                    <div class="menu-item" id="menu-item-{{ $menu->id }}">
                        <div>
                            <div class="food-name">{{ $menu->name }}</div>
                            <div class="food-price">{{ number_format($menu->price, 2) }} ₺</div>
                        </div>
                        <form action="{{ route('cart.add', $menu->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-gold" type="submit" id="add-btn-{{ $menu->id }}">
                                + Ekle
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @empty
            <p style="color: var(--clr-text-mute);">Henüz menü eklenmedi.</p>
        @endforelse
    </div>

    {{-- ── RIGHT: Cart panel ── --}}
    <div class="cart-panel glass" id="cart-panel">
        <div class="cart-panel-title">🛒 Siparişiniz</div>

        @php $cart = session('cart', []); @endphp

        @if(count($cart) > 0)
            @foreach($cart as $id => $item)
                <div class="cart-item">
                    <div class="cart-item-name">{{ $item['name'] }}</div>
                    <div class="cart-item-qty">x{{ $item['quantity'] }}</div>
                    <div class="cart-item-controls">
                        <a href="{{ route('cart.increase', $id) }}" class="ctrl-btn plus" title="Artır">+</a>
                        <a href="{{ route('cart.decrease', $id) }}" class="ctrl-btn minus" title="Azalt">−</a>
                        <a href="{{ route('cart.remove', $id) }}"   class="ctrl-btn del"   title="Sil">✕</a>
                    </div>
                </div>
            @endforeach

            <div class="divider"></div>

            <div class="cart-total">
                <span>Toplam</span>
                <span>{{ number_format(collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']), 2) }} ₺</span>
            </div>

            <form action="{{ route('order.confirm') }}" method="POST">
                @csrf
                <button class="btn btn-gold" type="submit" style="width:100%; padding: 14px;" id="confirm-order-btn">
                    ✅ Sipariş Ver
                </button>
            </form>

        @else
            <div class="cart-empty">
                <span class="cart-empty-icon">🛍️</span>
                Sepetiniz boş.<br>Menüden ürün ekleyin.
            </div>
        @endif
    </div>

</div>
@endsection