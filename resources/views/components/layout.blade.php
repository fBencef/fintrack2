<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinTrack OE | {{ $attributes->get('title') }}</title>
</head>
<body>
    <nav>
        <h1>FinTrack OE</h1>
        <ul>
            <li><a href="/transactions/incomes">Incomes</a></li>
            <li><a href="/transactions/expenses">Expenses</a></li>
            <li><a href="/transactions">All Transactions</a></li>
        </ul>    
    </nav>

    <main class="container">
        {{ $slot }}
    </main>
</body>
</html>