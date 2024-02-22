<x-layout>
    <section>
        <a href="/wallets/create">Create Wallet</a>
        <table class="container">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Balance</th>
                <th scope="col">Transaction Count</th>
                <th scope="col">Delete</th>
            </tr>
            </thead>
            <tbody>


            @foreach($wallets as $wallet)
                <tr>
                    <th scope="row"><a href="/wallets/{{ $wallet->id }}">{{ $wallet->name }}</a></th>
                    <td>{{ $wallet->transactions()->sum('amount') }}</td>
                    <td>{{ $wallet->transactions_count }}</td>

                    <td>
                        <a href="javascript:void(0); document.getElementById('wallet-{{ $wallet->id }}-delete').requestSubmit();">Delete</a>
                        <form onSubmit="return confirm('Do you want to delete this wallet?')"
                              id="wallet-{{ $wallet->id }}-delete"
                              action="/wallets/{{ $wallet->id }}/delete"
                              method="POST" style="display: none;">
                            @csrf
                        </form>
                    </td>

                </tr>

            @endforeach
            </tbody>
        </table>
    </section>
</x-layout>
