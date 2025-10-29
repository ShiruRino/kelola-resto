<div class="sidebar-brand">
    <a href="{{ route('index') }}">Resto</a>
</div>

<nav class="nav flex-column">
    <a href="{{ route('index') }}" class="nav-link">Dashboard</a>
    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'waiter')
    <a href="{{ route('products.index') }}" class="nav-link">Manage Products</a>
    @endif
    <a href="{{ route('customers.index') }}" class="nav-link">Manage Customers</a>
    @if (Auth::user()->role === 'admin')
    <a href="{{ route('tables.index') }}" class="nav-link">Manage Tables</a>
    @else
    <a href="{{ route('tables.index') }}" class="nav-link">Tables</a>
    @endif
    @if (Auth::user()->role === 'waiter')
    <a href="{{ route('orders.index') }}" class="nav-link">Manage Orders</a>
    @else
    <a href="{{ route('orders.index') }}" class="nav-link">Orders</a>
    @endif
    <a href="{{ route('transactions.index') }}" class="nav-link">Manage Transactions</a>
    @if (Auth::user()->role === 'admin')
    <a href="{{ route('histories.index') }}" class="nav-link">Activity Logs</a>
    @endif
    <form action="{{ route('auth.logout') }}" method="POST" class="mt-3" onsubmit="return confirm('Are you sure you want to logout?')">
        @csrf
        <button class="btn btn-danger w-100" type="submit">Logout</button>
    </form>
</nav>
