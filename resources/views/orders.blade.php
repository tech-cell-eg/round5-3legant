@extends('adminlte::page')

@section('title', 'orders')

@section('content_header')
    <h1>Orders</h1>
@stop

@section('content')

{{-- @if(Auth::check())
    Welcome, {{ Auth::user()->name }}
@else
    You are not logged in.
@endif --}}

    <table class="table">
        <thead>
            <tr>
                <th>customer name</th>
                <th>customer email</th>
                <th>customer phone</th>
                <th>order price</th>
                <th>address</th>
                <th>status</th>
                <th>date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr id="order-{{ $order->id }}">
                    <td>{{ $order->first_name }}</td>
                    <td>{{ $order->email }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>{{ $order->final_price }}</td>
                    <td>{{ $order->address }}</td>
                    <td>
                        <select class="order-status" data-id="{{ $order->id }}">
                            <option value="cancelled" {{ $order->status === "cancelled" ? "selected" : "" }}>cancelled</option>
                            <option value="pending" {{ $order->status === "pending" ? "selected" : "" }}>pending</option>
                            <option value="delivered" {{ $order->status === "delivered" ? "selected" : "" }}>delivered</option>
                            <option value="shipped" {{ $order->status === "shipped" ? "selected" : "" }}>shipped</option>
                        </select>
                    </td>
                    <td>{{ $order->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop

@section('js')
<script>
    $(function () {
        $('.order-status').on('change', function () {
            let orderId = $(this).data('id');
            let newStatus = $(this).val();

            $.ajax({
                url: "{{ route('orders.updateStatus') }}", 
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: orderId,
                    status: newStatus
                },
                success: function (response) {
                    console.log(response);
                    alert('Order status updated successfully!');
                },
                error: function (xhr) {
                    alert('Failed to update status');
                }
            });
        });
    });
</script>

@endsection
