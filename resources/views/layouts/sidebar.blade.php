<div class="sidebar-brand">
    <a href="{{ route('index') }}">Resto</a>
</div>

<nav class="nav flex-column">
    <a href="{{ route('index') }}" class="nav-link">Dashboard</a>
    <a href="{{ route('products.index') }}" class="nav-link">Manage Products</a>
    <a href="{{ route('customers.index') }}" class="nav-link">Manage Customers</a>
    <a href="{{ route('orders.index') }}" class="nav-link">Manage Orders</a>
    <a href="{{ route('transactions.index') }}" class="nav-link">Manage Transactions</a>
    <a href="{{ route('histories.index') }}" class="nav-link">Manage Histories</a>
    <form action="{{ route('auth.logout') }}" method="POST" class="mt-3" onsubmit="return confirm('Are you sure you want to logout?')">
        @csrf
        <button class="btn btn-danger w-100" type="submit">Logout</button>
    </form>
</nav>
