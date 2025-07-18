@if (!empty($customer_orders))
  <div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4 text-gray-800">
      {{ __('Recent orders', 'woocommerce') }}
    </h2>

    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left text-gray-700 border border-gray-200">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            @foreach ($my_orders_columns as $column_id => $column_name)
              <th scope="col" class="px-4 py-2">
                {{ $column_name }}
              </th>
            @endforeach
          </tr>
        </thead>
        <tbody class="bg-white">
          @foreach ($customer_orders as $customer_order)
            @php
              $order = wc_get_order($customer_order);
              $item_count = $order->get_item_count();
              $actions = wc_get_account_orders_actions($order);
            @endphp

            <tr class="border-t border-gray-200 hover:bg-gray-50">
              @foreach ($my_orders_columns as $column_id => $column_name)
                <td class="px-4 py-3 whitespace-nowrap">
                  @if (has_action("woocommerce_my_account_my_orders_column_{$column_id}"))
                    @php do_action("woocommerce_my_account_my_orders_column_{$column_id}", $order); @endphp
                  @elseif ($column_id === 'order-number')
                    <a href="{{ $order->get_view_order_url() }}" class="text-blue-600 hover:underline">
                      #{{ $order->get_order_number() }}
                    </a>
                  @elseif ($column_id === 'order-date')
                    <time datetime="{{ $order->get_date_created()->date('c') }}">
                      {{ wc_format_datetime($order->get_date_created()) }}
                    </time>
                  @elseif ($column_id === 'order-status')
                    <span class="capitalize">{{ wc_get_order_status_name($order->get_status()) }}</span>
                  @elseif ($column_id === 'order-total')
                    {{ sprintf(_n('%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'woocommerce'), $order->get_formatted_order_total(), $item_count) }}
                  @elseif ($column_id === 'order-actions')
                    <div class="flex flex-wrap gap-2">
                      @foreach ($actions as $action)
                        <a href="{{ esc_url($action['url']) }}"
                          class="inline-block px-3 py-1 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700">
                          {{ $action['name'] }}
                        </a>
                      @endforeach
                    </div>
                  @endif
                </td>
              @endforeach
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endif
