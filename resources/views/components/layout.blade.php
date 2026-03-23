<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinTrack OE | {{ $attributes->get('title') }}</title>

    <style>
        /*This might need to go once I will tackle proper CSS*/
        
        /* Basic Layout structure */
        body { margin: 0; font-family: sans-serif; }
        nav { background: #333; color: white; padding: 10px; display: flex; align-items: center; justify-content: space-between; }
        nav ul { display: flex; list-style: none; gap: 20px; }
        nav a { color: white; text-decoration: none; }

        /* The flex container for the body */
        .wrapper { display: flex; min-height: calc(100vh - 60px); }

        /* Sidebar Styling */
        .sidebar { 
            width: 280px; 
            background: #f8f9fa; 
            border-right: 1px solid #ddd; 
            padding: 20px; 
            flex-shrink: 0; 
        }

        /* Main Content Styling */
        .main-content { 
            flex-grow: 1; 
            padding: 20px; 
            background: white; 
        }
    </style>

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

<div class="wrapper">
        @if (isset($sidebar))
            <aside class="sidebar">
                {{ $sidebar }}
            </aside>
        @endif

        <main class="main-content">
            {{ $slot }}
        </main>
    </div>
</body>
</html>