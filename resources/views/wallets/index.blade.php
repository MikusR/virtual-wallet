<x-layout>
    <section>
        <a href="/wallets/create">Create</a>
        <table class="container">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Balance</th>
                <th scope="col">Transaction Count</th>
            </tr>
            </thead>
            <tbody>


            @foreach($wallets as $wallet)
                <tr>
                    <th scope="row"><a href="/wallets/{{ $wallet->id }}">{{ $wallet->name }}</a></th>
                    <td>{{ $wallet->balance }}</td>
                    <td>{{ $wallet->transactions_count }}</td>

                </tr>

            @endforeach
            </tbody>
        </table>
    </section>
</x-layout>
