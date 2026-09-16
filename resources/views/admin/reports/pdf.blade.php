<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; color: #1B2027; font-size: 12px; }
        h1 { font-size: 18px; margin-bottom: 0; }
        .subtitle { color: #6B7280; margin-top: 4px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #DCE3EC; padding: 6px 10px; text-align: left; }
        th { background: #EAF0F6; }
        .totals td { font-weight: bold; }
        h2 { font-size: 14px; margin-top: 25px; margin-bottom: 8px; border-bottom: 2px solid #E8722F; padding-bottom: 4px; }
    </style>
</head>
<body>
    <h1>Al Huda Mobiles Repairing Lab — Business Report</h1>
    <p class="subtitle">{{ $from->format('d M Y') }} to {{ $to->format('d M Y') }}</p>

    <table>
        <tr>
            <th>Total Revenue</th>
            <th>Total Repairs</th>
            <th>Total Orders</th>
            <th>New Customers</th>
        </tr>
        <tr class="totals">
            <td>Rs. {{ number_format($totalRevenue, 2) }}</td>
            <td>{{ $totalRepairs }}</td>
            <td>{{ $totalOrders }}</td>
            <td>{{ $newCustomers }}</td>
        </tr>
    </table>

    <h2>Repairs</h2>
    <table>
        <tr><th>Metric</th><th>Value</th></tr>
        <tr><td>Total Repairs</td><td>{{ $totalRepairs }}</td></tr>
        <tr><td>Completed</td><td>{{ $completedRepairs }}</td></tr>
        <tr><td>Revenue from Repairs</td><td>Rs. {{ number_format($repairRevenue, 2) }}</td></tr>
    </table>

    <table>
        <tr><th>Status</th><th>Count</th></tr>
        @forelse ($repairsByStatus as $status => $count)
            <tr><td>{{ ucfirst(str_replace('-', ' ', $status)) }}</td><td>{{ $count }}</td></tr>
        @empty
            <tr><td colspan="2">No repairs in this range.</td></tr>
        @endforelse
    </table>

    <h2>Shop</h2>
    <table>
        <tr><th>Metric</th><th>Value</th></tr>
        <tr><td>Total Orders</td><td>{{ $totalOrders }}</td></tr>
        <tr><td>Revenue (Completed Orders)</td><td>Rs. {{ number_format($orderRevenue, 2) }}</td></tr>
    </table>

    <table>
        <tr><th>Status</th><th>Count</th></tr>
        @forelse ($ordersByStatus as $status => $count)
            <tr><td>{{ ucfirst($status) }}</td><td>{{ $count }}</td></tr>
        @empty
            <tr><td colspan="2">No orders in this range.</td></tr>
        @endforelse
    </table>

    <p style="color: #6B7280; margin-top: 30px;">Generated on {{ now()->format('d M Y, h:i A') }}</p>
</body>
</html>