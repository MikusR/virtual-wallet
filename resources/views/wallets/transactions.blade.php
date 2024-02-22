<x-layout>
    <section>


        @if (request()->routeIs('wallets.edit'))
            <div class="container">
                <form method="post" action="/wallets/{{ $wallet->id }}/update">
                    @csrf
                    <label for="name">name:</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $wallet->name) }}">
                    @error('name')
                    <p class="pico-color-red-600">{{ $message }}</p>
                    @enderror
                    <button type="submit">Rename Wallet</button>
                </form>
            </div>
        @else
            <div>
                <h2><a href="/wallets/{{ $wallet->id }}/edit" data-tooltip="Rename">{{ $wallet->name }}</a></h2>
            </div>
        @endif
        <p>Current Balance: {{$wallet->transactions()->sum('amount')}}</p>
        <span>Total incoming: <span
                class="pico-color-green">{{$wallet->transactions()->where('type', 'in')->sum('amount')}}</span></span>
        <span>|</span>
        <span>Total outgoing: <span
                class="pico-color-red">{{$wallet->transactions()->where('type', 'out')->sum('amount')}}</span></span>
        <hr>
        <a href="/wallets/{{ $wallet->id }}/transactions/create">Create transaction</a>
        <hr>

        @if($wallet->transactions()->count() === 0)
            <h2 class="pico-color-red">No transactions</h2>
        @else

            <table class="container">
                <thead>
                <tr>
                    <th scope="col">Amount</th>
                    <th scope="col">Type</th>
                    <th scope="col">Fraud</th>


                    <th scope="col">Created</th>
                    <th scope="col">Delete</th>

                </tr>
                </thead>
                <tbody>


                @foreach($wallet->transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->amount }}</td>
                        @if ($transaction->type === 'in')
                            <td>Incoming from {{ $transaction->secondary_wallet }}</td>
                        @endif
                        @if ($transaction->type === 'out')
                            <td>Sent to {{ $transaction->secondary_wallet }}</td>
                        @endif
                        @if ($transaction->is_fraudulent)
                            <td class="pico-color-red-600">fraudulent</td>
                        @else
                            <td><a class="pico-color-green-600"
                                   href="javascript:void(0); document.getElementById('transaction-{{ $transaction->group_id }}-mark-as-fraud').requestSubmit();">mark
                                    as fraudulent</a></td>
                        @endif

                        <td>{{ $transaction->created_at }}</td>
                        <td><a class="pico-color-red-600"
                               href="javascript:void(0); document.getElementById('transaction-{{ $transaction->group_id }}-delete').requestSubmit();">Delete</a>
                        </td>
                        <form method="post" style="display: none;"
                              onSubmit="return confirm('Do you want to mark this transaction as fraud?')"
                              action="/wallets/{{ $wallet->id }}/transactions/{{ $transaction->group_id }}/mark-as-fraud"
                              id="transaction-{{ $transaction->group_id }}-mark-as-fraud">
                            @csrf
                        </form>
                        <form method="post" style="display: none;"
                              onSubmit="return confirm('Do you want to delete this transaction?')"
                              action="/wallets/{{ $wallet->id }}/transactions/{{ $transaction->group_id }}/delete"
                              id="transaction-{{ $transaction->group_id }}-delete">
                            @csrf
                        </form>
                    </tr>

                @endforeach
                </tbody>
            </table>
        @endif

    </section>
</x-layout>
