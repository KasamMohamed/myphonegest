<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        Tableau de bord
    </x-nav-link>

    <x-nav-link :href="route('reparations.create')" :active="request()->routeIs('reparations.*')">
        Nouveau Ticket
    </x-nav-link>

    <x-nav-link :href="route('pieces.index')" :active="request()->routeIs('pieces.*')">
        Stock & Accessoires
    </x-nav-link>

    <x-nav-link :href="route('caisse.index')" :active="request()->routeIs('caisse.*')">
        Caisse
    </x-nav-link>

    <x-nav-link :href="route('depenses.index')" :active="request()->routeIs('depenses.*')">
        Dépenses
    </x-nav-link>
</div>
